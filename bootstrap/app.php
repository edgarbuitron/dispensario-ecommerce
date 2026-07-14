<?php
use Illuminate\Foundation\Application;
$basePath = dirname(__DIR__);
return Application::configure($basePath)
    ->withProviders()
    ->withRouting(
        web: $basePath.'/routes/web.php',
        api: $basePath.'/routes/api.php',
        commands: $basePath.'/routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function ($middleware) {
        //
    })
    ->withExceptions(function ($exceptions) {
        //
    })
    ->create();
