@extends('layouts.app')

@section('title', 'Owner Coloc')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <p class="text-sm text-slate-500 font-medium">Membres actifs</p>
            <p class="text-3xl font-bold text-slate-800">{{ Auth::user()->colocation->membres->count() }}</p>
        </div>
        
        <div class="bg-indigo-600 p-6 rounded-2xl shadow-lg shadow-indigo-100 text-white">
            <p class="text-sm text-indigo-100 font-medium">Code d'invitation</p>
            <p class="text-2xl font-mono font-bold mt-1 tracking-widest uppercase">
                {{-- Supposons que tu as une colonne code_invitation --}}
                {{ Auth::user()->colocation->code ?? 'AUCUN' }} 
            </p>
            <p class="text-xs text-indigo-200 mt-2 italic">Partagez ce code pour ajouter des membres</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <p class="text-sm text-slate-500 font-medium">Total Dépenses</p>
            <p class="text-3xl font-bold text-slate-800">{{ Auth::user()->colocation->depenses->sum('montant') }} €</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-50">
            <h3 class="text-lg font-bold">Gestion de la colocation : {{ Auth::user()->colocation->nom }}</h3>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
            <button class="flex items-center justify-between p-4 rounded-xl border border-slate-100 hover:bg-slate-50 transition group">
                <span class="font-semibold text-slate-700">Gérer les catégories de dépenses</span>
                <svg class="w-5 h-5 text-slate-400 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>
            
            <button class="flex items-center justify-between p-4 rounded-xl border border-slate-100 hover:bg-slate-50 transition group">
                <span class="font-semibold text-slate-700">Historique des invitations</span>
                <svg class="w-5 h-5 text-slate-400 group-hover:text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>
        </div>
    </div>
</div>
@endsection