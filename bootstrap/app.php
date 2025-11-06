<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Router;

/*return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        api: __DIR__.'/../routes/api.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();*/

return Application::configure(basePath: \dirname(__DIR__))
    ->withRouting(function (Application $app, Router $router) {
        $router->middleware('api')
            ->prefix('/api')
            ->as('api.')
            ->group($app->basePath('routes/api.php'));

        $router->middleware('web')
            ->group($app->basePath('routes/web.php'));
    })
    // in case you want to keep routes/console.php
    // app/Console/Commands is already registered nonetheless
    ->withCommands([\dirname(__DIR__) . '/routes/console.php'])
    ->withMiddleware(function (Middleware $middleware) {
        // ... your custom Middleware config
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // ...
    })
    ->create();
