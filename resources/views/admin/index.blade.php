@extends('layouts.app')

@section('title', 'Admin global — EasyColoc')

@section('content')
  <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 animate-[slideDown_0.4s_ease-out]">
    <div>
      <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Administration globale</h1>
      <p class="mt-2 text-sm text-slate-500 font-medium">Statistiques et gestion des utilisateurs de la plateforme.</p>
    </div>
    <a href="{{ url('/dashboard') }}" class="text-orange-600 hover:text-orange-700 bg-orange-50 hover:bg-orange-100 px-4 py-2 rounded-full font-bold text-sm transition-colors flex items-center gap-1.5">
      <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
      Dashboard
    </a>
  </div>

  {{-- Stats --}}
  <div class="mt-10 grid grid-cols-2 lg:grid-cols-4 gap-6">
    <x-card class="p-6 group hover:-translate-y-1">
      <div class="flex items-center justify-between mb-3">
        <div class="text-sm font-bold uppercase tracking-wide text-slate-500">Utilisateurs</div>
        <div class="h-10 w-10 rounded-xl bg-orange-50 shadow-inner flex items-center justify-center group-hover:scale-110 group-hover:bg-orange-100 transition-all">
          <svg class="h-5 w-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
      </div>
      <div class="text-4xl font-extrabold text-slate-800">{{ $stats['users'] }}</div>
    </x-card>
    
    <x-card class="p-6 group hover:-translate-y-1">
      <div class="flex items-center justify-between mb-3">
        <div class="text-sm font-bold uppercase tracking-wide text-slate-500">Colocations</div>
        <div class="h-10 w-10 rounded-xl bg-indigo-50 shadow-inner flex items-center justify-center group-hover:scale-110 group-hover:bg-indigo-100 transition-all">
          <svg class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
        </div>
      </div>
      <div class="text-4xl font-extrabold text-slate-800">{{ $stats['colocations'] }}</div>
    </x-card>
    
    <x-card class="p-6 group hover:-translate-y-1">
      <div class="flex items-center justify-between mb-3">
        <div class="text-sm font-bold uppercase tracking-wide text-slate-500">Dépenses</div>
        <div class="h-10 w-10 rounded-xl bg-green-50 shadow-inner flex items-center justify-center group-hover:scale-110 group-hover:bg-green-100 transition-all">
          <svg class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
      </div>
      <div class="text-4xl font-extrabold text-slate-800">{{ $stats['expenses'] }}</div>
    </x-card>
    
    <x-card class="p-6 group hover:-translate-y-1">
      <div class="flex items-center justify-between mb-3">
        <div class="text-sm font-bold uppercase tracking-wide text-slate-500">Bannis</div>
        <div class="h-10 w-10 rounded-xl bg-red-50 shadow-inner flex items-center justify-center group-hover:scale-110 group-hover:bg-red-100 transition-all">
          <svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
        </div>
      </div>
      <div class="text-4xl font-extrabold text-red-500">{{ $stats['banned'] }}</div>
    </x-card>
  </div>

  {{-- Users table --}}
  <div class="mt-10">
    <x-card class="p-8">
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <h2 class="text-xl font-extrabold text-slate-800 tracking-tight flex items-center gap-2">
          <svg class="w-6 h-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
          Gestion des utilisateurs
        </h2>
        <form method="GET" action="{{ route('admin.index') }}" class="flex gap-2">
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input name="q" value="{{ request('q') }}"
              class="w-full sm:w-64 rounded-xl border-2 border-slate-200 bg-slate-50 pl-10 pr-4 py-2 text-sm text-slate-800 font-medium outline-none focus:border-orange-400 focus:bg-white focus:ring-4 focus:ring-orange-500/10 placeholder-slate-400 transition-all"
              placeholder="Rechercher nom/email..." />
          </div>
          <x-button-outline type="submit" class="px-6 py-2">Go</x-button-outline>
        </form>
      </div>

      <div class="overflow-x-auto -mx-8 px-8">
        <table class="w-full text-sm">
          <thead>
            <tr class="text-left border-b-2 border-slate-100 text-slate-400 font-bold uppercase tracking-wider text-xs">
              <th class="py-3 font-bold pr-4">Utilisateur</th>
              <th class="py-3 font-bold px-4">Rôle</th>
              <th class="py-3 font-bold px-4">Réputation</th>
              <th class="py-3 font-bold px-4">Statut</th>
              <th class="py-3 font-bold pl-4 text-right">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            @forelse($users as $u)
              <tr class="hover:bg-slate-50/80 transition-colors group">
                <td class="py-4 pr-4">
                  <div class="font-bold text-slate-800 group-hover:text-orange-600 transition-colors">{{ $u['name'] }}</div>
                  <div class="text-slate-500 text-xs font-medium mt-0.5">{{ $u['email'] }}</div>
                </td>
                <td class="py-4 px-4"><x-badge>{{ $u['role'] }}</x-badge></td>
                <td class="py-4 px-4">
                  @if($u['reputation'] > 0)
                    <x-badge variant="success">+{{ $u['reputation'] }}</x-badge>
                  @elseif($u['reputation'] < 0)
                    <x-badge variant="danger">{{ $u['reputation'] }}</x-badge>
                  @else
                    <x-badge variant="warning">{{ $u['reputation'] }}</x-badge>
                  @endif
                </td>
                <td class="py-4 px-4">
                  @if($u['banned'])
                    <x-badge variant="danger">Banni</x-badge>
                  @else
                    <x-badge variant="success">Actif</x-badge>
                  @endif
                </td>
                <td class="py-4 pl-4 text-right">
                  @if($u['banned'])
                    <form method="POST" action="{{ route('admin.users.unban', $u['id']) }}">
                      @csrf
                      @method('PATCH')
                      <button class="px-3 py-1.5 rounded-lg bg-green-50 text-green-600 font-bold text-xs hover:bg-green-100 transition-colors active:scale-95 inline-block">Débannir</button>
                    </form>
                  @else
                    <form method="POST" action="{{ route('admin.users.ban', $u['id']) }}">
                      @csrf
                      @method('PATCH')
                      <button class="px-3 py-1.5 rounded-lg bg-red-50 text-red-600 font-bold text-xs hover:bg-red-100 transition-colors active:scale-95 inline-block">Bannir</button>
                    </form>
                  @endif
                </td>
              </tr>
            @empty
              <tr><td colspan="5" class="py-12 text-center text-sm font-medium text-slate-400 italic">Aucun utilisateur trouvé.</td></tr>
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
