@extends('layouts.app')

@section('content')
<div class="p-6 lg:p-10 bg-slate-50 min-h-screen">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center space-x-4 mb-8">
            <div class="w-12 h-12 bg-amber-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-amber-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" stroke-width="2"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-black text-slate-800 tracking-tight">Gérer la colocation</h2>
        </div>

        @if(session('message'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl font-bold shadow-sm">
            {{ session('message') }}
        </div>
        @endif

        <div class="bg-white p-8 rounded-[2rem] shadow-xl shadow-slate-200/50 border border-white mb-8">
            <form action="{{ route('owner.coloc.update') }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="mb-6">
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Nom de la colocation</label>
                    <input type="text" name="nom" value="{{ old('nom', $colocation->nom) }}"
                        class="w-full px-4 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-2xl text-slate-800 font-medium focus:bg-white focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 outline-none transition-all">
                    @error('nom') <p class="text-red-500 text-xs font-bold mt-2 ml-1 italic">{{ $message }}</p> @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Description</label>
                    <textarea name="description" rows="3"
                        class="w-full px-4 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-2xl text-slate-800 font-medium focus:bg-white focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 outline-none transition-all">{{ old('description', $colocation->description) }}</textarea>
                    @error('description') <p class="text-red-500 text-xs font-bold mt-2 ml-1 italic">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="bg-amber-500 text-white px-8 py-3 rounded-xl font-black uppercase tracking-wider hover:bg-amber-600 transition shadow-lg shadow-amber-100">
                    Enregistrer les modifications
                </button>
            </form>
        </div>

        <div class="mt-12 pt-8 border-t border-slate-200">
            <h3 class="text-lg font-bold text-slate-800 mb-1">Zone de danger</h3>
            <p class="text-sm text-slate-500 mb-6">Action irréversible impactant tous les membres.</p>

            <div class="p-4 rounded-xl border border-red-200 bg-red-50/30 flex items-center justify-between">
                <p class="text-xs text-red-700 font-medium max-w-md">
                    En annulant la colocation, tous les membres seront expulsés et leurs réputations seront mises à jour selon leurs soldes.
                </p>

                <form action="{{ route('profile.annuler') }}" method="POST" onsubmit="return confirm('Supprimer définitivement la colocation ?');">
                    @csrf
                    <button type="submit" class="text-xs font-bold text-red-600 hover:text-white hover:bg-red-600 border border-red-600 px-4 py-2 rounded-lg transition duration-200">
                        Annuler la coloc
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection