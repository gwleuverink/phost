<?php

namespace App\Livewire;

use App\Models\Message;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use App\Services\Smtp\Server;
use Livewire\Attributes\Title;
use App\Events\MessageReceived;
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

        if ($messageId) {
            $this->selectMessage($messageId);
        }
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

    #[On('native:' . MessageReceived::class)]
    public function messageReceived()
    {
        // TODO: Implement NativePHP events
        // https://nativephp.com/docs/1/digging-deeper/broadcasting
        // Laravel websockets doesn't support L11. Can we use Reverb instead? https://laravel.com/docs/11.x/reverb

        dd('Received new message');
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
}
