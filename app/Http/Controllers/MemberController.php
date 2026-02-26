<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
{
    $user = auth()->user();

    // Si l'utilisateur a une colocation, on affiche le "vrai" dashboard
    if ($user->colocation_id !== null) {
        // On récupère les infos de la coloc et des membres
        $colocation = $user->colocation;
        $colocataires = User::where('colocation_id', $user->colocation_id)->get();
        
        return view('Userdashboards.dashboard_active', compact('colocation', 'colocataires'));
    }

    // Sinon, on affiche la vue actuelle (celle où il peut créer/rejoindre)
    return view('Userdashboards.dashboard_empty');
}
}
