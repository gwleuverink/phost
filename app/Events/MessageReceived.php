<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Native\Laravel\Facades\Notification;
use Illuminate\Foundation\Events\Dispatchable;
use ZBateson\MailMimeParser\Header\HeaderConsts;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class MessageReceived implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    const NOTIFICATION_TITLE = "You've got Phost!";

    public Message $message;

    public function __construct(string $content)
    {
        $this->message = Message::fromContent($content);

        Notification::title(self::NOTIFICATION_TITLE)
            ->message($this->message->parsed->getHeaderValue(HeaderConsts::SUBJECT))
            ->show();
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('nativephp'),
        ];
    }
}
