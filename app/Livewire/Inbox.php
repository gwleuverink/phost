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

    public bool $online = false;

    public ?int $selectedMessageId = null;

    public function mount($messageId = null)
    {
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

    public function heartbeat()
    {
        $online = Server::new($this->config->port)->ping();

        // Skip rerender whe the online status didn't change
        if ($this->online === $online) {
            $this->skipRender();
        }

        $this->online = $online;
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
        $this->updateBadgeCount();
    }

    //---------------------------------------------------------------
    // System
    //---------------------------------------------------------------
    protected function updateBadgeCount()
    {
        // Better to  mock this method instead, but since this should be handled
        // by NativePHP (maybe in future) just keep it simple.
        if (app()->runningUnitTests()) {
            return;
        }

        App::badgeCount(Message::unread()->count());
    }
}
