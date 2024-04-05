<?php

namespace App\Livewire;

use App\Models\Message;
use App\Services\Smtp\Server;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Title('Phost | Inbox')]
class Inbox extends Component
{
    #[Url]
    public string $search = '';

    public ?int $selectedMessageId = null;

    public function mount($selectedMessageId = null)
    {
        $this->selectedMessageId = $selectedMessageId;

        $this->message?->markRead();
    }

    public function selectMessage(int $id)
    {
        $this->selectedMessageId = $id;

        $this->message?->markRead();

        // Not pretty, but most reliable way to ensure properly sized iframe
        // TODO: Hook into render with alpine & dispatch there (or even on the component?)
        $this->dispatch('reload-message-preview');
    }

    public function deleteMessage(int $id)
    {
        Message::findOrFail($id)->delete();

        if ($id === $this->selectedMessageId) {
            $this->selectedMessageId = null;
        }
    }

    public function toggleBookmark(int $id)
    {
        Message::findOrFail($id)->toggleBookmark();

        $this->message?->markRead();

        $this->dispatch('reload-message-preview');
    }

    public function supervisor($previousTotal)
    {
        // Ensure sever is running (fail silently, could be started via multiple windows)
        rescue(
            fn () => Server::new(2525)
                ->onMessageReceived(fn ($content) => Message::fromContent($content))
                ->serve()
        );

        // Skip render when no new messages
        if ($this->inbox->count() !== $previousTotal) {
            $this->dispatch('reload-message-preview');
        } else {
            $this->skipRender();
        }
    }

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
                ->where('content', 'like', '%'.trim($this->search).'%')
            )
            ->orderByDesc('bookmarked')
            ->latest()
            ->get();
    }
}
