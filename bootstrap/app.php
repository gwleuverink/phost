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
        // This is here as a fallback for whenever the
        // process spawned by the Inbox component ever crashes.
        // Or is restarted by updating the port in your preferences.
        $schedule->command('smtp:serve')
            // ->withoutOverlapping() // Won't work when enabled
            // ->runInBackground() // Server won't stop when app closes when enabled (note: in final build the process stays alive regardless?)
            ->everyFiveSeconds();
    })

    ->withMiddleware(function (Middleware $middleware) {
        //
    })

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })

    ->create();
