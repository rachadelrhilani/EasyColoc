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
            'statut' => 'active'
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
    public function annulerColocation()
    {
        $owner = auth()->user();

        if ($owner->role !== 'owner' || !$owner->colocation_id) {
            return back()->with('error', 'Action réservée au propriétaire de la colocation.');
        }

        $members = \App\Models\User::where('colocation_id', $owner->colocation_id)->get();

        foreach ($members as $user) {

            $user->reputation += ($user->solde < 0) ? -1 : 1;

            $user->update([
                'role' => 'membre', 
                'colocation_id' => null,
                'statut' => 'quitte',
                'solde' => 0,
                'date_depart' => now(),
            ]);
        }


        $coloc = Colocation::find($owner->colocation_id);
        if ($coloc) {
            $coloc->delete();
        }

        return redirect()->route('dashboard')->with('message', 'La colocation a été annulée. Les réputations ont été mises à jour.');
    }
}
