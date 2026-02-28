@extends('layouts.app')

@section('title', 'Bienvenue')


@section('content')
<div class="max-w-4xl mx-auto mt-12">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight">Bienvenue, {{ Auth::user()->nom }} !</h1>
        <p class="text-lg text-slate-600 mt-4">Vous n'êtes pas encore membre d'une colocation. Pour commencer à gérer vos dépenses, choisissez une option :</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8 hover:shadow-xl transition-all duration-300 group">
            <div class="w-16 h-16 bg-indigo-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            </div>
            <h3 class="text-2xl font-bold text-slate-800 mb-3">Créer une colocation</h3>
            <p class="text-slate-500 mb-8">Devenez l'administrateur (**Owner**) et invitez vos colocataires à rejoindre votre espace.</p>
            
            <form action="{{ route('colocation.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <input type="text" name="nom" placeholder="Nom de la colocation (ex: Appart 42)" 
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition-all" required>
                </div>
                <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                    Lancer ma coloc
                </button>
            </form>
        </div>
    </div>
</div>
@endsection