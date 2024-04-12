<?php

namespace App\Livewire\Concerns;

use App\Events\MessageReceived;
use App\Models\Message;
use App\Services\Smtp\Server;
use Exception;
use Livewire\Attributes\Renderless;

trait SmtpSupervisor
{
    const PORT = 2525;

    #[Renderless]
    public function supervisor()
    {
        rescue(
            function () {
                Server::new(self::PORT)
                    ->onMessageReceived(function ($content) {

                        MessageReceived::dispatch(
                            Message::fromContent($content)
                        );

                    })->serve();
            },
            report: fn (Exception $e) => ! str($e->getMessage())->contains('EADDRINUSE')
        );
    }
}
