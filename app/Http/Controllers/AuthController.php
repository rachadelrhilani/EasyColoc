<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:utilisateurs',
            'mot_de_passe' => 'required|min:6'
        ]);

        // verifie s'il est le premier utilisateur inscrit 
        $isFirstUser = User::count() === 0;

        $user = User::create([
            'nom' => $request->nom,
            'email' => $request->email,
            'mot_de_passe' => Hash::make($request->mot_de_passe),
            'role' => $isFirstUser ? 'admin' : 'membre',
            'date_adhesion' => now()
        ]);

        Auth::login($user);

        return response()->json([
            'message' => $isFirstUser
                ? 'Inscription réussie. Vous êtes admin global.'
                : 'Inscription réussie.',
            'user' => $user
        ]);
    }
    
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->mot_de_passe
        ];

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Identifiants invalides'], 401);
        }

        $user = Auth::user();

        if (!$user->est_actif) {
            Auth::logout();
            return response()->json([
                'message' => 'Votre compte a été banni.'
            ], 403);
        }

        return response()->json([
            'message' => 'Connexion réussie',
            'user' => $user
        ]);
    }
}
