<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Depense;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function statsdashboard()
    {
        $stats = [
            'users_count' => User::where("role","membre")->count(),
            'colocs_count' => Colocation::count(),
            'total_money' => Depense::sum('montant'),
            'banned_count' => User::where('est_actif', false)->count(),
        ];

        $users = User::with('colocation')->where("role","membre")->latest()->get();

        return view('admin.dashboard', compact('stats', 'users'));
    }

    
    public function toggleBan(User $user)
    {
        $user->update(['est_actif' => !$user->est_actif]);

        return back()->with('message', $user->est_actif ? 'Utilisateur réactivé.' : 'Utilisateur banni.');
    }
}
