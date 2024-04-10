<?php

namespace App\Livewire;

use App\Models\Message;
use App\Services\Smtp\Server;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Renderless;
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
    }

    #[Renderless]
    public function supervisor()
    {

        // Ensure sever is running (fail silently, could be started via multiple windows)
        // rescue(
        //     fn () => Server::new(2525)
        //         ->onMessageReceived(fn ($content) => Message::fromContent($content))
        //         ->serve()
        // );

        // Skip render when no new messages
        // if ($this->previousInboxTotal <= $this->inbox->count()) {

        //     return $this->skipRender();
        // }

        // $lastMessage = $this->inbox->last();
        // // $this->dispatch('reload-message-preview');
        // $this->previousInboxTotal = $this->inbox->count();

        // $this->notify(
        //     $lastMessage->parsed()->getHeaderValue(Header::FROM),
        //     $lastMessage->parsed()->getHeaderValue(Header::SUBJECT)
        // );
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
