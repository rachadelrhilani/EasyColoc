@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
        <h2 class="text-xl font-bold mb-4">Ajouter une catégorie</h2>
        <form action="{{ route('categories.store') }}" method="POST" class="flex gap-4">
            @csrf
            <input type="text" name="nom" placeholder="Ex: Alimentation, Loyer..." 
                class="flex-1 px-4 py-2 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-xl font-semibold hover:bg-indigo-700 transition">
                Ajouter
            </button>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-6 border-b border-slate-50">
        <h3 class="font-bold text-slate-800">Vos catégories actuelles</h3>
    </div>
    <div class="divide-y divide-slate-50">
        @forelse($categories as $cat)
            <div class="p-4 flex justify-between items-center hover:bg-slate-50 group">
                {{-- Affichage & Formulaire d'édition --}}
                <form action="{{ route('categories.update', $cat->id) }}" method="POST" class="flex-1 flex items-center space-x-2">
                    @csrf
                    @method('PATCH')
                    <input type="text" name="nom" value="{{ $cat->nom }}" 
                           class="bg-transparent border-none focus:ring-2 focus:ring-amber-500 rounded-lg px-2 py-1 font-medium text-slate-700 w-full transition-all focus:bg-white focus:border-slate-200">
                    
                    {{-- Bouton de validation (invisible sauf si focus ou hover) --}}
                    <button type="submit" class="hidden group-focus-within:block text-emerald-500 hover:text-emerald-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </button>
                </form>

                {{-- Bouton Suppression --}}
                <form action="{{ route('categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Supprimer cette catégorie ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-2 text-slate-300 hover:text-red-500 transition opacity-0 group-hover:opacity-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </form>
            </div>
        @empty
            <p class="p-8 text-center text-slate-400 italic">Aucune catégorie créée.</p>
        @endforelse
    </div>
</div>
</div>
@endsection