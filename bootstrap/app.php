<?php

use Illuminate\Foundation\Application;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))

    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
    )

    ->withSchedule(function (Schedule $schedule) {

        // Make sure the SMTP server is always up
        $schedule->command('serve:smtp')
            ->withoutOverlapping()
            ->everyFiveSeconds()
            ->runInBackground();
    })

    ->withMiddleware(function (Middleware $middleware) {
        //
    })

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })

    ->create();
