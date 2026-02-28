@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <h2 class="text-xl font-bold mb-4 flex items-center">
            <span class="p-2 bg-indigo-100 text-indigo-600 rounded-lg mr-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
            </span>
            Inviter un nouveau membre
        </h2>

        <form action="{{ route('owner.membres') }}" method="GET" class="relative mb-6">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher par nom..."
                class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition">
            <svg class="w-5 h-5 text-slate-400 absolute left-4 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </form>

        @if(request('search'))
        <div class="space-y-3">
            @forelse($utilisateursDisponibles as $userDispo)
            <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl border border-slate-100">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center font-bold text-indigo-600 shadow-sm">
                        {{ substr($userDispo->nom, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-bold text-slate-800">{{ $userDispo->nom }}</p>
                        <p class="text-xs text-slate-500">Disponible pour une coloc</p>
                    </div>
                </div>
                <form action="{{ route('owner.inviter') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $userDispo->id }}">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg">
                        Envoyer Invitation
                    </button>
                </form>
            </div>
            @empty
            <p class="text-center text-slate-400 py-4 italic">Aucun utilisateur trouvé ou déjà en colocation.</p>
            @endforelse
        </div>
        @endif
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-50">
            <h3 class="font-bold text-slate-800">Membres actuels de la colocation</h3>
        </div>
        <div class="divide-y divide-slate-50">
            @foreach($membresActuels as $m)
            <div class="p-4 flex items-center justify-between hover:bg-slate-50 transition">
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-600 border-2 border-white shadow-sm">
                            {{ substr($m->nom, 0, 1) }}
                        </div>
                        <span class="absolute bottom-0 right-0 w-3 h-3 {{ $m->est_actif ? 'bg-emerald-500' : 'bg-slate-300' }} border-2 border-white rounded-full"></span>
                    </div>
                    <div>
                        <p class="font-bold text-slate-800">{{ $m->nom }}</p>
                        <span class="text-[10px] px-2 py-0.5 rounded-full font-bold uppercase {{ $m->role === 'owner' ? 'bg-amber-100 text-amber-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ $m->role }}
                        </span>
                    </div>
                </div>

                <div class="flex items-center space-x-6 text-right">
                    <div>
                        <p class="text-xs text-slate-400 uppercase font-bold">Réputation</p>
                        <p class="font-bold text-indigo-600">{{ $m->reputation }} pts</p>
                    </div>

                    @if(auth()->user()->role === 'owner' && $m->id !== auth()->id())
                    <form action="{{ route('owner.retirer.membre', $m->id) }}" method="POST"
                        onsubmit="return confirm('Retirer ce membre ? S\'il a une dette, elle sera ajoutée à votre solde.')"
                        class="inline">
                        @csrf
                        <button type="submit" class="p-2 text-slate-300 hover:text-red-500 transition" title="Retirer de la coloc">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection