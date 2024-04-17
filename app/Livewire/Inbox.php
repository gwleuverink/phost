<?php

namespace App\Livewire;

use App\Models\Message;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;
use Illuminate\Support\Collection;
use App\Livewire\Concerns\SmtpSupervisor;
use App\Livewire\Concerns\MessageControls;

/**
 * @property ?Message $message
 * @property Collection $inbox
 */
#[Title('Phost | Inbox')]
class Inbox extends Component
{
    use MessageControls;
    use SmtpSupervisor;

    #[Url]
    public string $search = '';

    public ?int $selectedMessageId = null;

    public function mount($messageId = null)
    {
        if ($messageId) {
            $this->selectMessage($messageId);
        }

        // Start the SMTP server
        $this->supervisor(); // TODO: Move to scheduler
    }

    public function selectMessage(int $id)
    {
        $this->selectedMessageId = $id;

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
