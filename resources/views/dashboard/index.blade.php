@extends('layouts.app')

@section('title', 'Dashboard — EasyColoc')

@section('content')
  <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-5 animate-[slideDown_0.4s_ease-out]">
    <div>
      <p class="text-sm font-semibold text-orange-600">Bonjour, {{ $userName }}.</p>
      <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Dashboard</h1>
      <p class="mt-2 text-slate-500 font-medium">Vue rapide de votre situation financière.</p>
    </div>
    <div class="flex flex-wrap gap-3">
      <a href="{{ url('/colocations/create') }}"><x-button-primary>Créer une colocation</x-button-primary></a>
      <a href="{{ url('/invitations/accept') }}"><x-button-outline>Rejoindre via token</x-button-outline></a>
    </div>
  </div>

  {{-- Stats --}}
  <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-6">
    <x-card class="p-6">
      <div class="flex items-center justify-between mb-2">
        <div class="text-sm font-bold tracking-wide uppercase text-slate-500">Votre réputation</div>
        <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-orange-100 to-orange-50 shadow-inner flex items-center justify-center">
          <svg class="h-5 w-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
        </div>
      </div>
      <div class="text-4xl font-extrabold text-slate-800 tracking-tight">{{ $reputation ?? 0 }}</div>
      <div class="mt-2 text-sm text-slate-400 font-medium">+1 / -1 selon départ/annulation</div>
    </x-card>

    <x-card class="p-6 relative overflow-hidden group">
      <div class="absolute -right-4 -top-4 bg-green-50 w-24 h-24 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
      <div class="relative z-10 flex items-center justify-between mb-2">
        <div class="text-sm font-bold tracking-wide uppercase text-slate-500">Solde actuel</div>
        <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-green-100 to-green-50 shadow-inner flex items-center justify-center -rotate-6 group-hover:rotate-0 transition-transform">
          <svg class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
      </div>
      <div class="relative z-10 text-4xl font-extrabold @if(($balance??0) >= 0) text-green-600 @else text-red-500 @endif tracking-tight">{{ $balance ?? '0.00' }} <span class="text-xl font-bold opacity-60">MAD</span></div>
      <div class="relative z-10 mt-2 text-sm text-slate-400 font-medium">Positif = on vous doit, Négatif = vous devez</div>
    </x-card>

    <x-card class="p-6">
      <div class="flex items-center justify-between mb-2">
        <div class="text-sm font-bold tracking-wide uppercase text-slate-500">Colocation active</div>
        <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-indigo-100 to-indigo-50 shadow-inner flex items-center justify-center">
          <svg class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
        </div>
      </div>
      <div class="text-2xl font-bold text-slate-800 tracking-tight line-clamp-1 break-all">{{ $activeColocationName ?? 'Aucune colocation' }}</div>
      <div class="mt-3">
        <a href="{{ url('/colocations') }}" class="inline-flex items-center text-sm text-orange-600 hover:text-orange-700 font-bold group">
          Voir détails 
          <svg class="ml-1 flex-shrink-0 w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
      </div>
    </x-card>
  </div>

  {{-- Quick actions + recent expenses --}}
  <div class="mt-10 grid grid-cols-1 lg:grid-cols-2 gap-8">
    <x-card class="p-8">
      <h2 class="text-xl font-extrabold text-slate-800 tracking-tight mb-6 flex items-center gap-2">
        <svg class="w-6 h-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
        Actions rapides
      </h2>
      <div class="flex flex-col sm:flex-row flex-wrap gap-4">
        @if(!empty($activeColocation))
          <a href="{{ route('expenses.create', $activeColocation->id) }}" class="w-full sm:w-auto"><x-button-outline class="w-full">Ajouter dépense</x-button-outline></a>
        @else
          <a href="{{ route('colocations.create') }}" class="w-full sm:w-auto"><x-button-outline class="w-full">Ajouter dépense</x-button-outline></a>
        @endif
        <a href="{{ url('/settlements') }}" class="w-full sm:w-auto"><x-button-outline class="w-full text-slate-600 border-slate-200 hover:border-orange-500">Qui doit à qui</x-button-outline></a>
        <a href="{{ url('/categories') }}" class="w-full sm:w-auto"><x-button-outline class="w-full text-slate-600 border-slate-200 hover:border-orange-500">Catégories</x-button-outline></a>
      </div>
    </x-card>

    <x-card class="p-8">
      <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-extrabold text-slate-800 tracking-tight flex items-center gap-2">
          <svg class="w-6 h-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
          Dernières dépenses
        </h2>
        @if(!empty($activeColocation))
          <a href="{{ route('expenses.index', $activeColocation->id) }}" class="text-orange-600 hover:text-orange-700 text-sm font-bold bg-orange-50 px-3 py-1.5 rounded-full hover:bg-orange-100 transition-colors">Tout voir</a>
        @else
          <a href="{{ route('colocations.index') }}" class="text-orange-600 hover:text-orange-700 text-sm font-bold bg-orange-50 px-3 py-1.5 rounded-full hover:bg-orange-100 transition-colors">Voir colocations</a>
        @endif
      </div>
      
      <div class="overflow-x-auto -mx-8 px-8">
        <table class="w-full text-sm">
          <thead>
            <tr class="text-left border-b-2 border-slate-100 text-slate-400 font-bold uppercase tracking-wider text-xs">
              <th class="pb-3 pr-4">Titre</th>
              <th class="pb-3 px-4">Montant</th>
              <th class="pb-3 pl-4">Date</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            @forelse(($recentExpenses ?? []) as $expense)
              <tr class="hover:bg-slate-50/80 transition-colors group cursor-pointer">
                <td class="py-4 pr-4 font-bold text-slate-700 group-hover:text-orange-600 transition-colors">{{ $expense['title'] ?? '—' }}</td>
                <td class="py-4 px-4 font-bold text-slate-600">{{ $expense['amount'] ?? '0.00' }}</td>
                <td class="py-4 pl-4 font-medium text-slate-400 text-xs">{{ $expense['date'] ?? '—' }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="3" class="py-8 text-center text-sm font-medium text-slate-400 italic">Aucune dépense pour le moment.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </x-card>
  </div>
  
  <style>
    @keyframes slideDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
  </style>
@endsection
