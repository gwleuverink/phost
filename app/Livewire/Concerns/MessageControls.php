<?php

namespace App\Livewire\Concerns;

use App\Models\Message;
use Illuminate\Support\Collection;

trait MessageControls
{
    abstract public function selectMessage(int $id);

    abstract public function inbox(): Collection;

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

    public function selectNext()
    {
        $index = $this->inbox->search(function ($message) {
            return $message->id === $this->selectedMessageId;
        });

        if ($index === false) {
            return;
        }

        $nextMessage = $this->inbox->get($index + 1) ?? $this->inbox->first();

        $this->selectMessage($nextMessage->id);

        unset($this->inbox);
    }

    public function selectPrevious()
    {
        $index = $this->inbox->search(function ($message) {
            return $message->id === $this->selectedMessageId;
        });

        if ($index === false) {
            return;
        }

        $previousMessage = $this->inbox->get($index - 1) ?? $this->inbox->last();

        $this->selectMessage($previousMessage->id);

        unset($this->inbox);
    }
}
