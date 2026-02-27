@extends('layouts.app')

@section('content')
<div class="p-6 lg:p-10 bg-gray-50 min-h-screen">
    <header class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-800">
                🏠 {{ $colocation->nom }}
            </h2>
            <p class="text-slate-500 mt-1">Heureux de vous revoir, <span class="font-semibold text-indigo-600">{{ auth()->user()->nom }}</span> !</p>
        </div>
        <div class="flex items-center bg-white shadow-sm border border-slate-200 rounded-2xl p-2 px-4">
            <div class="flex flex-col text-right mr-3">
                <span class="text-xs text-slate-400 uppercase font-bold tracking-wider">Mon Statut</span>
                <span class="text-sm font-bold text-green-600">Membre Actif</span>
            </div>
            <div class="h-10 w-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white font-bold shadow-indigo-200 shadow-lg">
                {{ strtoupper(substr(auth()->user()->nom, 0, 1)) }}
            </div>
        </div>
    </header>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <p class="text-slate-500 text-sm font-medium uppercase">Colocataires</p>
            <p class="text-2xl font-black text-slate-900">{{ $colocataires->count() }} membres</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <p class="text-slate-500 text-sm font-medium uppercase">Dépenses du mois</p>
            <p class="text-2xl font-black text-slate-900">0.00 €</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <span class="text-2xl mb-2 block">📅</span>
            <p class="text-slate-500 text-sm font-medium uppercase">Prochaine Tâche</p>
            <p class="text-2xl font-black text-orange-500">Ménage Salon</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <span class="text-2xl mb-2 block">📢</span>
            <p class="text-slate-500 text-sm font-medium uppercase">Annonces</p>
            <p class="text-2xl font-black text-indigo-600">1 nouvelle</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-5 border-b border-slate-50 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Membres de la tribu
                    </h3>
                </div>
                <div class="p-5 space-y-4">
                    @foreach($colocataires as $coloc)
                    <div class="flex items-center justify-between group">
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full bg-slate-100 border-2 border-white shadow-sm flex items-center justify-center text-slate-600 font-bold mr-3 group-hover:border-indigo-200 transition-all">
                                {{ strtoupper(substr($coloc->nom, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-700">{{ $coloc->nom }}</p>
                                <p class="text-xs text-slate-400 capitalize">{{ $coloc->role }}</p>
                            </div>
                        </div>
                        @if($coloc->id === auth()->id())
                            <span class="text-[10px] bg-indigo-50 text-indigo-600 px-2 py-1 rounded-md font-bold uppercase tracking-tighter">C'est moi</span>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 h-full">
                <div class="flex justify-between items-center mb-8">
                    <h3 class="text-xl font-bold text-slate-800">Derniers mouvements</h3>
                    <button class="text-sm font-bold text-indigo-600 bg-indigo-50 px-4 py-2 rounded-xl hover:bg-indigo-100 transition">Action rapide</button>
                </div>
                
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <div class="bg-slate-50 p-6 rounded-full mb-4">
                        <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h4 class="text-slate-800 font-semibold">Aucune activité récente</h4>
                    <p class="text-slate-400 text-sm max-w-xs mx-auto mt-2">Commencez par ajouter une dépense ou créer une liste de courses !</p>
                </div>

                <div class="mt-8 pt-6 border-t border-slate-50 grid grid-cols-2 gap-4">
                    <button class="flex items-center justify-center gap-2 bg-slate-900 text-white p-4 rounded-2xl font-bold hover:bg-slate-800 transition shadow-lg shadow-slate-200">
                        <span>➕</span> Dépense
                    </button>
                    <button class="flex items-center justify-center gap-2 bg-white border border-slate-200 text-slate-700 p-4 rounded-2xl font-bold hover:bg-slate-50 transition">
                        <span>🗒️</span> Note
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

