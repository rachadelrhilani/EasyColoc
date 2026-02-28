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
    // affiche categories
    public function indexCategories()
    {
        $user = auth()->user()->load(['colocation.categories']);

        $categories = $user->colocation->categories;

        return view('owner.categories', compact('categories'));
    }
    // ajouter categories
    public function storeCategorie(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:50',
        ]);

        $colocation = auth()->user()->colocation;

        if (!$colocation) {
            return back()->with('error', 'Vous devez appartenir à une colocation.');
        }

        $colocation->categories()->create([
            'nom' => $request->nom
        ]);

        return back()->with('message', 'Catégorie ajoutée avec succès !');
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
