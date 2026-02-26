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
    public function handle(Request $request, Closure $next,...$roles): Response
    {
        if (!auth()->check()) {
            return redirect('/')->with('error', 'Veuillez vous connecter.');
        }

        $user = auth()->user();

        // verifie son role et s'il n'est pas banie
        if (in_array($user->role, $roles) && $user->est_actif) {
            return $next($request);
        }

        if ($user->role === 'owner') {
        return redirect()->route('owner.dashboard')->with('error', 'Accès refusé aux pages membres.');
        }

    
    if ($user->role === 'member') {
        return redirect()->route('dashboard')->with('error', 'Vous devez créer une colocation pour accéder à cet espace.');
    }
    return $next($request);
    }
}
