@extends('layouts.app')

@section('content')
<div class="p-6 lg:p-10 bg-slate-50 min-h-screen">
    <div class="max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold text-slate-800 mb-6">Mon Profil</h2>

        @if(session('message'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-xl font-medium">
                {{ session('message') }}
            </div>
        @endif

        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nom complet</label>
                        <input type="text" name="nom" value="{{ old('nom', $user->nom) }}" 
                               class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                        @error('nom') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Adresse Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                               class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <hr class="my-8 border-slate-100">

                    <h3 class="text-lg font-semibold text-slate-800">Modifier le mot de passe</h3>
                    <p class="text-sm text-slate-500 mb-4">Laissez vide si vous ne souhaitez pas le changer.</p>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Mot de passe actuel</label>
                        <input type="password" name="current_password" 
                               class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                        @error('current_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Nouveau mot de passe</label>
                            <input type="password" name="new_password" 
                                   class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                            @error('new_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Confirmer le mot de passe</label>
                            <input type="password" name="new_password_confirmation" 
                                   class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">
                        Sauvegarder les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection