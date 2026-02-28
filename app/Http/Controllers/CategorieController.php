<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
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

    // Mise à jour
    public function update(Request $request, Categorie $category)
    {
        $request->validate(['nom' => 'required|string|max:50']);
        $category->update(['nom' => $request->nom]);

        return back()->with('message', 'Catégorie renommée !');
    }

    // Suppression
    public function destroy(Categorie $category)
    {
        if ($category->depenses()->exists()) {
            return back()->with('error', 'Impossible de supprimer une catégorie utilisée.');
        }

        $category->delete();
        return back()->with('message', 'Catégorie supprimée.');
    }
}
