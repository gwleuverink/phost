<?php

namespace App\Livewire\Concerns;

use App\Events\MessageReceived;
use App\Models\Message;
use App\Services\Smtp\Server;
use Exception;
use Livewire\Attributes\On;
use Livewire\Attributes\Renderless;

trait SmtpSupervisor
{
    const PORT = 2525;

    /**
     * Called with wire:poll to keep the server alive.
     *
     * TODO: Might be better to move to scheduler when adding NativePHP support
     */
    #[Renderless]
    public function supervisor(): void
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

    /**
     * Echo listener for the MessageReceived event
     *
     * This needs to be called via a channel so we can pick
     * up on events raised from a separate process.
     */
    #[On('native:'.MessageReceived::class)]
    public function messageReceived()
    {
        // TODO: Implement NativePHP events with Echo
        // https://nativephp.com/docs/1/digging-deeper/broadcasting
        // https://laravel.com/docs/11.x/broadcasting#client-side-installation
        // Laravel websockets doesn't support L11. Can we use Reverb instead? https://laravel.com/docs/11.x/reverb

        dd('Received new message');
    }
}
