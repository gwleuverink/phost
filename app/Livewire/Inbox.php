<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Phost | Inbox')]
class Inbox extends Component
{
    public function render()
    {
        return view('livewire.inbox');
    }
}
