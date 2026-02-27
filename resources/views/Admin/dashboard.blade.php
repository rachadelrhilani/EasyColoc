@extends('layouts.app')

@section('content')
<div class="p-8 bg-slate-100 min-h-screen">
    <h1 class="text-3xl font-bold mb-8">Console d'Administration Global</h1>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
        <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-indigo-500">
            <p class="text-slate-500 text-sm font-medium">Utilisateurs</p>
            <p class="text-2xl font-bold">{{ $stats['users_count'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-emerald-500">
            <p class="text-slate-500 text-sm font-medium">Colocations</p>
            <p class="text-2xl font-bold">{{ $stats['colocs_count'] }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-amber-500">
            <p class="text-slate-500 text-sm font-medium">Flux Total</p>
            <p class="text-2xl font-bold">{{ number_format($stats['total_money'], 2) }} €</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-red-500">
            <p class="text-slate-500 text-sm font-medium">Bannis</p>
            <p class="text-2xl font-bold">{{ $stats['banned_count'] }}</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100">
            <h2 class="text-xl font-bold">Gestion des comptes</h2>
        </div>
        <table class="w-full text-left">
            <thead class="bg-slate-50">
                <tr>
                    <th class="p-4">Utilisateur</th>
                    <th class="p-4">Rôle</th>
                    <th class="p-4">Colocation</th>
                    <th class="p-4">Statut</th>
                    <th class="p-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($users as $user)
                <tr>
                    <td class="p-4 font-medium">{{ $user->nom }} <br> <span class="text-xs text-slate-400">{{ $user->email }}</span></td>
                    <td class="p-4"><span class="px-2 py-1 rounded-md text-xs font-bold uppercase {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-slate-100' }}">{{ $user->role }}</span></td>
                    <td class="p-4 text-slate-600">{{ $user->colocation->nom ?? 'Aucune' }}</td>
                    <td class="p-4">
                        @if($user->est_actif)
                            <span class="text-emerald-600 font-bold text-sm">✓ Actif</span>
                        @else
                            <span class="text-red-600 font-bold text-sm">⚠ Banni</span>
                        @endif
                    </td>
                    <td class="p-4 text-right">
                        <form action="{{ route('admin.users.ban', $user) }}" method="POST">
                            @csrf
                            <button class="px-4 py-2 {{ $user->est_actif ? 'bg-red-50 text-red-600' : 'bg-emerald-50 text-emerald-600' }} rounded-lg text-xs font-bold hover:shadow-sm transition">
                                {{ $user->est_actif ? 'Bannir' : 'Réactiver' }}
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4 bg-slate-50">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection