<?php

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
            'admin' => \App\Http\Middleware\Admin::class,
            'bendahara' => \App\Http\Middleware\Bendahara::class,
            'tu' => \App\Http\Middleware\Tu::class,
            'kepala_sekolah' => \App\Http\Middleware\KepalaSekolah::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();