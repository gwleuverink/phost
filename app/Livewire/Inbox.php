<?php

namespace App\Livewire;

use App\Models\Message;
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
    }

    #[Computed]
    public function message(): ?Message
    {
        if (! $this->selectedMessageId) {
            return null;
        }

        $message = Message::find($this->selectedMessageId);

        if (! $message->read_at) {
            $message->update([
                'read_at' => now(),
            ]);
        }

        return $message;
    }

    public function render()
    {
        return view('livewire.inbox', [
            'messages' => Message::latest()->get(),
        ]);
    }
}
