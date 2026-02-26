<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\User;
use App\Services\MailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class InvitationController extends Controller
{
    public function envoyer(Request $request)
    {
        // Validation de la requête
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $userAInviter = User::findOrFail($request->user_id);
        $owner = auth()->user();

        // Verifier si l'utilisateur a deje une colocation
        if ($userAInviter->colocation_id !== null) {
            return back()->with('error', 'Cet utilisateur appartient déjà à une colocation.');
        }

        // verifier si une invitation est déjà en attente pour cet email
        $dejaInvite = Invitation::where('email', $userAInviter->email)
            ->where('statut', 'en attente')
            ->where('date_expiration', '>', now())
            ->first();

        if ($dejaInvite) {
            return back()->with('error', 'Une invitation est déjà en cours pour cet utilisateur.');
        }


        // creation de l'invitation en DB
        $invitation = Invitation::create([
            'email'           => $userAInviter->email,
            'token'           => Str::random(40),
            'statut'          => 'en_attente',
            'date_expiration' => now()->addDays(7),
            'colocation_id'   => $owner->colocation_id,
        ]);

        
        // Note : On passe le token dans l'URL pour la retrouver facilement
        $urlAction = URL::temporarySignedRoute(
            'invitation.reponse', 
            now()->addDays(7), 
            ['token' => $invitation->token]
        );

        // envoye l'invitation
        $envoi = MailService::envoyerInvitation(
            $invitation->email, 
            $urlAction, 
            $owner->colocation->nom
        );

        if ($envoi) {
            return back()->with('message', "L'invitation a été envoyée avec succès à {$userAInviter->nom} !");
        } 

        // En cas d'échec de l'envoi, on supprime l'invitation créée pour permettre de réessayer
        $invitation->delete();
        return back()->with('error', "Le serveur mail a rencontré un problème. L'invitation n'a pas pu être envoyée.");
    }
    public function showReponse(Request $request, $token)
    {
        $invitation = Invitation::with('colocation')->where('token', $token)->first();

       
        if (!$invitation) {
            abort(404, "Invitation introuvable.");
        }

        // verifier si l'invitation est toujours en attente
        if ($invitation->statut !== 'en attente') {
            return redirect()->route('login')->with('error', 'Cette invitation a déjà été traitée.');
        }

        // 3. Vérifier l'expiration (sécurité supplémentaire au cas où)
        if (now()->gt($invitation->date_expiration)) {
            $invitation->update(['statut' => 'expire']);
            return redirect()->route('login')->with('error', 'Cette invitation a expiré.');
        }

        return view('invitations.reponse', compact('invitation'));
    }

    public function decider(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'choix' => 'required|in:accepter,refuser'
        ]);

        $invitation = Invitation::where('token', $request->token)->firstOrFail();
        $user = auth()->user();

        // verifier que l'email de l'invitation d'un user connecte
        if ($user->email !== $invitation->email) {
            return redirect()->route('dashboard')->with('error', 'Cette invitation ne vous est pas destinée.');
        }

        if ($request->choix === 'accepter') {
            $user->update([
                'colocation_id' => $invitation->colocation_id,
                'role'          => 'membre',
                'date_adhesion' => now()
            ]);

            $invitation->update(['statut' => 'accepte']);

            return redirect()->route('dashboard')->with('message', 'Félicitations ! Vous avez rejoint la colocation.');
        }

        // Si refus
        $invitation->update(['statut' => 'refuse']);
        return redirect()->route('dashboard')->with('message', 'Invitation déclinée.');
    }
}
