<?php

use App\Livewire;
use Illuminate\Support\Facades\Route;

Route::get('{selectedMessageId?}', Livewire\Inbox::class)->name('inbox');
