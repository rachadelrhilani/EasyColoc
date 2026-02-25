@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <p class="text-sm text-slate-500 font-medium">Membres</p>
            <p class="text-3xl font-bold text-slate-800">{{ $membres->count() }}</p>
        </div>
        <div class="bg-indigo-600 p-6 rounded-2xl shadow-lg text-white">
            <p class="text-sm text-indigo-100 font-medium">Code Invitation</p>
            <p class="text-2xl font-mono font-bold uppercase">{{ $colocation->code ?? 'N/A' }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <p class="text-sm text-slate-500 font-medium">Budget Total</p>
            <p class="text-3xl font-bold text-slate-800">{{ number_format($totalMontant, 2) }} €</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="text-lg font-bold mb-4 flex items-center">
                <span class="w-2 h-6 bg-indigo-500 rounded-full mr-3"></span>
                Membres de la coloc
            </h3>
            <div class="space-y-4">
                @foreach($membres as $membre)
                <div class="flex items-center justify-between p-3 hover:bg-slate-50 rounded-xl transition">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center font-bold text-slate-600">
                            {{ substr($membre->nom, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800">{{ $membre->nom }}</p>
                            <p class="text-xs text-slate-500">{{ $membre->role }}</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-indigo-600 bg-indigo-50 px-2 py-1 rounded">
                        Rep: {{ $membre->reputation ?? 0 }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="text-lg font-bold mb-4 flex items-center">
                <span class="w-2 h-6 bg-emerald-500 rounded-full mr-3"></span>
                Dernières dépenses
            </h3>
            <div class="space-y-4">
                @forelse($depenses->take(5) as $depense)
                <div class="flex items-center justify-between p-3 border-b border-slate-50 last:border-0">
                    <div>
                        <p class="text-sm font-semibold text-slate-800">{{ $depense->titre }}</p>
                        <p class="text-xs text-slate-500">{{ $depense->created_at->format('d M') }}</p>
                    </div>
                    <p class="font-bold text-slate-900">- {{ number_format($depense->montant, 2) }} €</p>
                </div>
                @empty
                <p class="text-sm text-slate-400 italic">Aucune dépense pour le moment.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection