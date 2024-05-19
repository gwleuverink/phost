<?php

it('returns a successful response', function () {
    $response = $this->get(route('inbox'));
    $response->assertStatus(200);
});

it('displays inbox-zero message when inbox is empty');
it('can display a message');
it('marks message as read when selected');
it('marks message as read when directly routed to');
it('can delete a message');
it('can select previous message');
it('can select next message');
it('can bookmark a message');
it('can remove bookmark from message');
it('listens to server restart event');
