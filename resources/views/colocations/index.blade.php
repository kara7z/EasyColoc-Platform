@extends('layouts.app')

@section('title', 'Colocations — EasyColoc')

@section('content')
  <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-black-600">Colocations</h1>
      <p class="mt-1 text-sm">
        @if($isAdmin ?? false)
          Vue globale des colocations actives.
        @else
          Vue de vos colocations actives.
        @endif
      </p>
    </div>
    <div class="flex gap-3">
      <a href="{{ url('/colocations/create') }}"><x-button-primary>Créer</x-button-primary></a>
      <a href="{{ route('invitations.check') }}"><x-button-outline>Rejoindre via token</x-button-outline></a>
    </div>
  </div>

  <div class="mt-7 grid grid-cols-1 lg:grid-cols-2 gap-6">
    <x-card class="p-5">
      <div class="flex items-start justify-between gap-3">
        <div>
          <div class="text-sm">Colocations actives</div>

          @if(($activeColocations ?? collect())->isNotEmpty())
            <div class="mt-2 space-y-3">
              @foreach($activeColocations as $active)
                <div class="border-b border-slate-100 pb-3 last:border-0 last:pb-0">
                  <div class="flex items-center justify-between gap-2">
                    <div class="text-base font-semibold text-black-600">{{ $active->name }}</div>
                    <x-badge>{{ $active->status }}</x-badge>
                  </div>

                  @if(!empty($active->description))
                    <p class="mt-1 text-sm text-slate-600">{{ $active->description }}</p>
                  @endif

                  <div class="mt-1 text-xs text-slate-500">
                    Créée le {{ optional($active->created_at)->format('Y-m-d') }}
                  </div>

                  <div class="mt-2">
                    <a href="{{ route('colocations.show', $active) }}" class="text-orange-500 hover:underline">
                      Ouvrir →
                    </a>
                  </div>
                </div>
              @endforeach
            </div>
          @else
            <div class="mt-2 text-sm text-slate-500">
              @if($isAdmin ?? false)
                Aucune colocation active sur la plateforme.
              @else
                Vous n’avez pas de colocation active.
              @endif
            </div>
          @endif
        </div>
      </div>

      @if(!$activeColocation && !($isAdmin ?? false))
        <div class="mt-4 text-sm">
          Vous n’avez pas de colocation active. Vous pouvez en créer une ou rejoindre via invitation.
        </div>
      @endif
    </x-card>

    <x-card class="p-6">
      <h2 class="text-lg font-semibold text-black-600">Créer rapidement</h2>

      <form method="POST" action="{{ route('colocations.store') }}" class="mt-4 space-y-3">
        @csrf

        <div>
          <label class="block text-sm font-medium text-black-600">Nom</label>
          <input
            name="name"
            required
            value="{{ old('name') }}"
            class="mt-1 w-full rounded-lg border border-gray-100 px-3 py-2 outline-none focus:border-orange-500"
            placeholder="Ex: Appartement Agdal"
          />
          @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label class="block text-sm font-medium text-black-600">Description (optionnel)</label>
          <textarea
            name="description"
            rows="3"
            class="mt-1 w-full rounded-lg border border-gray-100 px-3 py-2 outline-none focus:border-orange-500"
            placeholder="Quelques infos..."
          >{{ old('description') }}</textarea>
          @error('description')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <x-button-primary type="submit">Créer</x-button-primary>
      </form>
    </x-card>
  </div>

  <div class="mt-10">
    <h2 class="text-lg font-semibold text-black-600">Historique</h2>

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
          @forelse($colocations as $c)
            <tr class="border-b border-gray-100">
              <td class="py-2 font-medium text-black-600">{{ $c->name }}</td>
              <td class="py-2"><x-badge>{{ $c->status }}</x-badge></td>
              <td class="py-2">{{ optional($c->created_at)->format('Y-m-d') }}</td>
              <td class="py-2 text-right">
                <a class="text-orange-500 hover:underline" href="{{ route('colocations.show', $c) }}">Voir</a>
              </td>
            </tr>
          @empty
            <tr><td colspan="4" class="py-4 text-center">Aucune donnée.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection
