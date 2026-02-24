@extends('layouts.app')

@section('title', 'Qui doit à qui — EasyColoc')

@section('content')
  <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-black-600">Vue « qui doit à qui »</h1>
      <p class="mt-1 text-sm">Remboursements simplifiés + action « Marquer payé ».</p>
    </div>
    <div class="flex gap-3">
      <a href="{{ url('/expenses/create') }}"><x-button-primary>Ajouter dépense</x-button-primary></a>
      <a href="{{ url('/colocations') }}"><x-button-outline>Colocation</x-button-outline></a>
    </div>
  </div>

  <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
    <x-card class="p-6 lg:col-span-2">
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead>
            <tr class="text-left border-b border-gray-100">
              <th class="py-2">Débiteur</th>
              <th class="py-2">Créancier</th>
              <th class="py-2">Montant</th>
              <th class="py-2">Statut</th>
              <th class="py-2"></th>
            </tr>
          </thead>
          <tbody>
            @forelse(($settlements ?? []) as $s)
              <tr class="border-b border-gray-100">
                <td class="py-2 font-medium text-black-600">{{ $s['from'] ?? '—' }}</td>
                <td class="py-2">{{ $s['to'] ?? '—' }}</td>
                <td class="py-2">{{ $s['amount'] ?? '0.00' }} MAD</td>
                <td class="py-2">
                  @if(($s['paid'] ?? false) === true)
                    <x-badge variant="success">Payé</x-badge>
                  @else
                    <x-badge variant="danger">À payer</x-badge>
                  @endif
                </td>
                <td class="py-2 text-right">
                  @if(($s['paid'] ?? false) !== true)
                    <form method="POST" action="{{ url('/settlements/' . ($s['id'] ?? 1) . '/pay') }}">
                      @csrf
                      @method('PATCH')
                      <button class="text-orange-500 hover:underline">Marquer payé</button>
                    </form>
                  @else
                    <span class="text-xs">—</span>
                  @endif
                </td>
              </tr>
            @empty
              <tr><td colspan="5" class="py-6 text-center">Aucune dette en cours.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </x-card>

    <x-card class="p-6">
      <h2 class="text-lg font-semibold text-black-600">Notes</h2>
      <ul class="mt-3 space-y-2 text-sm list-disc pl-5">
        <li>Les dettes sont calculées automatiquement (total payé / part individuelle / solde).</li>
        <li>L’action « Marquer payé » réduit les dettes via enregistrement de paiements.</li>
        <li>Règle spéciale (backend): si l’owner retire un membre avec dette → dette imputée à l’owner.</li>
      </ul>
    </x-card>
  </div>
@endsection
