<?php
use Illuminate\Foundation\Application;
$basePath = dirname(__DIR__);
return Application::configure($basePath)
    ->withProviders([
        App\Providers\EventServiceProvider::class,
    ])
    ->withRouting(
        web: $basePath.'/routes/web.php',
        api: $basePath.'/routes/api.php',
        commands: $basePath.'/routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function ($middleware) {
        $middleware->redirectGuestsTo(function ($request) {
            return $request->is('admin', 'admin/*') ? route('admin.login') : route('login');
        });
    })
    ->withExceptions(function ($exceptions) {
        //
    })
    ->create();
