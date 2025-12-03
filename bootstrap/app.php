<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens(except: [
            // exclude these routes
            '/api/participant/create',
            '/api/participant/finish',
            '/api/profile/create',
            '/api/game/node/add',
            '/api/reading/add',
            '/api/ues/create',
            '/api/test/create',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
