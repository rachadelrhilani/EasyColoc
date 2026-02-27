@extends('layouts.app')

@section('content')
<div class="p-6 lg:p-10 bg-slate-50 min-h-screen">
    <h2 class="text-3xl font-bold text-slate-800 mb-8">Équilibre des comptes</h2>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <h3 class="text-lg font-bold text-slate-700 mb-6">État actuel des membres</h3>
            <div class="space-y-4">
                @foreach($colocation->membres as $m)
                <div class="flex justify-between items-center p-3 rounded-xl {{ $m->solde >= 0 ? 'bg-green-50' : 'bg-red-50' }}">
                    <div class="flex items-center">
                        <div class="h-8 w-8 rounded-full bg-slate-200 flex items-center justify-center font-bold text-xs mr-3">
                            {{ substr($m->nom, 0, 1) }}
                        </div>
                        <span class="font-medium text-slate-700">{{ $m->nom }}</span>
                    </div>
                    <span class="font-bold {{ $m->solde >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $m->solde >= 0 ? '+' : '' }}{{ number_format($m->solde, 2) }} €
                    </span>
                </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <h3 class="text-lg font-bold text-slate-700 mb-6">Comment équilibrer ?</h3>

            @if(count($suggestions) > 0)
            <div class="space-y-4">
                @foreach($suggestions as $s)
                <div class="flex flex-col sm:flex-row items-center justify-between p-4 border border-slate-100 rounded-2xl bg-slate-50/50">
                    <div class="flex items-center space-x-3">
                        <span class="font-bold text-red-500">{{ $s['de']->nom }}</span>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M14 5l7 7m0 0l-7 7m7-7H3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                        <span class="font-bold text-green-600">{{ $s['a']->nom }}</span>
                    </div>

                    <div class="mt-3 sm:mt-0 flex items-center space-x-4">
                        <span class="text-xl font-black text-slate-800">{{ number_format($s['montant'], 2) }} €</span>

                        {{-- On affiche le bouton seulement si l'utilisateur connecté est celui qui doit l'argent --}}
                        @if(auth()->id() === $s['de']->id)
                        <form action="{{ route('paiements.valider') }}" method="POST">
                            @csrf
                            <input type="hidden" name="payeur_id" value="{{ $s['de']->id }}">
                            <input type="hidden" name="receveur_id" value="{{ $s['a']->id }}">
                            <input type="hidden" name="montant" value="{{ $s['montant'] }}">
                            <button type="submit" class="bg-indigo-600 text-white px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-indigo-700 transition">
                                J'ai payé
                            </button>
                        </form>
                        @else
                        {{-- Optionnel : Un petit badge pour indiquer que c'est en attente --}}
                        <span class="text-[10px] bg-slate-100 text-slate-400 px-2 py-1 rounded font-bold uppercase">
                            En attente
                        </span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="py-10 text-center text-slate-400 italic">
                Tout est équilibré ! Personne ne doit rien.
            </div>
            @endif
        </div>
    </div>
</div>
@endsection