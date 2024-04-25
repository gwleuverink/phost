<?php

namespace App\Livewire;

use Livewire\Component;
use App\Enums\Framework;
use Livewire\Attributes\Computed;

class Settings extends Component
{
    public ?string $framework = 'Laravel';

    #[Computed()]
    public function selectedFramework(): ?Framework
    {
        return Framework::tryFrom($this->framework);
    }
}
