@extends('layouts.app')

@section('title', 'Admin global — EasyColoc')

@section('content')
  <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-black-600">Administration globale</h1>
      <p class="mt-1 text-sm">Statistiques + bannissement/débannissement (template).</p>
    </div>
    <a href="{{ url('/dashboard') }}" class="text-orange-500 hover:underline">← Dashboard</a>
  </div>

  <div class="mt-8 grid grid-cols-1 md:grid-cols-4 gap-6">
    <x-card class="p-6">
      <div class="text-sm">Utilisateurs</div>
      <div class="mt-2 text-3xl font-bold text-black-600">{{ $stats['users'] ?? 0 }}</div>
    </x-card>
    <x-card class="p-6">
      <div class="text-sm">Colocations</div>
      <div class="mt-2 text-3xl font-bold text-black-600">{{ $stats['colocations'] ?? 0 }}</div>
    </x-card>
    <x-card class="p-6">
      <div class="text-sm">Dépenses</div>
      <div class="mt-2 text-3xl font-bold text-black-600">{{ $stats['expenses'] ?? 0 }}</div>
    </x-card>
    <x-card class="p-6">
      <div class="text-sm">Bannis</div>
      <div class="mt-2 text-3xl font-bold text-black-600">{{ $stats['banned'] ?? 0 }}</div>
    </x-card>
  </div>

  <div class="mt-10 grid grid-cols-1 lg:grid-cols-3 gap-6">
    <x-card class="p-6 lg:col-span-2">
      <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold text-black-600">Utilisateurs</h2>
        <form method="GET" action="#" class="flex gap-2">
          <input name="q" class="rounded-lg border border-gray-100 px-3 py-2 outline-none focus:border-orange-500" placeholder="Rechercher..." />
          <x-button-outline type="submit">OK</x-button-outline>
        </form>
      </div>

      <div class="mt-4 overflow-x-auto">
        <table class="w-full text-sm">
          <thead>
            <tr class="text-left border-b border-gray-100">
              <th class="py-2">Nom</th>
              <th class="py-2">Email</th>
              <th class="py-2">Rôle</th>
              <th class="py-2">Statut</th>
              <th class="py-2"></th>
            </tr>
          </thead>
          <tbody>
            @forelse(($users ?? []) as $u)
              <tr class="border-b border-gray-100">
                <td class="py-2 font-medium text-black-600">{{ $u['name'] ?? '—' }}</td>
                <td class="py-2">{{ $u['email'] ?? '—' }}</td>
                <td class="py-2"><x-badge>{{ $u['role'] ?? 'User' }}</x-badge></td>
                <td class="py-2">
                  @if(($u['banned'] ?? false) === true)
                    <x-badge variant="danger">Banni</x-badge>
                  @else
                    <x-badge variant="success">Actif</x-badge>
                  @endif
                </td>
                <td class="py-2 text-right">
                  @if(($u['banned'] ?? false) === true)
                    <form method="POST" action="{{ url('/admin/users/' . ($u['id'] ?? 1) . '/unban') }}">
                      @csrf
                      @method('PATCH')
                      <button class="text-orange-500 hover:underline">Débannir</button>
                    </form>
                  @else
                    <form method="POST" action="{{ url('/admin/users/' . ($u['id'] ?? 1) . '/ban') }}">
                      @csrf
                      @method('PATCH')
                      <button class="text-orange-500 hover:underline">Bannir</button>
                    </form>
                  @endif
                </td>
              </tr>
            @empty
              <tr><td colspan="5" class="py-6 text-center">Aucun utilisateur.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="mt-4 text-xs">
        Note: côté backend, un utilisateur banni doit être déconnecté automatiquement et bloqué.
      </div>
    </x-card>

    <x-card class="p-6">
      <h2 class="text-lg font-semibold text-black-600">Rappels</h2>
      <ul class="mt-3 space-y-2 text-sm list-disc pl-5">
        <li>L’admin global peut aussi être Owner/Member dans des colocations.</li>
        <li>Stats possibles: dépenses par mois, par catégorie, top colocations…</li>
        <li>Modération: bannir/désactiver + logs.</li>
      </ul>
    </x-card>
  </div>
@endsection
