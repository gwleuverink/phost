<?php

use App\Models\Message;
use App\Settings\Config;
use App\Livewire\Settings;
use App\Services\Smtp\Server;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can change port')
    ->defer(function () {
        Server::new()->shouldReceive('kill');
    })
    ->livewire(Settings::class)
    ->set('port', 2544)
    ->call('save')
    ->assertHasNoErrors()
    ->defer(function () {
        expect(resolve(Config::class))->port->toBe(2544);
    });

it('port must start with 25')
    ->defer(function () {
        Server::new()->shouldReceive('kill');
    })
    ->livewire(Settings::class)
    ->set('port', 2099)
    ->call('save')
    ->assertHasErrors('port')
    ->set('port', 2599)
    ->call('save')
    ->assertHasNoErrors();

it('restarts server when port changes')
    ->defer(function () {
        Server::new()->shouldReceive('kill')->once();
    })
    ->livewire(Settings::class)
    ->set('port', 2599)
    ->call('save')
    ->assertHasNoErrors();

it('doesnt restart server when port doesnt change')
    ->defer(function () {
        Server::new()->shouldNotReceive('kill');
    })
    ->livewire(Settings::class)
    ->call('save')
    ->assertHasNoErrors();

it('can toggle color schemes')
    ->livewire(Settings::class)
    ->set('theme', 'dark')
    ->call('save')
    ->assertHasNoErrors()
    ->defer(function () {
        expect(resolve(Config::class))->theme->toBe('dark');
    })
    ->set('theme', 'light')
    ->call('save')
    ->assertHasNoErrors()
    ->defer(function () {
        expect(resolve(Config::class))->theme->toBe('light');
    });

it('can delete all messages')
    ->defer(function () {
        Message::factory()->count(2)->create();
        expect(Message::count())->toBe(2);
    })
    ->livewire(Settings::class)
    ->call('clearInbox')
    ->assertRedirect()
    ->defer(function () {
        expect(Message::count())->toBeEmpty();
    });
