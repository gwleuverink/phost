<?php

namespace App\Livewire;

use App\Models\Message;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use App\Services\Smtp\Server;
use Livewire\Attributes\Title;
use App\Events\MessageReceived;
use Native\Laravel\Facades\App;
use App\Livewire\Concerns\Config;
use Livewire\Attributes\Computed;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use App\Livewire\Concerns\MessageControls;

/**
 * @property ?Message $message
 * @property Collection $inbox
 */
#[Title('Phost | Inbox')]
class Inbox extends Component
{
    use Config;
    use MessageControls;

    #[Url]
    public string $search = '';

    public ?int $selectedMessageId = null;

    public function mount($messageId = null)
    {
        $this->restartServer();
        $this->updateBadgeCount();

        if ($messageId) {
            $this->selectMessage($messageId);
        }
    }

    //---------------------------------------------------------------
    // Public API
    //---------------------------------------------------------------
    public function selectMessage(int $id)
    {
        $this->selectedMessageId = $id;

        $this->message?->markRead();

        $this->updateBadgeCount();
    }

    public function restartServer(?int $port = null)
    {
        $port = $port ?? $this->config->port;

        // Kill stray processes on configured port
        Server::new($port)->kill();

        // NativePHP's supervisor seems to be delayed slightly.
        // We'll invoke the serve command immediately and
        // use the scheduler as a restart mechanism.
        Artisan::queue('smtp:serve');
    }

    //---------------------------------------------------------------
    // Computed properties
    //---------------------------------------------------------------
    #[Computed()]
    public function message(): ?Message
    {
        if (! $this->selectedMessageId) {
            return null;
        }

        return Message::find($this->selectedMessageId);
    }

    #[Computed()]
    public function inbox(): Collection
    {
        return Message::query()
            ->when($this->search, fn ($query) => $query
                ->where('content', 'like', '%' . trim($this->search) . '%')
            )
            ->orderByDesc('bookmarked')
            ->latest()
            ->get();
    }

    //---------------------------------------------------------------
    // Listeners
    //---------------------------------------------------------------
    #[On('native:' . MessageReceived::class)]
    public function messageReceived()
    {
        // TODO: Implement Websocket events - not supported in L11
        // https://nativephp.com/docs/1/digging-deeper/broadcasting
        // Can we use Reverb instead? https://laravel.com/docs/11.x/reverb
        // See issue: https://github.com/NativePHP/laravel/issues/295

        $this->updateBadgeCount();

        dd('Received new message');
    }

    //---------------------------------------------------------------
    // System
    //---------------------------------------------------------------
    protected function updateBadgeCount()
    {
        App::badgeCount(Message::unread()->count());
    }
}
