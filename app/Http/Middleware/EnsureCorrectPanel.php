<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCorrectPanel
{
    public function handle(Request $request, Closure $next): Response
    {
        $routeName = (string) optional($request->route())->getName();

        if (str_contains($routeName, '.auth.login') || str_contains($routeName, '.auth.register')) {
            return $next($request);
        }

        $panel = Filament::getCurrentPanel();
        $user = $request->user();

        if (! $panel || ! $user) {
            return $next($request);
        }

        $requiredRole = match ($panel->getId()) {
            'admin' => 'admin',
            'sender' => 'sender',
            'runner' => 'runner',
            default => null,
        };

        $isAuthorized = match ($panel->getId()) {
            'runner' => $user->hasAnyRole(['runner', 'receiver']),
            default => $requiredRole ? $user->hasRole($requiredRole) : true,
        };

        if (! $isAuthorized) {
            abort(403, 'You are not authorized for this panel.');
        }

        return $next($request);
    }
}
