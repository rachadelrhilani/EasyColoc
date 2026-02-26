<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DepenseController extends Controller
{
    public function index(Request $request)
    {
        // On récupère le mois et l'année pour le filtre (par défaut actuel)
        $mois = $request->get('mois', date('m'));
        $annee = $request->get('annee', date('Y'));

        $user = auth()->user()->load(['colocation.categories', 'colocation.depenses' => function($query) use ($mois, $annee) {
            $query->whereMonth('date_depense', $mois)
                  ->whereYear('date_depense', $annee)
                  ->with(['categorie', 'user']) // Évite le N+1 sur les noms de catégories et payeurs
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
        $collocation = auth()->user()->colocation;

        // creer une depense
        $collocation->depenses()->create([
            'titre' => $validated['titre'],
            'montant' => $validated['montant'],
            'date_depense' => $validated['date_depense'],
            'categorie_id' => $validated['categorie_id'],
            'payeur_id' => auth()->id(), 
        ]);

        return back()->with('message', 'Dépense ajoutée ! Elle a été divisée entre tous les membres.');
    }
}
