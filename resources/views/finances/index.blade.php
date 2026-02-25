@extends('layouts.app')

@section('content')
<div class="space-y-8">
    
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <h2 class="text-xl font-bold mb-6 flex items-center text-slate-800">
            <span class="p-2 bg-emerald-100 text-emerald-600 rounded-lg mr-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            </span>
            Nouvelle dépense
        </h2>
        
        <form action="{{ route('depenses.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            @csrf
            <div class="md:col-span-2">
                <input type="text" name="titre" placeholder="Qu'avez-vous acheté ?" required
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
            <div>
                <input type="number" step="0.01" name="montant" placeholder="Montant (€)" required
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none">
            </div>
            <div>
                <select name="categorie_id" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-500 outline-none">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->nom }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-emerald-600 text-white font-bold py-3 px-6 rounded-xl hover:bg-emerald-700 transition shadow-lg shadow-emerald-100">
                Ajouter
            </button>
            <div class="md:col-span-1">
                <input type="date" name="date_depense" value="{{ date('Y-m-d') }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm">
            </div>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
            <h3 class="font-bold text-slate-800 tracking-tight">Historique des dépenses</h3>
            <form action="{{ route('depenses.index') }}" method="GET" class="flex gap-2">
                <select name="mois" onchange="this.form.submit()" class="text-sm rounded-lg border-slate-200">
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}" {{ request('mois', date('m')) == $m ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase font-bold">
                    <tr>
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4">Titre / Catégorie</th>
                        <th class="px-6 py-4">Payé par</th>
                        <th class="px-6 py-4 text-right">Montant</th>
                        <th class="px-6 py-4 text-right">Part / Pers.</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @php $nbMembres = $colocation->membres->count(); @endphp
                    @forelse($depenses as $depense)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="px-6 py-4 text-sm text-slate-500">{{ \Carbon\Carbon::parse($depense->date_depense)->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">
                            <p class="font-semibold text-slate-800">{{ $depense->titre }}</p>
                            <span class="text-[10px] px-2 py-0.5 bg-slate-100 text-slate-500 rounded-full uppercase">{{ $depense->categorie->nom }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <span class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-[10px] font-bold">
                                    {{ substr($depense->user->nom, 0, 1) }}
                                </span>
                                <span class="text-sm text-slate-600">{{ $depense->user->nom }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right font-bold text-slate-900">{{ number_format($depense->montant, 2) }} €</td>
                        <td class="px-6 py-4 text-right text-xs text-slate-400">
                             {{ number_format($depense->montant / max($nbMembres, 1), 2) }} €
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400 italic">Aucune dépense trouvée pour ce mois.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection