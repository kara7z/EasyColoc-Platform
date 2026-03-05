@extends('layouts.app')

@section('title', 'Détails colocation — EasyColoc')

@section('content')
@php
    $isCancelled = $isCancelled ?? (($colocation?->status ?? null) === 'cancelled');
    $isAdminViewer = $isAdminViewer ?? false;
    $user = request()->user();
    $userId = $user?->id;
    $myMembership = $colocation?->memberships()
        ->where('user_id', $userId)
        ->latest('id')
        ->first();
    $isActiveMember = $myMembership && $myMembership->left_at === null;
    $isOwnerActive  = $myMembership && $myMembership->left_at === null && $myMembership->role === 'owner';
@endphp

<div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-5 animate-[slideDown_0.4s_ease-out]">
    <div>
        <div class="flex items-center gap-3">
          <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">
              {{ $colocation?->name ?? 'Ma colocation' }}
          </h1>
          <x-badge variant="{{ $isCancelled ? 'danger' : 'success' }}">{{ $colocation?->status ?? 'active' }}</x-badge>
        </div>

        <div class="mt-2 text-sm text-slate-500 font-medium">
            Créée le {{ optional($colocation?->created_at)->format('d M Y') ?? '—' }}
        </div>

        @if(!empty($colocation?->description))
            <p class="mt-3 max-w-3xl text-sm text-slate-600">{{ $colocation->description }}</p>
        @endif

        @if($isCancelled)
            <div class="mt-3 inline-flex items-center px-3 py-1.5 rounded-lg bg-red-50 text-red-600 text-sm font-bold shadow-sm">
                <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                Colocation annulée — mode lecture seule.
            </div>
        @endif

        @if(!$isActiveMember && !$isAdminViewer)
            <div class="mt-3 inline-flex items-center px-3 py-1.5 rounded-lg bg-orange-50 text-orange-600 text-sm font-bold shadow-sm">
                <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Vous avez quitté cette colocation — accès lecture seule.
            </div>
        @endif

        @if($isAdminViewer && !$isActiveMember)
            <div class="mt-3 inline-flex items-center px-3 py-1.5 rounded-lg bg-slate-100 text-slate-600 text-sm font-bold shadow-sm">
                Mode admin — accès lecture seule.
            </div>
        @endif
    </div>

    <div class="flex flex-wrap gap-3">
        @if(!$isCancelled && $isActiveMember)
            <a href="{{ url('/colocations/' . $colocation->id . '/expenses/create') }}">
                <x-button-primary>Ajouter dépense</x-button-primary>
            </a>
        @endif

        @if($isOwnerActive && !$isCancelled)
            <a href="{{ route('invitations.create', $colocation) }}">
                <x-button-outline>Inviter membre</x-button-outline>
            </a>

            <form method="post" action="{{ route('colocations.cancel', $colocation) }}">
                @csrf
                @method('patch')
                <button type="submit" class="px-6 py-3 font-bold rounded-xl border-2 border-red-100 text-red-500 bg-white hover:bg-red-50 hover:border-red-500 transition-all focus:outline-none active:scale-95 flex items-center gap-1.5">
                    Annuler colocation
                </button>
            </form>
        @endif

        @if(!$isCancelled && $isActiveMember && !$isOwnerActive)
            <form method="post" action="{{ route('colocations.leave', $colocation) }}">
                @csrf
                @method('delete')
                <x-button-outline type="submit">
                    Quitter colocation
                </x-button-outline>
            </form>
        @endif
    </div>
</div>

<div class="mt-10 grid grid-cols-1 xl:grid-cols-3 gap-8">
    {{-- Expenses --}}
    <x-card class="p-8 xl:col-span-2">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-extrabold text-slate-800 tracking-tight flex items-center gap-2">
                <svg class="w-6 h-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                Dépenses récentes
            </h2>
            @if($isActiveMember)
                <a class="text-orange-600 hover:text-orange-700 font-bold bg-orange-50 px-4 py-2 rounded-full hover:bg-orange-100 transition-colors text-sm" href="{{ url('/colocations/' . $colocation->id . '/expenses') }}">
                    Toutes les dépenses
                </a>
            @endif
        </div>

        <div class="overflow-x-auto -mx-8 px-8">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left border-b-2 border-slate-100 text-slate-400 font-bold uppercase tracking-wider text-xs">
                        <th class="pb-3 pr-4">Détails</th>
                        <th class="pb-3 px-4">Payeur</th>
                        <th class="pb-3 px-4 text-right">Montant</th>
                        <th class="pb-3 pl-4"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse(($expenses ?? []) as $e)
                        <tr class="group">
                            <td class="py-4 pr-4">
                              <div class="p-3 rounded-lg transition-all group-hover:shadow-md" style="background: linear-gradient(135deg, {{ $e['color'] ?? '#6B7280' }}15 0%, {{ $e['color'] ?? '#6B7280' }}05 100%); border-left: 3px solid {{ $e['color'] ?? '#6B7280' }}">
                                <div class="font-bold text-slate-800 group-hover:text-orange-600 transition-colors">{{ $e['title'] ?? '—' }}</div>
                                <div class="text-slate-500 text-xs font-medium mt-1 flex gap-2 items-center">
                                  <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase" style="background-color: {{ $e['color'] ?? '#6B7280' }}30; color: {{ $e['color'] ?? '#6B7280' }}">{{ $e['category'] ?? '—' }}</span>
                                  <span class="text-slate-300">•</span>
                                  <span>{{ $e['date'] ?? '—' }}</span>
                                </div>
                              </div>
                            </td>
                            <td class="py-4 px-4 font-medium text-slate-600">{{ $e['payer'] ?? '—' }}</td>
                            <td class="py-4 px-4 text-right font-extrabold text-slate-800">{{ $e['amount'] ?? '0.00' }}</td>
                            <td class="py-4 pl-4 text-right">
                                @if(!$isCancelled && $isActiveMember && (($e['payer_id'] ?? null) === $userId))
                                    <a class="inline-flex items-center justify-center p-2 rounded-lg text-slate-400 hover:bg-orange-50 hover:text-orange-600 transition-colors"
                                       href="{{ url('/expenses/' . ($e['id'] ?? 1) . '/edit') }}" title="Modifier">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </a>
                                @else
                                    <span class="text-xs text-slate-300">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-sm font-medium text-slate-400 italic">Aucune dépense enregistrée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>

    {{-- Members summary --}}
    <div class="space-y-8">
      <x-card class="p-8">
          <div class="flex items-center justify-between mb-6">
              <h2 class="text-xl font-extrabold text-slate-800 tracking-tight flex items-center gap-2">
                <svg class="w-6 h-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Membres actifs
              </h2>
              <a class="text-orange-600 hover:text-orange-700 font-bold bg-orange-50 px-4 py-2 rounded-full hover:bg-orange-100 transition-colors text-sm" href="#members">Voir tout</a>
          </div>

          <div class="space-y-5">
              @forelse(($activeMembers ?? []) as $m)
                  <div class="flex items-start justify-between gap-3 group">
                      <div class="flex gap-3">
                          <div class="mt-1 h-10 w-10 rounded-full bg-gradient-to-br from-orange-100 to-orange-50 border border-orange-200 flex items-center justify-center font-bold text-orange-600 shadow-sm">
                            {{ substr($m['name'] ?? 'M', 0, 1) }}
                          </div>
                          <div>
                              <div class="font-bold text-slate-800 group-hover:text-orange-600 transition-colors">{{ $m['name'] ?? '—' }}</div>
                              <div class="text-xs font-medium text-slate-500">{{ $m['email'] ?? '' }}</div>
                              <div class="mt-0.5 text-[10px] uppercase tracking-wide text-slate-400 font-bold">
                                  Entrée: {{ $m['joined_at'] ?? '—' }}
                              </div>
                          </div>
                      </div>

                      <div class="text-right flex flex-col items-end gap-1.5 mt-1">
                          <x-badge variant="{{ ($m['role'] ?? '') === 'owner' ? 'danger' : 'neutral' }}">{{ $m['role'] ?? 'member' }}</x-badge>
                          <div class="text-xs font-bold text-slate-400 flex items-center gap-1" title="Réputation">
                            <svg class="w-3.5 h-3.5 text-orange-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            {{ $m['reputation'] ?? 0 }}
                          </div>
                      </div>
                  </div>
              @empty
                  <div class="text-sm font-medium text-slate-400 italic text-center py-4">Aucun membre actif.</div>
              @endforelse
          </div>

          <div class="mt-8 pt-6 border-t border-slate-100 hidden md:block">
              <a href="{{ url('/settlements') }}" class="group flex items-center justify-between p-4 rounded-xl bg-orange-50 border border-orange-100 hover:border-orange-500 transition-colors">
                  <div class="font-bold text-slate-800 group-hover:text-orange-600 transition-colors">Qui doit à qui ?</div>
                  <svg class="w-5 h-5 text-orange-500 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
              </a>
          </div>
      </x-card>
    </div>
</div>

{{-- Members history table --}}
<div id="members" class="mt-12">
    <x-card class="p-8">
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
          <h2 class="text-xl font-extrabold text-slate-800 tracking-tight flex items-center gap-2">
            <svg class="w-6 h-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Historique complet des membres
          </h2>

          @if($isOwnerActive && !$isCancelled)
              <a href="{{ route('invitations.create', $colocation) }}" class="text-orange-600 hover:text-orange-700 bg-orange-50 hover:bg-orange-100 px-5 py-2.5 rounded-full font-bold text-sm transition-colors shadow-sm focus:ring-2 focus:ring-orange-500/20 active:scale-95 inline-flex items-center gap-1.5 border border-orange-200">
                  + Nouvelle invitation
              </a>
          @endif
      </div>

      <div class="overflow-x-auto -mx-8 px-8">
          <table class="w-full text-sm">
              <thead>
                  <tr class="text-left border-b-2 border-slate-100 text-slate-400 font-bold uppercase tracking-wider text-xs">
                      <th class="py-3 pr-4">Membre</th>
                      <th class="py-3 px-4">Rôle</th>
                      <th class="py-3 px-4">Dates</th>
                      <th class="py-3 pl-4 text-right">Action</th>
                  </tr>
              </thead>
              <tbody class="divide-y divide-slate-100">
                  @forelse(($membersHistory ?? []) as $m)
                      <tr class="hover:bg-slate-50/80 transition-colors group">
                          <td class="py-4 pr-4">
                              <div class="font-bold text-slate-800">{{ $m['name'] ?? '—' }}</div>
                              <div class="text-slate-500 font-medium text-xs mt-0.5">{{ $m['email'] ?? '' }}</div>
                          </td>
                          <td class="py-4 px-4"><x-badge variant="{{ ($m['role'] ?? '') === 'owner' ? 'danger' : 'neutral' }}">{{ $m['role'] ?? 'member' }}</x-badge></td>
                          <td class="py-4 px-4">
                            <div class="text-xs font-bold text-slate-500"><span class="text-slate-400 font-medium">In:</span> {{ $m['joined_at'] ?? '—' }}</div>
                            <div class="text-xs font-bold @if($m['left_at']) text-red-500 @else text-green-500 @endif mt-0.5"><span class="text-slate-400 font-medium">Out:</span> {{ $m['left_at'] ?? 'Actif' }}</div>
                          </td>

                          <td class="py-4 pl-4 text-right">
                              @php $rowIsActive = empty($m['left_at']); @endphp

                              @if($isOwnerActive && !$isCancelled && $rowIsActive && (($m['role'] ?? 'member') !== 'owner'))
                                  <form method="post" action="{{ route('colocations.members.destroy', [$colocation, $m['id']]) }}">
                                      @csrf
                                      @method('delete')
                                      <button class="px-3 py-1.5 rounded-lg bg-red-50 text-red-600 font-bold text-xs hover:bg-red-100 transition-colors active:scale-95 inline-block border border-red-100">Retirer</button>
                                  </form>
                              @else
                                  <span class="text-xs font-medium text-slate-300">—</span>
                              @endif
                          </td>
                      </tr>
                  @empty
                      <tr>
                          <td colspan="4" class="py-12 text-center text-sm font-medium text-slate-400 italic">Aucun membre enregistré.</td>
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
