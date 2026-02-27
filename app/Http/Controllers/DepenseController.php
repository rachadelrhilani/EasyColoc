<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepenseController extends Controller
{
    public function index(Request $request)
    {
        // On récupère le mois et l'année pour le filtre (par défaut actuel)
        $mois = $request->get('mois', date('m'));
        $annee = $request->get('annee', date('Y'));

        $user = auth()->user()->load(['colocation.categories', 'colocation.depenses' => function ($query) use ($mois, $annee) {
            $query->whereMonth('date_depense', $mois)
                ->whereYear('date_depense', $annee)
                ->with(['categorie', 'payeur']) // Évite le N+1 sur les noms de catégories et payeurs
                ->latest();
        }]);

        return view('finances.index', [
            'colocation' => $user->colocation,
            'depenses' => $user->colocation->depenses,
            'categories' => $user->colocation->categories
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:100',
            'montant' => 'required|numeric|min:0.01',
            'date_depense' => 'required|date',
            'categorie_id' => 'required|exists:categories,id',
        ]);

        $userPayeur = auth()->user();
        $collocation = $userPayeur->colocation;
        $membres = $collocation->membres;
        $nombreMembres = $membres->count();

        if ($nombreMembres === 0) {
            return back()->with('error', 'Impossible d\'ajouter une dépense sans membres.');
        }

        $partIndividuelle = $validated['montant'] / $nombreMembres;

        
        DB::transaction(function () use ($validated, $collocation, $userPayeur, $membres, $partIndividuelle) {

            $collocation->depenses()->create([
                'titre' => $validated['titre'],
                'montant' => $validated['montant'],
                'date_depense' => $validated['date_depense'],
                'categorie_id' => $validated['categorie_id'],
                'payeur_id' => $userPayeur->id,
            ]);
            foreach ($membres as $membre) {
                if ($membre->id === $userPayeur->id) {
                    $membre->increment('solde', $validated['montant'] - $partIndividuelle);
                } else {
                    $membre->decrement('solde', $partIndividuelle);
                }
            }
        });

        return back()->with('message', 'Dépense ajoutée ! Les soldes ont été mis à jour.');
    }
}
