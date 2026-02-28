<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\User;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    // dashboard
    public function dashboard()
    {
        $user = auth()->user()->load(['colocation.membres', 'colocation.depenses']);

        $colocation = $user->colocation;

        if (!$colocation) {
            return redirect()->route('dashboard')->with('error', 'Aucune colocation trouvée.');
        }

        return view('owner.dashboard')
            ->with('colocation', $colocation)
            ->with('membres', $colocation->membres)
            ->with('membre', $user)
            ->with('depenses', $colocation->depenses)
            ->with('totalMontant', $colocation->depenses->sum('montant'));
    }
    
    // recuperer les membres et recherche les membres
    public function membres(Request $request)
    {
        $user = auth()->user()->load('colocation.membres');
        $search = $request->get('search');

        $membresActuels = $user->colocation->membres;

        $utilisateursDisponibles = collect();
        if ($search) {
            $utilisateursDisponibles = User::where('colocation_id', null)
                ->where('role', '!=', 'admin')
                ->where('nom', 'LIKE', "%{$search}%")
                ->where('id', '!=', auth()->id())
                ->limit(5)
                ->get();
        }

        return view('owner.membres', compact('membresActuels', 'utilisateursDisponibles'));
    }

}
