<?php

use App\Livewire\Inbox;
use App\Models\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('returns a successful response')
    ->livewire(Inbox::class)
    ->assertOk();

it('displays inbox-zero message when inbox is empty')
    ->livewire(Inbox::class)
    ->assertSee('Inbox zero 🎉');

it('displays settings button when inbox is empty')
    ->livewire(Inbox::class)
    ->assertSee('settings')
    ->assertSeeHtml("x-on:click=\"\$dispatch('open-settings-dialog')\"");

it('can displays message in the sidebar', function () {
    $message = Message::factory()->content([
        'title' => 'Shown without explicitly selecting',
    ])->create();

    $this->livewire(Inbox::class)
        ->assertSee('Shown without explicitly selecting')
        ->assertSeeHtml("selectMessage({$message->id}");

    expect($message->fresh())
        ->read_at->toBeNull();
});

it('can display a message', function () {
    $message = Message::factory()->content([
        'title' => 'Shown when visited',
    ])->create();

    $this->livewire(Inbox::class, [$message->id])
        ->assertSee('Shown when visited');
});

it('can select a message', function () {
    $message = Message::factory()->create();

    $this->livewire(Inbox::class)
        ->call('selectMessage', $message->id)
        ->assertSet('selectedMessageId', $message->id);
});

it('marks message as read when selected', function () {
    $message = Message::factory()->create();

    expect($message)->read_at->toBeNull();

    $this->livewire(Inbox::class)->call('selectMessage', $message->id);

    expect($message)->fresh()->read_at->not->toBeNull();
});

it('marks message as read when directly routed to', function () {
    $message = Message::factory()->create();

    expect($message)->read_at->toBeNull();

    $this->livewire(Inbox::class, [$message->id]);

    expect($message)->fresh()->read_at->not->toBeNull();
});

it('can delete a message', function () {
    $message = Message::factory()->create();

    $this->assertModelExists($message);

    $this->livewire(Inbox::class)->call('deleteMessage', $message->id);

    $this->assertModelMissing($message);
});

it('deselects message when deleted', function () {
    $message = Message::factory()->create();

    $this->livewire(Inbox::class, [$message->id])
        ->assertSet('selectedMessageId', $message->id)
        ->call('deleteMessage', $message->id)
        ->assertSet('selectedMessageId', null);
});

it('can select next message', function () {
    $messageOne = Message::factory()->create();
    $messageTwo = Message::factory()->create();

    $this->livewire(Inbox::class, [$messageOne->id])
        ->assertSet('selectedMessageId', $messageOne->id)
        ->call('selectNext')
        ->assertSet('selectedMessageId', $messageTwo->id);
});

it('can select previous message', function () {
    $messageOne = Message::factory()->create();
    $messageTwo = Message::factory()->create();

    $this->livewire(Inbox::class, [$messageTwo->id])
        ->assertSet('selectedMessageId', $messageTwo->id)
        ->call('selectPrevious')
        ->assertSet('selectedMessageId', $messageOne->id);
});

it('can bookmark a message', function () {
    $message = Message::factory()->create();

    expect($message)->bookmarked->toBeFalse();

    // Toggle bookmark on
    $this->livewire(Inbox::class, [$message->id])
        ->call('toggleBookmark', $message->id);

    expect($message)->fresh()->bookmarked->toBeTrue();

});

it('can remove bookmark from message', function () {
    $message = Message::factory()->bookmarked()->create();

    expect($message)->bookmarked->toBeTrue();

    // Toggle bookmark off
    $this->livewire(Inbox::class, [$message->id])
        ->call('toggleBookmark', $message->id);

    expect($message)->fresh()->bookmarked->toBeFalse();
});
