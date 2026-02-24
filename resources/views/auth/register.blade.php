@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
<div class="w-full max-w-lg">
    <div class="bg-white rounded-2xl shadow-xl p-8 border border-slate-100">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-slate-800">Rejoindre l'aventure</h2>
            <p class="text-slate-500 mt-2">Créez votre compte en quelques secondes</p>
        </div>

        <form action="{{ route('register') }}" method="POST" class="space-y-5">
            @csrf
            
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Nom complet</label>
                <input type="text" name="nom" value="{{ old('nom') }}"
                    class="w-full px-4 py-3 rounded-xl border @error('nom') border-red-500 @else border-slate-200 @enderror focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                @error('nom') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Email professionnel</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full px-4 py-3 rounded-xl border @error('email') border-red-500 @else border-slate-200 @enderror focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Mot de passe</label>
                    <input type="password" name="password" 
                        class="w-full px-4 py-3 rounded-xl border @error('password') border-red-500 @else border-slate-200 @enderror focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Confirmation</label>
                    <input type="password" name="password_confirmation" 
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                </div>
            </div>

            <button type="submit" 
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-xl transition-colors duration-200 shadow-lg shadow-indigo-200 mt-4">
                Créer mon compte
            </button>
        </form>

        <div class="mt-8 text-center text-sm text-slate-600">
            Déjà membre ? 
            <a href="{{ route('auth.login') }}" class="text-indigo-600 font-semibold hover:underline">Se connecter</a>
        </div>
    </div>
</div>
@endsection