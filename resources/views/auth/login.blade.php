@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<div class="w-full max-w-md">
    <div class="bg-white rounded-2xl shadow-xl p-8 border border-slate-100">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-slate-800">Bon retour !</h2>
            <p class="text-slate-500 mt-2">Connectez-vous à votre espace colocation</p>
        </div>

        @if($errors->has('email'))
            <div class="mb-4 p-3 bg-red-50 text-red-600 text-sm rounded-lg border border-red-100 italic">
                {{ $errors->first('email') }}
            </div>
        @endif

        <form action="{{ route('auth.login') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Adresse Email</label>
                <input type="email" name="email" required 
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-2">Mot de passe</label>
                <input type="password" name="password" required 
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
            </div>

            <button type="submit" 
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl transition-colors duration-200 shadow-lg shadow-blue-200">
                Se connecter
            </button>
        </form>

        <div class="mt-8 text-center text-sm text-slate-600">
            Pas encore de compte ? 
            <a href="{{ route('auth.register') }}" class="text-blue-600 font-semibold hover:underline">Créer un compte</a>
        </div>
    </div>
</div>
@endsection