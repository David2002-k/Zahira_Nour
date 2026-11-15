<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();

        if (! $user || $user->role !== $role) {
            abort(403, 'Accès interdit.');
        }

        if ($role === 'client' && $user->statut === 'bloque') {
            abort(403, 'Votre compte client est bloqué. Veuillez contacter l’administration.');
        }

        return $next($request);
    }
}

