@extends('layouts.app')

@section('title', 'Détails colocation — EasyColoc')

@section('content')
  <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-black-600">{{ $colocation['name'] ?? 'Ma colocation' }}</h1>
      <div class="mt-2 flex flex-wrap items-center gap-2">
        <x-badge>{{ $colocation['status'] ?? 'active' }}</x-badge>
        <span class="text-sm">Créée le: {{ $colocation['created_at'] ?? '—' }}</span>
      </div>
    </div>
    <div class="flex flex-wrap gap-3">
      <a href="{{ url('/colocations/' . ($colocation['id'] ?? 1) . '/expenses/create') }}"><x-button-primary>Ajouter dépense</x-button-primary></a>
      <a href="{{ url('/colocations/' . ($colocation['id'] ?? 1) . '/invitations/create') }}"><x-button-outline>Inviter</x-button-outline></a>
      <form method="POST" action="{{ url('/colocations/' . ($colocation['id'] ?? 1) . '/cancel') }}">
        @csrf
        @method('PATCH')
        <x-button-outline type="submit" class="border-gray-400 text-black-600 hover:border-orange-500">Annuler colocation</x-button-outline>
      </form>
    </div>
  </div>

  <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
    <x-card class="p-6 lg:col-span-2">
      <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold text-black-600">Dépenses (filtre par mois)</h2>
        <a class="text-orange-500 hover:underline text-sm" href="{{ url('/colocations/' . ($colocation['id'] ?? 1) . '/expenses') }}">Tout voir</a>
      </div>

      <form method="GET" action="#" class="mt-4 flex flex-col sm:flex-row gap-3 items-start sm:items-center">
        <select name="month" class="rounded-lg border border-gray-100 px-3 py-2 outline-none focus:border-orange-500">
          <option value="">Tous les mois</option>
          <option value="2026-02">Février 2026</option>
          <option value="2026-01">Janvier 2026</option>
        </select>
        <x-button-outline type="submit">Filtrer</x-button-outline>
      </form>

      <div class="mt-4 overflow-x-auto">
        <table class="w-full text-sm">
          <thead>
            <tr class="text-left border-b border-gray-100">
              <th class="py-2">Titre</th>
              <th class="py-2">Catégorie</th>
              <th class="py-2">Payeur</th>
              <th class="py-2">Montant</th>
              <th class="py-2">Date</th>
              <th class="py-2"></th>
            </tr>
          </thead>
          <tbody>
            @forelse(($expenses ?? []) as $e)
              <tr class="border-b border-gray-100">
                <td class="py-2 font-medium text-black-600">{{ $e['title'] ?? '—' }}</td>
                <td class="py-2">{{ $e['category'] ?? '—' }}</td>
                <td class="py-2">{{ $e['payer'] ?? '—' }}</td>
                <td class="py-2">{{ $e['amount'] ?? '0.00' }}</td>
                <td class="py-2">{{ $e['date'] ?? '—' }}</td>
                <td class="py-2 text-right">
                  <a class="text-orange-500 hover:underline" href="{{ url('/expenses/' . ($e['id'] ?? 1) . '/edit') }}">Edit</a>
                </td>
              </tr>
            @empty
              <tr><td colspan="6" class="py-4 text-center">Aucune dépense.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </x-card>

    <x-card class="p-6">
      <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold text-black-600">Membres</h2>
        <a class="text-orange-500 hover:underline text-sm" href="#members">Gérer</a>
      </div>

      <div class="mt-4 space-y-3">
        @forelse(($members ?? []) as $m)
          <div class="flex items-center justify-between gap-3">
            <div>
              <div class="font-medium text-black-600">{{ $m['name'] ?? '—' }}</div>
              <div class="text-xs">{{ $m['email'] ?? '' }}</div>
            </div>
            <div class="text-right">
              <x-badge>{{ $m['role'] ?? 'Member' }}</x-badge>
              <div class="text-xs mt-1">Rep: {{ $m['reputation'] ?? 0 }}</div>
            </div>
          </div>
        @empty
          <div class="text-sm">Aucun membre.</div>
        @endforelse
      </div>

      <div class="mt-6">
        <a href="{{ url('/settlements') }}" class="text-orange-500 hover:underline">Voir « qui doit à qui » →</a>
      </div>
    </x-card>
  </div>

  <div id="members" class="mt-10">
    <div class="flex items-center justify-between">
      <h2 class="text-lg font-semibold text-black-600">Gestion des membres</h2>
      <a href="{{ url('/colocations/' . ($colocation['id'] ?? 1) . '/invitations/create') }}" class="text-orange-500 hover:underline">Envoyer invitation</a>
    </div>

    <div class="mt-4 overflow-x-auto">
      <table class="w-full text-sm">
        <thead>
          <tr class="text-left border-b border-gray-100">
            <th class="py-2">Membre</th>
            <th class="py-2">Rôle</th>
            <th class="py-2">Réputation</th>
            <th class="py-2">Actif depuis</th>
            <th class="py-2"></th>
          </tr>
        </thead>
        <tbody>
          @forelse(($members ?? []) as $m)
            <tr class="border-b border-gray-100">
              <td class="py-2">
                <div class="font-medium text-black-600">{{ $m['name'] ?? '—' }}</div>
                <div class="text-xs">{{ $m['email'] ?? '' }}</div>
              </td>
              <td class="py-2"><x-badge>{{ $m['role'] ?? 'Member' }}</x-badge></td>
              <td class="py-2">{{ $m['reputation'] ?? 0 }}</td>
              <td class="py-2">{{ $m['joined_at'] ?? '—' }}</td>
              <td class="py-2 text-right">
                {{-- Owner can remove member (except owner). Debt-transfer rule handled in backend. --}}
                <form method="POST" action="{{ url('/colocations/' . ($colocation['id'] ?? 1) . '/members/' . ($m['id'] ?? 1)) }}">
                  @csrf
                  @method('DELETE')
                  <button class="text-orange-500 hover:underline">Retirer</button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="5" class="py-4 text-center">Aucun membre.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection
