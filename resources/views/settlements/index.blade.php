@extends('layouts.app')

@section('title', 'Qui doit à qui — EasyColoc')

@section('content')
  <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-black-600">Settlements par colocation</h1>
      <p class="mt-1 text-sm">Dettes en cours + historique des paiements (groupés par colocation).</p>
    </div>
    <div class="flex gap-3">
      <a href="{{ route('colocations.index') }}"><x-button-outline>Mes colocations</x-button-outline></a>
    </div>
  </div>

  @forelse(($groups ?? collect()) as $group)
    @php
      $colocation = $group['colocation'];
      $members = $group['members'];
      $pending = $group['pending_settlements'];
      $payments = $group['payments'];
      $canMarkPaid = $group['can_mark_paid'];
      $totalPendingAmount = collect($pending)->sum(fn($row) => (float) ($row['amount_value'] ?? 0));
    @endphp

    <x-card class="mt-8 p-6">
      <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3 mb-6">
        <div>
          <div class="flex items-center gap-2">
            <h2 class="text-xl font-bold text-black-600">{{ $colocation->name }}</h2>
            <x-badge variant="{{ $colocation->status === 'active' ? 'success' : 'danger' }}">{{ $colocation->status }}</x-badge>
          </div>
          <p class="mt-1 text-sm text-slate-500">Créée le {{ optional($colocation->created_at)->format('d/m/Y') }}</p>
        </div>
        <div class="flex gap-3">
          <a href="{{ route('colocations.show', $colocation) }}"><x-button-outline>Ouvrir</x-button-outline></a>
          @if($canMarkPaid)
            <a href="{{ route('expenses.create', $colocation->id) }}"><x-button-primary>Ajouter dépense</x-button-primary></a>
          @endif
        </div>
      </div>

      @if(!$canMarkPaid)
        <div class="mb-6 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-700">
          Lecture seule: vous n'êtes pas membre actif de cette colocation.
        </div>
      @endif

      <div>
        <div class="mb-3 flex items-center justify-between gap-3">
          <h3 class="text-lg font-semibold text-black-600">Dettes en cours</h3>
          <div class="text-right text-sm font-semibold text-slate-600">
            <p>Total restant: <span class="text-black-600">{{ number_format($totalPendingAmount, 2) }} MAD</span></p>
          </div>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead>
              <tr class="text-left border-b border-gray-100">
                <th class="py-2">Débiteur</th>
                <th class="py-2">Créancier</th>
                <th class="py-2">Dépense</th>
                <th class="py-2">Prix dépense</th>
                <th class="py-2">Restant</th>
                <th class="py-2 text-right">Action</th>
              </tr>
            </thead>
            <tbody>
              @forelse($pending as $settlement)
                <tr class="border-b border-gray-100">
                  <td class="py-2 font-medium text-black-600">{{ $settlement['from'] }}</td>
                  <td class="py-2">{{ $settlement['to'] }}</td>
                  <td class="py-2 text-slate-700">{{ $settlement['expense_title'] }}</td>
                  <td class="py-2 font-semibold text-slate-700">{{ $settlement['expense_total'] }} MAD</td>
                  <td class="py-2 font-semibold text-slate-700">{{ $settlement['remaining'] }} MAD</td>
                  <td class="py-2 text-right">
                    @if($settlement['can_mark_paid'])
                      <form method="POST" action="{{ route('settlements.markPaid') }}">
                        @csrf
                        <input type="hidden" name="from_id" value="{{ $settlement['from_id'] }}">
                        <input type="hidden" name="to_id" value="{{ $settlement['to_id'] }}">
                        <input type="hidden" name="amount" value="{{ $settlement['amount_value'] }}">
                        <input type="hidden" name="colocation_id" value="{{ $colocation->id }}">
                        <button class="text-orange-500 hover:underline">Marquer payé</button>
                      </form>
                    @else
                      <span class="text-xs text-slate-300">—</span>
                    @endif
                  </td>
                </tr>
              @empty
                <tr><td colspan="6" class="py-4 text-center">Aucune dette en cours.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <div class="mt-8">
        <h3 class="text-lg font-semibold text-black-600 mb-3">Paiements enregistrés</h3>
        <div class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead>
              <tr class="text-left border-b border-gray-100">
                <th class="py-2">Débiteur</th>
                <th class="py-2">Créancier</th>
                <th class="py-2">Montant</th>
                <th class="py-2">Date</th>
                <th class="py-2">Statut</th>
              </tr>
            </thead>
            <tbody>
              @forelse($payments as $payment)
                <tr class="border-b border-gray-100">
                  <td class="py-2 font-medium text-black-600">{{ $payment['from'] }}</td>
                  <td class="py-2">{{ $payment['to'] }}</td>
                  <td class="py-2">{{ $payment['amount'] }} MAD</td>
                  <td class="py-2">{{ $payment['paid_at'] }}</td>
                  <td class="py-2"><x-badge variant="success">Payé</x-badge></td>
                </tr>
              @empty
                <tr><td colspan="5" class="py-4 text-center">Aucun paiement enregistré.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </x-card>
  @empty
    <x-card class="mt-8 p-8">
      <p class="text-center text-slate-500">Aucune colocation trouvée pour votre compte.</p>
    </x-card>
  @endforelse
@endsection
