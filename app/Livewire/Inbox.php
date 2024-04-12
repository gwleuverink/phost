<?php

namespace App\Livewire;

use App\Models\Message;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;
use Illuminate\Support\Collection;
use App\Livewire\Concerns\SmtpSupervisor;

/**
 * @property ?Message $message
 */
#[Title('Phost | Inbox')]
class Inbox extends Component
{
    use SmtpSupervisor;

    #[Url]
    public string $search = '';

    public ?int $selectedMessageId = null;

    public function mount($messageId = null)
    {
        if ($messageId) {
            $this->selectedMessageId = $messageId;

            $this->message?->markRead();
        }

        // Start the SMTP server
        $this->supervisor();
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
            ->when($this->search, fn ($query) => $query
                ->where('content', 'like', '%' . trim($this->search) . '%')
            )
            ->orderByDesc('bookmarked')
            ->latest()
            ->get();
    }
}
