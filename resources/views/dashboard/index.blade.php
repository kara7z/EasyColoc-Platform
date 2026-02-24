@extends('layouts.app')

@section('title', 'Dashboard — EasyColoc')

@section('content')
  <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-black-600">Dashboard</h1>
      <p class="mt-1 text-sm">Vue rapide de votre situation.</p>
    </div>
    <div class="flex gap-3">
      <a href="{{ url('/colocations/create') }}"><x-button-primary>Créer une colocation</x-button-primary></a>
      <a href="{{ url('/invitations/accept') }}"><x-button-outline>Rejoindre via token</x-button-outline></a>
    </div>
  </div>

  <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
    <x-card class="p-6">
      <div class="text-sm">Votre réputation</div>
      <div class="mt-2 text-3xl font-bold text-black-600">{{ $reputation ?? 0 }}</div>
      <div class="mt-2 text-sm">+1 / -1 selon départ/annulation avec dette.</div>
    </x-card>

    <x-card class="p-6">
      <div class="text-sm">Solde actuel</div>
      <div class="mt-2 text-3xl font-bold text-black-600">{{ $balance ?? '0.00' }} MAD</div>
      <div class="mt-2 text-sm">Positif = on vous doit, négatif = vous devez.</div>
    </x-card>

    <x-card class="p-6">
      <div class="text-sm">Colocation active</div>
      <div class="mt-2 text-lg font-semibold text-black-600">{{ $activeColocationName ?? 'Aucune' }}</div>
      <div class="mt-3">
        <a href="{{ url('/colocations') }}" class="text-orange-500 hover:underline">Voir détails →</a>
      </div>
    </x-card>
  </div>

  <div class="mt-10 grid grid-cols-1 lg:grid-cols-2 gap-6">
    <x-card class="p-6">
      <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold text-black-600">Raccourcis</h2>
      </div>
      <div class="mt-4 flex flex-wrap gap-3">
        <a href="{{ url('/expenses/create') }}"><x-button-outline>Ajouter dépense</x-button-outline></a>
        <a href="{{ url('/settlements') }}"><x-button-outline>Qui doit à qui</x-button-outline></a>
        <a href="{{ url('/categories') }}"><x-button-outline>Catégories</x-button-outline></a>
      </div>
    </x-card>

    <x-card class="p-6">
      <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold text-black-600">Dernières dépenses</h2>
        <a href="{{ url('/expenses') }}" class="text-orange-500 hover:underline text-sm">Tout voir</a>
      </div>
      <div class="mt-4 overflow-x-auto">
        <table class="w-full text-sm">
          <thead>
            <tr class="text-left border-b border-gray-100">
              <th class="py-2">Titre</th>
              <th class="py-2">Montant</th>
              <th class="py-2">Date</th>
            </tr>
          </thead>
          <tbody>
            @forelse(($recentExpenses ?? []) as $expense)
              <tr class="border-b border-gray-100">
                <td class="py-2">{{ $expense['title'] ?? '—' }}</td>
                <td class="py-2">{{ $expense['amount'] ?? '0.00' }}</td>
                <td class="py-2">{{ $expense['date'] ?? '—' }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="3" class="py-4 text-center">Aucune dépense pour le moment.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </x-card>
  </div>
@endsection
