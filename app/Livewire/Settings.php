<?php

namespace App\Livewire;

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
        $validated = $this->validate();
        $this->config->fill($validated)->save();

        // Kill SMTP server with old port number
        // Start the SMTP server with updated port nr (via supervisor command in scheduler)
    }

    #[Computed()]
    public function selectedFramework(): ?Framework
    {
        return Framework::tryFrom($this->framework);
    }
}
