<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaiementController extends Controller
{
    public function valider(Request $request)
    {
        $validated = $request->validate([
            'payeur_id' => 'required|exists:users,id',
            'receveur_id' => 'required|exists:users,id',
            'montant' => 'required|numeric',
        ]);

        DB::transaction(function () use ($validated) {
            // creer le paiement dans la table paiements
            Paiement::create([
                'payeur_id' => $validated['payeur_id'],
                'receveur_id' => $validated['receveur_id'],
                'montant' => $validated['montant'],
                'colocation_id' => auth()->user()->colocation_id,
            ]);

            User::find($validated['payeur_id'])->increment('solde', $validated['montant']);
            User::find($validated['receveur_id'])->decrement('solde', $validated['montant']);
        });

        return back()->with('message', 'Le remboursement a été pris en compte.');
    }
}
