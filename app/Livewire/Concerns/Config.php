<?php

namespace App\Livewire\Concerns;

use Livewire\Attributes\Computed;
use App\Settings\Config as Settings;

/**
 * @property Settings $config
 */
trait Config
{
    #[Computed()]
    public function config(): Settings
    {
        return resolve(Settings::class);
    }
}
