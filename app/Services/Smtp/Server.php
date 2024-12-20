<?php

namespace App\Services\Smtp;

use Mockery;
use React\Socket\SocketServer;
use React\Socket\ServerInterface;
use App\Services\Smtp\Enums\Reply;
use React\EventLoop\LoopInterface;
use App\Services\Smtp\Enums\Command;
use React\EventLoop\StreamSelectLoop;
use React\Socket\ConnectionInterface;
use Illuminate\Support\Facades\Process;

class Server
{
    protected const HOST = '127.0.0.1';

    protected int $port;

    protected LoopInterface $loop;

    protected ?ServerInterface $socket = null;

    /** @var callable(string):void */
    protected $onMessageReceivedCallback; // Needs to be configured by consuming class

    public function __construct(int $port = 2525)
    {
        $this->port = $port;
        $this->loop = new StreamSelectLoop;
    }

    public static function new(int $port = 2525): self
    {
        return resolve(self::class, ['port' => $port]);
    }

    public static function fake()
    {
        $mock = Mockery::mock(self::class, fn ($mock) => $mock
            ->makePartial()
            ->shouldReceive('serve')
            ->shouldReceive('ping')
        );

        app()->bind(self::class, fn () => $mock);
    }

    /**
     * Start the server
     */
    public function serve(): void
    {
        $this->socket = new SocketServer(self::HOST . ':' . $this->port, [], $this->loop);

        logger("SMTP server | Started SMTP server on: {$this->socket->getAddress()}");

        $this->socket->on('connection', function (ConnectionInterface $connection) {

            $content = '';
            $transferring = false;

            logger('SMTP server | ' . Reply::Ready->value . ' - opened SMTP connection on: ' . $connection->getLocalAddress());
            $connection->write(Reply::Ready->value . " Ok!\r\n");

            $connection->on('data', function ($data) use ($connection, &$content, &$transferring) {

                str($data)
                    ->explode(PHP_EOL)
                    ->each(function (string $line) use ($connection, &$content, &$transferring) {

                        $line = str($line)->trim();

                        // -------------------------------------------------------------------
                        // Abort signals
                        // -------------------------------------------------------------------
                        if ($line->startsWith(Command::RESET->value)) {
                            logger('SMTP server | ' . Reply::Okay->value . ' - received RSET');

                            $content = '';
                            $transferring = false;
                            $connection->write(Reply::Okay->value . "SMTP transfer reset!\r\n");

                            return false;
                        }

                        if ($line->startsWith(Command::QUIT->value)) {
                            logger('SMTP server | ' . Reply::Goodbye->value . ' - received QUIT');

                            $transferring = false;
                            $connection->end(Reply::Goodbye->value . " Goodbye!\r\n");

                            return false;
                        }

                        // -------------------------------------------------------------------
                        // Message transfer
                        // -------------------------------------------------------------------
                        if ($transferring) {

                            if ($line->toString() === '.') {
                                logger('SMTP server | ' . Reply::Okay->value . ' - message received!');

                                call_user_func($this->onMessageReceivedCallback, $content);

                                $connection->write(Reply::Okay->value . " Ok!\r\n");
                                $transferring = false;

                                return false;
                            }

                            // All ok. Append message content
                            $content .= $line->append(PHP_EOL)->toString();

                            return true;
                        }

                        // -------------------------------------------------------------------
                        // Handshake ($transferring = false)
                        // -------------------------------------------------------------------
                        if ($line->startsWith(Command::EHLO->value)) {
                            logger('SMTP server | ' . Reply::Okay->value . ' - received ' . $line->toString());
                            $connection->write(Reply::Okay->value . " Ok!\r\n");

                            return false;
                        }

                        if ($line->startsWith(Command::HELO->value)) {
                            logger('SMTP server | ' . Reply::Okay->value . ' - received ' . $line->toString());
                            $connection->write(Reply::Okay->value . " Ok!\r\n");

                            return false;
                        }

                        if ($line->startsWith(Command::FROM_HEADER->value)) {
                            logger('SMTP server | ' . Reply::Okay->value . ' - received MAIL FROM');

                            $connection->write(Reply::Okay->value . " Ok!\r\n");

                            return false;
                        }

                        if ($line->startsWith(Command::RECIPIENT_HEADER->value)) {
                            logger('SMTP server | ' . Reply::Okay->value . ' - received RCPT TO');

                            $connection->write(Reply::Okay->value . " Ok!\r\n");

                            return false;
                        }

                        if ($line->toString() === Command::DATA->value) {
                            logger('SMTP server | ' . Reply::StartTransfer->value . ' - starting message transfer');
                            $connection->write(Reply::StartTransfer->value . " Start transfer\r\n");

                            $transferring = true;

                            return false;
                        }

                        // TODO: Refactor to match & handle default 500 something reply
                        logger('SMTP server | Not implemented - ' . $line->toString());
                        $connection->write(Reply::CommandNotImplemented->value . " Not implemented\r\n"); // Okay
                        $connection->close();

                    });

            });

            $connection->on('close', function () use ($connection) {
                logger('SMTP server | ' . "Closed SMTP connection on: {$connection->getLocalAddress()}");
            });

        });

        $this->loop->run();
    }

    /**
     * Configures a callback to be executed whenever a message is fully recceived
     */
    public function onMessageReceived(callable $callback): self
    {
        $this->onMessageReceivedCallback = $callback;

        return $this;
    }

    /**
     * Stops the currently running server
     * NOTE: Not used since introduction Native ChildProcesses
     */
    public function stop(): void
    {
        if (! $this->socket) {
            return;
        }

        $this->socket->close();
        $this->loop->stop();
    }

    /**
     * Tries to kill the process on the configured Port nr.
     * NOTE: Not used since introduction Native ChildProcesses
     */
    public function kill(): void
    {
        if (PHP_OS_FAMILY === 'Windows') {
            $output = Process::run("netstat -ano | findstr :{$this->port}")->output();

            // Extract the PID from the output
            $parts = explode(' ', $output[0]);
            $pid = trim($parts[count($parts) - 1]);

            if ($pid) {
                Process::run("taskkill /F /PID {$pid}");
            }
        } else {
            // Unix like
            $pid = Process::run("lsof -ti :{$this->port}")->output();

            if ($pid) {
                Process::run("kill {$pid}");
            }
        }

        $this->stop();
    }

    /**
     * Check if a process is alive on the configured port
     * NOTE: Not used since introduction Native ChildProcesses
     */
    public function ping(): bool
    {
        if (PHP_OS_FAMILY === 'Windows') {
            $output = Process::run("netstat -ano | findstr :{$this->port}")->output();

            // Extract the PID from the output
            $parts = explode(' ', $output[0]);
            $pid = trim($parts[count($parts) - 1]);

            return (bool) $pid;
        }

        // Unix like
        $pid = Process::run("lsof -ti :{$this->port}")->output();

        return (bool) $pid;
    }
}
