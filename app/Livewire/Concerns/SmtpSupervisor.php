<?php

namespace App\Livewire\Concerns;

use Exception;
use App\Models\Message;
use Livewire\Attributes\On;
use App\Services\Smtp\Server;
use App\Events\MessageReceived;
use Livewire\Attributes\Renderless;
use Native\Laravel\Facades\Notification;
use ZBateson\MailMimeParser\Header\HeaderConsts;

trait SmtpSupervisor
{
    const PORT = 2525;
    const NOTIFICATION_TITLE = "You've got Phost!";

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

                        $message = Message::fromContent($content);

                        Notification::title(self::NOTIFICATION_TITLE)
                            ->message($message->parsed->getHeaderValue(HeaderConsts::SUBJECT))
                            ->show();

                        MessageReceived::dispatch($message);

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
    #[On('native:' . MessageReceived::class)]
    public function messageReceived()
    {
        // TODO: Implement NativePHP events with Echo
        // https://nativephp.com/docs/1/digging-deeper/broadcasting
        // https://laravel.com/docs/11.x/broadcasting#client-side-installation
        // Laravel websockets doesn't support L11. Can we use Reverb instead? https://laravel.com/docs/11.x/reverb

        dd('Received new message');
    }
}
