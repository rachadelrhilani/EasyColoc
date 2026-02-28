@extends('layouts.app')

@section('content')
<div class="p-6 lg:p-10 bg-slate-50 min-h-screen">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center space-x-4 mb-8">
            <div class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-indigo-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
            </div>
            <h2 class="text-3xl font-black text-slate-800 tracking-tight">Paramètres du compte</h2>
        </div>

        <div class="bg-white p-8 rounded-[2rem] shadow-xl shadow-slate-200/50 border border-white">
            <form action="{{ route('profile.update') }}" method="POST" class="space-y-8">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Nom complet</label>
                        <input type="text" name="nom" value="{{ $user->nom }}" 
                               class="w-full px-4 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-2xl text-slate-800 font-medium transition-all focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none placeholder-slate-400"
                               placeholder="Ex: Jean Dupont">
                        @error('nom') <p class="text-red-500 text-xs font-bold mt-2 ml-1 italic">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Adresse Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" 
                               class="w-full px-4 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-2xl text-slate-800 font-medium transition-all focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none"
                               placeholder="votre@email.com">
                        @error('email') <p class="text-red-500 text-xs font-bold mt-2 ml-1 italic">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="h-px bg-gradient-to-r from-transparent via-slate-200 to-transparent my-4"></div>

                <div class="space-y-6">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center">
                        <span class="w-8 h-8 bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                        </span>
                        Changer le mot de passe
                    </h3>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Mot de passe actuel</label>
                        <input type="password" name="current_password" 
                               class="w-full px-4 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-2xl text-slate-800 transition-all focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none">
                        @error('current_password') <p class="text-red-500 text-xs font-bold mt-2 ml-1 italic">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Nouveau mot de passe</label>
                            <input type="password" name="new_password" 
                                   class="w-full px-4 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-2xl text-slate-800 transition-all focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none">
                            @error('new_password') <p class="text-red-500 text-xs font-bold mt-2 ml-1 italic">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Confirmation</label>
                            <input type="password" name="new_password_confirmation" 
                                   class="w-full px-4 py-3.5 bg-slate-50 border-2 border-slate-100 rounded-2xl text-slate-800 transition-all focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none">
                        </div>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full md:w-auto bg-indigo-600 text-white px-10 py-4 rounded-2xl font-black uppercase tracking-wider hover:bg-indigo-700 transition shadow-xl shadow-indigo-200 active:scale-95">
                        Mettre à jour mon profil
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection