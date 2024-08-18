<?php

use App\Http\Middleware\HttpsMiddleware;
use App\Http\Middleware\Localization;
use App\Http\Middleware\LoginThrottleMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'localization' => Localization::class,
            'httpsEnforce' => HttpsMiddleware::class,
            'loginThrottle' => LoginThrottleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
