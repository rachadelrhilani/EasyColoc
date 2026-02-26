@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-12 bg-white p-8 rounded-3xl shadow-xl border border-slate-100 text-center">
    <div class="w-16 h-16 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
    </div>
    
    <h2 class="text-2xl font-bold text-slate-800">Invitation Reçue !</h2>
    <p class="text-slate-500 mt-2">Vous avez été invité à rejoindre la colocation : <br><strong>{{ $invitation->colocation->nom }}</strong></p>

    <div class="mt-8 flex flex-col gap-3">
        <form action="{{ route('invitation.decider') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $invitation->token }}">
            
            <button name="choix" value="accepter" class="w-full py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">
                Accepter et rejoindre
            </button>
            
            <button name="choix" value="refuser" class="w-full mt-2 py-3 bg-white text-slate-500 rounded-xl font-medium hover:text-rose-600 transition">
                Refuser l'invitation
            </button>
        </form>
    </div>
</div>
@endsection