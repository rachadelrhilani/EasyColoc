@extends('layouts.app')

@section('title', 'Bienvenue')

@section('content')
<div class="max-w-5xl mx-auto mt-12 px-4">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight">Bienvenue, {{ Auth::user()->nom }} !</h1>
        <p class="text-lg text-slate-600 mt-4 text-balance">Vous n'êtes pas encore membre d'une colocation. Pour commencer à gérer vos dépenses, choisissez une option :</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-stretch">
        
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8 hover:shadow-xl transition-all duration-300 group flex flex-col">
            <div class="w-16 h-16 bg-indigo-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-slate-800 mb-3">Créer une colocation</h3>
            <p class="text-slate-500 mb-8 flex-grow">Devenez l'administrateur (**Owner**) et invitez vos colocataires à rejoindre votre espace de gestion.</p>
            
            <form action="{{ route('colocation.store') }}" method="POST" class="mt-auto">
                @csrf
                <div class="mb-4">
                    <input type="text" name="nom" placeholder="Nom de la colocation (ex: Appart 42)" 
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition-all placeholder-slate-400" required>
                </div>
                <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-100 active:scale-95">
                    Lancer ma coloc
                </button>
            </form>
        </div>

        <div class="bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200 p-8 flex flex-col items-center text-center group hover:bg-white hover:border-indigo-200 transition-all duration-300">
            <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mb-6 shadow-sm group-hover:rotate-12 transition-transform">
                <svg class="w-8 h-8 text-slate-400 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-slate-800 mb-3">Rejoindre une coloc</h3>
            <p class="text-slate-500 mb-6 italic">Quelqu'un d'autre gère déjà le groupe ?</p>
            
            <div class="w-full p-5 bg-white rounded-2xl border border-slate-100 text-sm text-slate-600 shadow-sm mb-6">
                <p class="mb-3 font-medium">Demandez à votre <span class="text-indigo-600 font-bold">Owner</span> de vous envoyer une invitation sur :</p>
                <code class="block bg-slate-50 p-3 rounded-lg border border-slate-200 font-mono font-bold text-indigo-700 break-all select-all">
                    {{ Auth::user()->email }}
                </code>
            </div>

            <div class="mt-auto flex items-center space-x-2 text-slate-400 animate-pulse">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-slate-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-slate-400"></span>
                </span>
                <span class="text-xs uppercase tracking-widest font-bold">En attente d'invitation par email</span>
            </div>
        </div>

    </div>
</div>
@endsection