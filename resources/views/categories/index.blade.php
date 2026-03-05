@extends('layouts.app')

@section('title', 'Catégories — EasyColoc')

@section('content')
  @php
    $activeColocation = auth()->user()?->activeColocation;
    $canCreateCategory = !empty($activeColocation);
    $canManageCategory = $canManageCategory ?? false;
  @endphp

  <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
    <div>
      <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Catégories</h1>
    </div>
    @if($canCreateCategory)
      <a href="{{ url('/categories/create') }}"><x-button-primary class="shadow-orange-md hover:shadow-orange-glow">Nouvelle catégorie</x-button-primary></a>
    @endif
  </div>

  <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
    <x-card class="p-0 lg:col-span-2 overflow-hidden shadow-xl shadow-slate-200/50 border-0 ring-1 ring-slate-100">
      <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
          <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider text-xs">
            <tr class="border-b border-slate-200">
              <th class="py-4 px-6">Nom</th>
              <th class="py-4 px-6">Couleur</th>
              <th class="py-4 px-6 hidden sm:table-cell">Créée le</th>
              <th class="py-4 px-6 text-right">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            @forelse(($categories ?? []) as $cat)
              <tr class="hover:bg-orange-50/50 transition-colors group">
                <td class="py-4 px-6 font-bold text-slate-800">{{ $cat['name'] ?? '—' }}</td>
                <td class="py-4 px-6">
                  <div class="inline-flex items-center gap-2.5 px-3 py-1.5 rounded-lg bg-white border border-slate-200 shadow-sm group-hover:border-orange-200 transition-colors">
                    <span class="h-3.5 w-3.5 rounded-full shadow-inner" style="background: {{ $cat['color'] ?? '#F53855' }}"></span>
                    <span class="text-xs font-mono font-bold text-slate-600 uppercase">{{ $cat['color'] ?? '#F53855' }}</span>
                  </div>
                </td>
                <td class="py-4 px-6 text-slate-500 font-medium hidden sm:table-cell">{{ $cat['created_at'] ?? '—' }}</td>
                <td class="py-4 px-6 text-right">
                  @if($canManageCategory)
                    <div class="inline-flex gap-3 justify-end items-center">
                      <a href="{{ url('/categories/' . ($cat['id'] ?? 1) . '/edit') }}" class="text-slate-400 hover:text-orange-500 font-bold hover:-translate-y-0.5 transition-all">Éditer</a>
                      <form method="POST" action="{{ url('/categories/' . ($cat['id'] ?? 1)) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?');">
                        @csrf
                        @method('DELETE')
                        <button class="text-slate-400 hover:text-red-500 font-bold hover:-translate-y-0.5 transition-all">Supprimer</button>
                      </form>
                    </div>
                  @endif
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="py-12 text-center">
                  <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-slate-100 text-slate-400 mb-3">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                  </div>
                  <p class="text-slate-500 font-medium text-base">Aucune catégorie existante.</p>
                  <p class="text-slate-400 text-sm mt-1">Commencez par en créer une pour classer vos dépenses.</p>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </x-card>

    <x-card class="p-8 shadow-xl shadow-slate-200/50 border-0 ring-1 ring-slate-100 h-fit sticky top-24">
      <div class="w-12 h-12 rounded-2xl bg-orange-50 flex items-center justify-center text-orange-500 mb-5 shadow-sm">
        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
      </div>
      <h2 class="text-xl font-extrabold text-slate-800 tracking-tight">Conseils d'organisation</h2>
      <p class="mt-3 text-slate-500 font-medium leading-relaxed">
        Gardez des catégories simples et générales pour faciliter la lisibilité des statistiques : Loyer, Courses, Internet, Électricité…
      </p>
      <div class="mt-6 pt-6 border-t border-slate-100">
        <a class="inline-flex items-center gap-2 text-orange-600 font-bold hover:text-orange-700 hover:-translate-x-1 transition-transform" href="{{ $activeColocation ? route('expenses.create', $activeColocation->id) : route('colocations.create') }}">
          Ajouter une dépense 
          <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
        </a>
      </div>
    </x-card>
  </div>
@endsection
