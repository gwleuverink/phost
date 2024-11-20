<?php

use App\Services\Smtp\Server;

uses(
    Tests\TestCase::class
)->beforeEach(function () {
    Server::fake();
    Http::fake();
})->in('Feature');
