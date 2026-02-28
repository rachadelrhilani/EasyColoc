<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'current_password' => 'nullable|required_with:new_password|current_password',
            'new_password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        $user->nom = $validated['nom'];
        $user->email = $validated['email'];

        if ($request->filled('new_password')) {
            $user->password = Hash::make($validated['new_password']);
        }

        $user->save();

        return back()->with('message', 'Profil mis à jour avec succès !');
    }
    public function quitterColocation(){
    $user = auth()->user();

    if (!$user->colocation_id || $user->role !== 'membre') {
        return back()->with('error', "Seuls les membres d'une colocation peuvent effectuer cette action.");
    };

    if ($user->solde < 0) {
        $user->reputation -= 1;
        $message = "Vous avez quitté la colocation. Attention, votre solde était négatif, votre réputation a baissé.";
    } else {
        $user->reputation += 1;
        $message = "Félicitations ! Vous avez quitté la colocation en règle, votre réputation a augmenté.";
    }

    $user->update([
        'statut' => 'quitte',
        'colocation_id' => null,
        'date_depart' => now(),
        'solde' => 0, 
    ]);

    return redirect()->route('dashboard')->with('message', $message);
}
}
