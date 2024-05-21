<?php

namespace App\Console\Commands;

use Throwable;
use App\Settings\Config;
use App\Services\Smtp\Server;
use App\Events\MessageReceived;
use Illuminate\Console\Command;

/**
 * This Command spawns a non-blocking SMTP server
 *
 * This command is invoked every second in the background by Laravel's scheduler. Since the process keeps running
 * untill it times out, the 'withoutOverlapping' option prevents the scheduler from restarting the command
 * when it's already running in the background. If the command crashes it will be brought back up in 1s.
 *
 * This system is a bit borky, but a easy enough method to have supervisor-like behaviour inside the NativePHP app
 */
class HandleIncomingMessages extends Command
{
    protected $signature = 'smtp:serve';

    protected $description = 'Starts SMTP server & handles incoming messages';

    public function handle()
    {
        $port = $this->config()->port;

        try {

            logger("SUPERVISOR | Keeping SMTP server alive on :{$port}");

            Server::new($port)
                ->onMessageReceived(
                    fn ($content) => MessageReceived::dispatch($content)
                )->serve();

        } catch (Throwable $th) {

            if (! str($th->getMessage())->contains('EADDRINUSE')) {
                throw $th;
            }

            logger("SUPERVISOR | Port in use :{$port}");

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

    private function config(): Config
    {
        return resolve(Config::class);
    }
}
