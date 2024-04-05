<?php

namespace App\Livewire;

use App\Models\Message;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Inbox')]

class Inbox extends Component
{
    public ?int $selectedMessageId;

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
            ->orderByDesc('bookmarked')
            ->latest()
            ->get();
    }
}
