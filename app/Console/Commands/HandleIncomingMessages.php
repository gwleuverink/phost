<?php

namespace App\Console\Commands;

use App\Models\Message;
use App\Services\Smtp\Server;
use Exception;
use Illuminate\Console\Command;

class HandleIncomingMessages extends Command
{
    protected $signature = 'serve:smtp';

    protected $description = 'Starts SMTP server & handles incoming messages';

    protected Server $server;

    public function __construct()
    {
        parent::__construct();
        $this->server = Server::new(2525);
    }

    public function handle()
    {
        try {

            $this->server
                ->onMessageReceived(fn ($content) => Message::fromContent($content))
                ->serve();

        } catch (Exception $e) {

            $this->server->stop();
            throw $e;
        }

        return Command::SUCCESS;
    }
}
