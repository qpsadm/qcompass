<?php

use App\Http\Middleware\RoleMiddleware;

use App\Http\Middleware\RedirectNonUserDashboard;
use App\Http\Middleware\NoCache;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\PreventBackHistory;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
        $middleware->alias([
            'admin' => AdminMiddleware::class,
            'role' => RoleMiddleware::class,
            'prev' => PreventBackHistory::class,
            'redirect.nonuser.dashboard' => RedirectNonUserDashboard::class,
            'no-cache' => NoCache::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();