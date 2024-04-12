<?php

namespace App\Services\Smtp;

use React\Socket\SocketServer;
use React\Socket\ServerInterface;
use App\Services\Smtp\Enums\Reply;
use React\EventLoop\LoopInterface;
use App\Services\Smtp\Enums\Command;
use ZBateson\MailMimeParser\Message;
use React\EventLoop\StreamSelectLoop;
use React\Socket\ConnectionInterface;

use function Laravel\Prompts\info;
use function Laravel\Prompts\note;
use function Laravel\Prompts\warning;

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
        return new self($port);
    }

    public function serve(): void
    {
        $this->socket = new SocketServer(self::HOST . ':' . $this->port, [], $this->loop);

        info("Started SMTP server on: {$this->socket->getAddress()}");

        $this->socket->on('connection', function (ConnectionInterface $connection) {

            $content = '';
            $transferring = false;

            note(Reply::Ready->value . ' - opened SMTP connection on: ' . $connection->getLocalAddress());
            $connection->write(Reply::Ready->value . " Ok!\r\n");

            $connection->on('data', function ($data) use ($connection, &$content, &$transferring) {

                str($data)
                    ->explode(PHP_EOL)
                    ->each(function (string $line) use ($connection, &$content, &$transferring) {

                        $line = str($line)->trim();

                        // -------------------------------------------------------------------
                        // Message transfer
                        // -------------------------------------------------------------------
                        if ($transferring) {

                            if ($line->toString() === '.') {
                                note(Reply::Okay->value . ' - message received!');
                                $connection->write(Reply::Okay->value . " Ok!\r\n");

                                call_user_func($this->onMessageReceivedCallback, $content);
                                $transferring = false;

                                return false;
                            }

                            $content .= $line->append(PHP_EOL)->toString();

                            return true;

                        }

                        // -------------------------------------------------------------------
                        // Handshake ($transferring = false)
                        // -------------------------------------------------------------------
                        if ($line->startsWith(Command::EHLO->value)) {
                            note(Reply::Okay->value . ' - received ' . $line->toString());
                            $connection->write(Reply::Okay->value . " Ok!\r\n");

                            return false;
                        }

                        if ($line->startsWith(Command::HELO->value)) {
                            note(Reply::Okay->value . ' - received ' . $line->toString());
                            $connection->write(Reply::Okay->value . " Ok!\r\n");

                            return false;
                        }

                        if ($line->startsWith(Command::FROM_HEADER->value)) {
                            note(Reply::Okay->value . ' - received MAIL FROM');

                            $connection->write(Reply::Okay->value . " Ok!\r\n");

                            return false;
                        }

                        if ($line->startsWith(Command::RECIPIENT_HEADER->value)) {
                            note(Reply::Okay->value . ' - received RCPT TO');

                            $connection->write(Reply::Okay->value . " Ok!\r\n");

                            return false;
                        }

                        if ($line->toString() === Command::DATA->value) {
                            note(Reply::StartTransfer->value . ' - starting message transfer');
                            $connection->write(Reply::StartTransfer->value . " Start transfer\r\n");

                            $transferring = true;

                            return false;
                        }

                        if ($line->startsWith(Command::QUIT->value)) {
                            note(Reply::Goodbye->value . ' - closed SMTP connection on: ' . $connection->getLocalAddress());
                            $connection->end(Reply::Goodbye->value . " Goodbye!\r\n");

                            return false;
                        }

                        // TODO: Refactor to match & handle default 500 something reply
                        warning(Reply::CommandNotImplemented->value . ' - ' . $line->toString());
                        $connection->write(Reply::CommandNotImplemented->value . " Not implemented\r\n"); // Okay
                        $connection->close();

                    });

            });

            $connection->on('close', function () use ($connection) {
                note("Closed SMTP connection on: {$connection->getLocalAddress()}");
            });

        });

        $this->loop->run();
    }

    public function stop(): void
    {
        if (! $this->socket) {
            return;
        }

        $this->socket->close();
        $this->loop->stop();
    }

    public function onMessageReceived(callable $callback): self
    {
        $this->onMessageReceivedCallback = $callback;

        return $this;
    }
}
