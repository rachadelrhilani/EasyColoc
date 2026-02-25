<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // affiche le formulaire d'inscription
    public function showRegister()
    {
        return view('auth.register');
    }
   

    public function register(Request $request)
    {
        $request->validate([
            'nom'      => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed', 
        ]);

        $isFirstUser = User::count() === 0;

        $user = User::create([
            'nom'           => $request->nom,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'role'          => $isFirstUser ? 'admin' : 'membre',
            'date_adhesion' => now(),
            'est_actif'     => true,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('message', 'Compte créé avec succès !');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    // la connexion
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            
            $user = Auth::user();

            if (!$user->est_actif) {
                Auth::logout();
                return back()->withErrors(['email' => 'Votre compte est suspendu.']);
            }

            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'votre email ou mot de passe incorrect',
        ])->onlyInput('email');
    }

    // la deconnexion
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
