@extends('layouts.app')

@section('content')
<div class="p-6 lg:p-10 bg-slate-50 min-h-screen">
    <div class="max-w-6xl mx-auto">
        
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-slate-800">Gestion des Finances</h1>
            <div class="text-sm font-medium text-slate-500 bg-white px-4 py-2 rounded-lg shadow-sm">
                Colocation : <span class="text-indigo-600">{{ $colocation->nom }}</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 sticky top-10">
                    <h2 class="text-xl font-bold text-slate-800 mb-6">Ajouter une dépense</h2>
                    
                    <form action="{{ route('depenses.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Titre</label>
                            <input type="text" name="titre" placeholder="ex: Courses Intermarché" class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Montant (€)</label>
                            <input type="number" step="0.01" name="montant" placeholder="0.00" class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Catégorie</label>
                            <select name="categorie_id" class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none" required>
                                <option value="">Choisir une catégorie</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Date</label>
                            <input type="date" name="date_depense" value="{{ date('Y-m-d') }}" class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none" required>
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 text-white p-4 rounded-xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition">
                            Enregistrer la dépense
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-6">
                
                <form action="{{ route('depenses.index') }}" method="GET" class="flex gap-4 bg-white p-4 rounded-2xl shadow-sm border border-slate-200">
                    <select name="mois" class="bg-slate-50 border-none rounded-lg text-sm font-bold p-2">
                        @for($i=1; $i<=12; $i++)
                            <option value="{{ sprintf('%02d', $i) }}" {{ request('mois', date('m')) == $i ? 'selected' : '' }}>
                                {{ strftime('%B', mktime(0, 0, 0, $i, 10)) }}
                            </option>
                        @endfor
                    </select>
                    <select name="annee" class="bg-slate-50 border-none rounded-lg text-sm font-bold p-2">
                        @for($y=date('Y'); $y>=date('Y')-2; $y--)
                            <option value="{{ $y }}" {{ request('annee', date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                    <button type="submit" class="bg-slate-800 text-white px-4 py-2 rounded-lg text-sm font-bold">Filtrer</button>
                </form>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-50 border-b border-slate-100">
                            <tr>
                                <th class="p-4 text-xs font-bold text-slate-400 uppercase">Détails</th>
                                <th class="p-4 text-xs font-bold text-slate-400 uppercase">Catégorie</th>
                                <th class="p-4 text-xs font-bold text-slate-400 uppercase">Payé par</th>
                                <th class="p-4 text-xs font-bold text-slate-400 uppercase text-right">Montant</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($depenses as $depense)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="p-4">
                                        <p class="font-bold text-slate-700">{{ $depense->titre }}</p>
                                        <p class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($depense->date_depense)->format('d/m/Y') }}</p>
                                    </td>
                                    <td class="p-4 text-sm">
                                        <span class="px-2 py-1 bg-indigo-50 text-indigo-600 rounded-md text-xs font-bold">{{ $depense->categorie->nom }}</span>
                                    </td>
                                    <td class="p-4 text-sm text-slate-600 font-medium">
                                        {{ $depense->payeur->nom }}
                                    </td>
                                    <td class="p-4 text-right font-black text-slate-800">
                                        {{ number_format($depense->montant, 2) }} €
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-10 text-center text-slate-400 italic">
                                        Aucune dépense enregistrée pour cette période.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection