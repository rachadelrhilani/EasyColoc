<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OwnerController extends Controller
{
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
            ->with('depenses', $colocation->depenses) 
            ->with('totalMontant', $colocation->depenses->sum('montant'));
    }
}
