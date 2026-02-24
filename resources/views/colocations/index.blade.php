@extends('layouts.app')

@section('title', 'Colocations — EasyColoc')

@section('content')
  <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-black-600">Colocations</h1>
      <p class="mt-1 text-sm">Une seule colocation active par utilisateur (selon vos règles).</p>
    </div>
    <div class="flex gap-3">
      <a href="{{ url('/colocations/create') }}"><x-button-primary>Créer</x-button-primary></a>
      <a href="{{ url('/invitations/accept') }}"><x-button-outline>Rejoindre via token</x-button-outline></a>
    </div>
  </div>

  <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-6">
    <x-card class="p-6">
      <div class="flex items-start justify-between gap-4">
        <div>
          <div class="text-sm">Colocation active</div>
          <div class="mt-1 text-lg font-semibold text-black-600">{{ $activeColocation['name'] ?? 'Aucune' }}</div>
          <div class="mt-1 text-sm">Statut : <x-badge>{{ $activeColocation['status'] ?? '—' }}</x-badge></div>
        </div>
        @if(!empty($activeColocation))
          <a href="{{ url('/colocations/' . ($activeColocation['id'] ?? 1)) }}" class="text-orange-500 hover:underline">Ouvrir →</a>
        @endif
      </div>

      @empty($activeColocation)
        <div class="mt-4 text-sm">
          Vous n’avez pas de colocation active. Vous pouvez en créer une ou rejoindre via invitation.
        </div>
      @endempty
    </x-card>

    <x-card class="p-6">
      <h2 class="text-lg font-semibold text-black-600">Créer rapidement</h2>
      <form method="POST" action="{{ url('/colocations') }}" class="mt-4 space-y-3">
        @csrf
        <div>
          <label class="block text-sm font-medium text-black-600">Nom</label>
          <input name="name" required class="mt-1 w-full rounded-lg border border-gray-100 px-3 py-2 outline-none focus:border-orange-500" placeholder="Ex: Appartement Agdal" />
        </div>
        <div>
          <label class="block text-sm font-medium text-black-600">Description (optionnel)</label>
          <textarea name="description" rows="3" class="mt-1 w-full rounded-lg border border-gray-100 px-3 py-2 outline-none focus:border-orange-500" placeholder="Quelques infos..." ></textarea>
        </div>
        <x-button-primary type="submit">Créer</x-button-primary>
      </form>
    </x-card>
  </div>

  <div class="mt-10">
    <h2 class="text-lg font-semibold text-black-600">Historique (facultatif)</h2>
    <div class="mt-4 overflow-x-auto">
      <table class="w-full text-sm">
        <thead>
          <tr class="text-left border-b border-gray-100">
            <th class="py-2">Nom</th>
            <th class="py-2">Statut</th>
            <th class="py-2">Créée le</th>
            <th class="py-2"></th>
          </tr>
        </thead>
        <tbody>
          @forelse(($colocations ?? []) as $c)
            <tr class="border-b border-gray-100">
              <td class="py-2 font-medium text-black-600">{{ $c['name'] ?? '—' }}</td>
              <td class="py-2"><x-badge>{{ $c['status'] ?? 'active' }}</x-badge></td>
              <td class="py-2">{{ $c['created_at'] ?? '—' }}</td>
              <td class="py-2 text-right"><a class="text-orange-500 hover:underline" href="{{ url('/colocations/' . ($c['id'] ?? 1)) }}">Voir</a></td>
            </tr>
          @empty
            <tr><td colspan="4" class="py-4 text-center">Aucune donnée.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection
