<?php

use Illuminate\Foundation\Application;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Native\Laravel\Http\Middleware\PreventRegularBrowserAccess;

return Application::configure(basePath: dirname(__DIR__))

    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
    )

    ->withSchedule(function (Schedule $schedule) {
        //
    })

    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(PreventRegularBrowserAccess::class);
    })

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })

    ->create();
