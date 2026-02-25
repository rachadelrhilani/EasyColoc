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
                <div class="p-4 flex justify-between items-center hover:bg-slate-50">
                    <span class="font-medium text-slate-700">{{ $cat->nom }}</span>
                    <span class="text-xs text-slate-400 italic">ID: #{{ $cat->id }}</span>
                </div>
            @empty
                <p class="p-8 text-center text-slate-400 italic">Aucune catégorie créée.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection