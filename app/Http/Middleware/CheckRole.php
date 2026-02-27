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

        if (empty($roles)) {
            return $next($request);
        }
        if ($user->role === 'admin') {
            if (!$request->routeIs('dashboard')) {
                return redirect()->route('dashboard')->with('error', 'Accès refusé à cette zone.');
            }
        }

        if (in_array($user->role, $roles) && $user->est_actif) {
            return $next($request);
        }

        if ($user->role === 'owner') {
            if (!$request->routeIs('owner.dashboard')) {
                return redirect()->route('owner.dashboard')->with('error', 'Accès réservé.');
            }
        }

        if ($user->role === 'member') {
            // Si on n'est pas déjà sur le dashboard member, on y va
            if (!$request->routeIs('dashboard')) {
                return redirect()->route('dashboard')->with('error', 'Accès refusé à cette zone.');
            }
        }


        return $next($request);
    }
}
