<?php

namespace App\Livewire;

use App\Models\Message;
use Livewire\Component;
use App\Enums\Framework;
use App\Livewire\Concerns\Config;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;

class Settings extends Component
{
    use Config;

    public ?string $framework = 'Laravel';

    #[Validate('required|numeric|min_digits:4|starts_with:25')]
    public int $port;

    public function mount()
    {
        $this->fill($this->config->toArray());
    }

    public function save()
    {
        $oldPort = $this->config->port;

        $validated = $this->validate();
        $this->config->fill($validated)->save();

        $this->dispatch('close-settings-dialog');

        // Kill SMTP server with old port number
        if ($this->port !== $oldPort) {
            // TODO: Start the SMTP server with updated port nr (via supervisor command in scheduler)
        }
    }

    public function clearInbox()
    {
        Message::query()->truncate();

        return $this->redirectRoute('inbox', navigate: true);
    }

    #[Computed()]
    public function selectedFramework(): ?Framework
    {
        return Framework::tryFrom($this->framework);
    }
}
