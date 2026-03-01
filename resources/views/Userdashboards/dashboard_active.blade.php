@extends('layouts.app')

@section('content')
<div class="p-6 lg:p-10 bg-gray-50 min-h-screen">
    <header class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-slate-800">
                {{ $colocation->nom }}
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
            <p class="text-slate-500 text-sm font-medium uppercase">Votre Solde</p>
            <p class="text-2xl font-black text-slate-900">{{$user->solde}} €</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <p class="text-slate-500 text-sm font-medium uppercase">Reputation</p>
            <p class="text-2xl font-black text-orange-500">{{$user->reputation}}</p>
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
    </div>
</div>
@endsection

