<?php

namespace App\Livewire;

use Livewire\Component;
use App\Enums\Framework;
use App\Livewire\Concerns\Config;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use App\Livewire\Concerns\SmtpSupervisor;

class Settings extends Component
{
    use Config;
    use SmtpSupervisor;

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

        // Start the SMTP server with updated port nr
        $this->supervisor();
    }

    #[Computed()]
    public function selectedFramework(): ?Framework
    {
        return Framework::tryFrom($this->framework);
    }
}
