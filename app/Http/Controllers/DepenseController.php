<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepenseController extends Controller
{
    public function index(Request $request)
    {
        // recupere les values de l'input
        $mois = $request->get('mois', date('m'));
        $annee = $request->get('annee', date('Y'));

        $user = auth()->user()->load(['colocation.categories', 'colocation.depenses' => function ($query) use ($mois, $annee) {
            $query->whereMonth('date_depense', $mois)
                ->whereYear('date_depense', $annee)
                ->with(['categorie', 'payeur'])
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

        // exclus le membre qui a depense
        $autresMembres = $membres->where('id', '!==', $userPayeur->id);
        $nombreAutres = $autresMembres->count();

        if ($nombreAutres === 0) {
            return back()->with('error', 'Impossible d\'ajouter une dépense sans membres.');
        }

        $partIndividuelle = $validated['montant'] / $nombreAutres;


        DB::transaction(function () use ($validated, $collocation, $userPayeur, $autresMembres, $partIndividuelle) {

            $collocation->depenses()->create([
                'titre' => $validated['titre'],
                'montant' => $validated['montant'],
                'date_depense' => $validated['date_depense'],
                'categorie_id' => $validated['categorie_id'],
                'payeur_id' => $userPayeur->id,
            ]);
            $userPayeur->increment('solde', $validated['montant']);

            foreach ($autresMembres as $membre) {
                $membre->decrement('solde', $partIndividuelle);
            }
        });

        return back()->with('message', 'Dépense ajoutée ! Les soldes ont été mis à jour.');
    }
    public function balances()
    {
        $user = auth()->user();
        $colocation = $user->colocation->load('membres');

        $debiteurs = $colocation->membres->where('solde', '<', 0)->sortBy('solde');
        $crediteurs = $colocation->membres->where('solde', '>', 0)->sortByDesc('solde');

        $suggestions = [];

        // calcule de remboursement
        foreach ($debiteurs as $debiteur) {
            $montantDu = abs($debiteur->solde);

            foreach ($crediteurs as $crediteur) {
                if ($montantDu <= 0) break;
                if ($crediteur->solde <= 0) continue;

                $montantAPayer = min($montantDu, $crediteur->solde);

                $suggestions[] = [
                    'de' => $debiteur,
                    'a' => $crediteur,
                    'montant' => $montantAPayer
                ];

                $montantDu -= $montantAPayer;
                $crediteur->solde -= $montantAPayer;
            }
        }

        return view('finances.balances', compact('colocation', 'suggestions'));
    }
}
