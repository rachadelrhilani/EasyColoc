<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect('/')->with('error', 'Veuillez vous connecter.');
        }

        $user = auth()->user();

        // 1. Si la route n'exige aucun rôle spécifique (ex: invitation), on laisse passer
        if (empty($roles)) {
            return $next($request);
        }

        // 2. Si l'utilisateur possède l'un des rôles requis
        if (in_array($user->role, $roles) && $user->est_actif) {
            return $next($request);
        }

        // --- PRÉVENTION DE LA BOUCLE DE REDIRECTION ---

        // 3. Redirection pour les Owners
        if ($user->role === 'owner') {
            // Si on n'est pas déjà sur le dashboard owner, on y va
            if (!$request->routeIs('owner.dashboard')) {
                return redirect()->route('owner.dashboard')->with('error', 'Accès réservé.');
            }
        }

        // 4. Redirection pour les Members
        if ($user->role === 'member') {
            // Si on n'est pas déjà sur le dashboard member, on y va
            if (!$request->routeIs('dashboard')) {
                return redirect()->route('dashboard')->with('error', 'Accès refusé à cette zone.');
            }
        }

        // Si on arrive ici et qu'on n'a pas pu rediriger proprement, on laisse passer ou on bloque
        return $next($request);
    }
}
