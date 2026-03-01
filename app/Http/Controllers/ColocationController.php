<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\User;
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
        $updateData = [
            'colocation_id' => $colocation->id,
        ];


        if ($user->role !== 'admin') {
            $updateData['role'] = 'owner';
        }

        $user->update($updateData);


        return redirect()->route('owner.dashboard')->with('message', 'Colocation créée avec succès !');
    }
    public function annulerColocation()
    {
        $owner = auth()->user();

        if (!in_array($owner->role, ['owner', 'admin']) || !$owner->colocation_id) {
            return back()->with('error', 'Action réservée au propriétaire de la colocation.');
        }

        $members = User::where('colocation_id', $owner->colocation_id)->get();

        foreach ($members as $user) {
            $user->reputation += ($user->solde < 0) ? -1 : 1;

            $updateData = [
                'colocation_id' => null,
                'statut' => 'quitte',
                'solde' => 0,
                'date_depart' => now(),
            ];

            if ($user->role !== 'admin') {
                $updateData['role'] = 'membre';
            }

            $user->update($updateData);
        }


        $coloc = Colocation::find($owner->colocation_id);
        if ($coloc) {
            $coloc->delete();
        }

        return redirect()->route('dashboard')->with('message', 'La colocation a été annulée. Les réputations ont été mises à jour.');
    }
    public function edit()
    {
        $colocation = auth()->user()->colocation;

        if (!$colocation || !in_array(auth()->user()->role, ['owner', 'admin'])) {
            return redirect()->route('dashboard')->with('error', 'Accès réservé au propriétaire.');
        }

        return view('owner.colocation.edit', compact('colocation'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string|max:500'
        ]);

        $colocation = auth()->user()->colocation;

        $colocation->update([
            'nom' => $request->nom,
            'description' => $request->description
        ]);

        return back()->with('message', 'Informations de la colocation mises à jour.');
    }
}
