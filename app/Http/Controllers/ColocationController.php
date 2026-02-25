<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use Illuminate\Container\Attributes\Auth as AttributesAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ColocationController extends Controller
{
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        // Creer la colocation
        $colocation = Colocation::create([
            'nom' => $request->nom,
            'description' => $request->description ?? 'Nouvelle colocation',
            'statut' => 'actif'
        ]);


        // user connecté
        $user = auth()->user();

        // lie avec la colocation 
        $user->update([
            'colocation_id' => $colocation->id,
            'role' => 'owner'
        ]);

        return redirect()->route('owner.dashboard')->with('message', 'Colocation cree avec succes !');
    }
}
