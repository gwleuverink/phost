<?php

namespace App\Livewire;

use App\Events\MessageReceived;
use App\Livewire\Concerns\SmtpSupervisor;
use App\Models\Message;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Title('Phost | Inbox')]
class Inbox extends Component
{
    use SmtpSupervisor;

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

    #[On('native:'.MessageReceived::class)]
    public function messageReceived()
    {
        // TODO: Implement NativePHP events with Echo
        // https://nativephp.com/docs/1/digging-deeper/broadcasting
        // https://laravel.com/docs/11.x/broadcasting#client-side-installation
        // Laravel websockets doesn't support L11. Can we use Reverb instead? https://laravel.com/docs/11.x/reverb

        dd('Received new message');
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
