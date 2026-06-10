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
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'prevent-back-history' => \App\Http\Middleware\PreventBackHistory::class,
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'kepala_uptd' => \App\Http\Middleware\KepalaUptdMiddleware::class,
            'kepala_tpu' => \App\Http\Middleware\KepalaTpuMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
