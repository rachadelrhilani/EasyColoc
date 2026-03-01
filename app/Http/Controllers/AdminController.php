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
            'users_count' => User::where("role", "membre")->count(),
            'colocs_count' => Colocation::count(),
            'total_money' => Depense::sum('montant'),
            'banned_count' => User::where('est_actif', false)->count(),
        ];

        $users = User::with('colocation')->where("role", "!=", "admin")->latest()->get();

        return view('admin.dashboard', compact('stats', 'users'));
    }


    public function toggleBan(User $user)
    {
        $user->update(['est_actif' => !$user->est_actif]);

        if (!$user->est_actif && $user->role === 'owner') {

            $nouveauOwner = User::where('colocation_id', $user->colocation_id)
                ->where('id', '!=', $user->id)
                ->where('est_actif', true)
                ->orderBy('date_adhesion', 'asc')
                ->first();

            if ($nouveauOwner) {
                if ($nouveauOwner->role !== 'admin') {
                    $nouveauOwner->update(['role' => 'owner']);
                }

                if ($user->role !== 'admin') {
                    $user->update(['role' => 'membre']);
                }
            }
        }

        $message = $user->est_actif ? 'Utilisateur réactivé.' : 'Utilisateur banni et succession organisée.';
        return back()->with('message', $message);
    }
}
