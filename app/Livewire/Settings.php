<?php

namespace App\Livewire;

use App\Models\Message;
use Livewire\Component;
use App\Enums\Framework;
use App\Services\Smtp\Server;
use App\Livewire\Concerns\Config;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;

/**
 * Note that the property casing is non-standard, because we're mapping directly to the config object
 */
class Settings extends Component
{
    use Config;

    public ?string $framework = 'Laravel';

    #[Validate('required|numeric|min_digits:4|starts_with:25')]
    public int $port;

    #[Validate('required|in:light,dark')]
    public string $theme;

    public function mount()
    {
        $this->fill($this->config->toArray());
    }

    //---------------------------------------------------------------
    // Public API
    //---------------------------------------------------------------
    public function save()
    {
        $oldPort = $this->config->port;

        $validated = $this->validate();

        $this->config->fill($validated)->save();

        $this->activateTheme();
        $this->dispatch('close-settings-dialog');

        // Stop the server & restart picked up by the scheduler
        if ($this->port !== $oldPort) {
            Server::new($oldPort)->kill();
        }
    }

    public function clearInbox()
    {
        Message::query()->truncate();

        return $this->redirectRoute('inbox', navigate: true);
    }

    //---------------------------------------------------------------
    // Hooks
    //---------------------------------------------------------------
    public function updatedTheme()
    {
        $this->activateTheme();
    }

    //---------------------------------------------------------------
    // Computed properties
    //---------------------------------------------------------------
    #[Computed()]
    public function selectedFramework(): ?Framework
    {
        return Framework::tryFrom($this->framework);
    }

    //---------------------------------------------------------------
    // MISC
    //---------------------------------------------------------------
    public function activateTheme()
    {
        match ($this->theme) {
            'dark' => $this->js(<<< 'JS'
                document.documentElement.classList.remove('light');
                document.documentElement.classList.add('dark')
            JS),
            'light' => $this->js(<<< 'JS'
                document.documentElement.classList.remove('dark');
                document.documentElement.classList.add('light')
            JS),
            default => fn () => null
        };
    }
}
