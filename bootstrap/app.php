<?php

use App\Exceptions\ExceptionHandler;
use App\Http\Middleware\AdminAuthMiddleware;
use App\Http\Middleware\PermissionMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpFoundation\Response;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => AdminAuthMiddleware::class,
            'permission' => PermissionMiddleware::class,
        ]);
    })->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render([ExceptionHandler::class, 'handle']);
    })->create();
