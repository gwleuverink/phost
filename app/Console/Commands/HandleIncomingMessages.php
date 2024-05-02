<?php

namespace App\Console\Commands;

use App\Models\Message;
use App\Services\Smtp\Server;
use Illuminate\Console\Command;

class HandleIncomingMessages extends Command
{
    protected $signature = 'smtp:serve';

    protected $description = 'Starts SMTP server & handles incoming messages';

    public function handle()
    {
        Server::new(2525)
            ->onMessageReceived(fn ($content) => Message::fromContent($content))
            ->serve();

        return Command::SUCCESS;
    }
}
