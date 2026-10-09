<?php

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');
        $middleware->redirectGuestsTo(fn (Request $request): string => route('pasien.login'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        $exceptions->render(function (QueryException $exception, Request $request) {
            if (! $request->routeIs('pasien.register')) {
                return null;
            }

            return to_route('pasien.daftar')
                ->withInput($request->except(['_token', 'password', 'password_confirmation']))
                ->with('registration_error', 'Pendaftaran gagal diproses karena ada masalah pada server. Silakan coba kembali nanti.');
        });
    })->create();
