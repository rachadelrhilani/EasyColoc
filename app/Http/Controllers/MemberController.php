<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
{
    $user = auth()->user();

    if ($user->colocation_id !== null) {
        // On recupere les infos de la coloc et des membres
        $colocation = $user->colocation;
        $colocataires = User::where('colocation_id', $user->colocation_id)->get();
        
        return view('Userdashboards.dashboard_active', compact('colocation', 'colocataires','user'));
    }

    return view('Userdashboards.dashboard_empty');
}
}
