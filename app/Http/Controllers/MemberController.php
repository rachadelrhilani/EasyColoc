<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->colocation_id !== null) {
            // On recupere les infos de la coloc et des membres
            $colocation = $user->colocation;
            $colocataires = User::where('colocation_id', $user->colocation_id)->get();

            return view('Userdashboards.dashboard_active', compact('colocation', 'colocataires', 'user'));
        }

        return view('Userdashboards.dashboard_empty');
    }
    public function retirerMembre(User $membre)
    {
        $owner = auth()->user();

        if ($owner->role !== 'owner' || $membre->colocation_id !== $owner->colocation_id) {
            return back()->with('error', 'Action non autorisée.');
        }

        if ($membre->solde < 0) {
            $owner->solde += $membre->solde;
            $owner->save();
            $membre->reputation -= 1;
        } else {
            $membre->reputation += 1;
        }

        $membre->update([
            'colocation_id' => null,
            'role' => 'membre',
            'statut' => 'quitte',
            'solde' => 0, 
            'date_depart' => now()
        ]);

        return back()->with('message', "Le membre a été retiré. Les dettes ont été transférées à votre solde.");
    }
}
