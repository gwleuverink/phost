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
        $schedule->command('smtp:serve')
            // So the command won't overlap for the next minute (sub-minute will be blocked regardless)
            ->withoutOverlapping()
            // Don't run in background, so the process closes when the app closes
            // ->runInBackground()
            ->everySecond();
    })

    ->withMiddleware(function (Middleware $middleware) {
        //
    })

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })

    ->create();
