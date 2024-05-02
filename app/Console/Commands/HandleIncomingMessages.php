<?php

namespace App\Console\Commands;

use App\Models\Message;
use App\Settings\Config;
use App\Services\Smtp\Server;
use App\Events\MessageReceived;
use Illuminate\Console\Command;
use Native\Laravel\Facades\Notification;
use ZBateson\MailMimeParser\Header\HeaderConsts;

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

    const NOTIFICATION_TITLE = "You've got Phost!";

    public function handle()
    {
        $port = $this->config()->port;
        logger("SUPERVISOR | Starting SMTP server on :{$port}");

        Server::new($port)
            ->onMessageReceived(function ($content) {

                $message = Message::fromContent($content);
                MessageReceived::dispatch($message);

                // Running as NativePHP app. Send out system notifications
                if (config('nativephp-internal.running')) {

                    Notification::title(self::NOTIFICATION_TITLE)
                        ->message($message->parsed->getHeaderValue(HeaderConsts::SUBJECT))
                        ->show();
                }

            })->serve();

        return Command::SUCCESS;
    }

    private function config(): Config
    {
        return resolve(Config::class);
    }
}
