<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Depense;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'users_count' => User::count(),
            'colocs_count' => Colocation::count(),
            'total_money' => Depense::sum('montant'),
            'banned_count' => User::where('est_actif', false)->count(),
        ];

        $users = User::with('colocation')->latest()->paginate(10);

        return view('admin.dashboard', compact('stats', 'users'));
    }
}
