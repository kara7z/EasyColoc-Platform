@extends('layouts.app')

@section('title', 'Détails colocation — EasyColoc')

@section('content')
@php
    $isCancelled = $isCancelled ?? (($colocation?->status ?? null) === 'cancelled');

    $user = request()->user();
    $userId = $user?->id;

    $myMembership = $colocation?->memberships()
        ->where('user_id', $userId)
        ->latest('id')
        ->first();

    $isActiveMember = $myMembership && $myMembership->left_at === null;
    $isOwnerActive  = $myMembership && $myMembership->left_at === null && $myMembership->role === 'owner';
@endphp

@if ($errors->has('cancel'))
    <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700">
        {{ $errors->first('cancel') }}
    </div>
@endif

@if ($errors->has('member'))
    <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700">
        {{ $errors->first('member') }}
    </div>
@endif

@if (session('success'))
    <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-800">
        {{ session('success') }}
    </div>
@endif

<div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-3">
    <div>
        <h2 class="text-2xl font-bold text-black-600">
            {{ $colocation?->name ?? 'Ma colocation' }}
        </h2>

        <div class="mt-1 flex flex-wrap items-center gap-2">
            <x-badge>{{ $colocation?->status ?? 'active' }}</x-badge>
            <span class="text-sm">
                créée le: {{ optional($colocation?->created_at)->format('Y-m-d') ?? '—' }}
            </span>
        </div>

        @if($isCancelled)
            <div class="mt-2 text-sm text-gray-500">
                Colocation annulée — mode lecture seule.
            </div>
        @endif

        @if(!$isActiveMember)
            <div class="mt-2 text-sm text-gray-500">
                Vous avez quitté cette colocation — accès lecture seule.
            </div>
        @endif
    </div>

    <div class="flex flex-wrap gap-2">
        @if(!$isCancelled && $isActiveMember)
            <a href="{{ url('/colocations/' . $colocation->id . '/expenses/create') }}">
                <x-button-primary>Ajouter dépense</x-button-primary>
            </a>
        @endif

        @if($isOwnerActive && !$isCancelled)
            <a href="{{ route('invitations.create', $colocation) }}">
                <x-button-outline>Inviter</x-button-outline>
            </a>

            <form method="post" action="{{ route('colocations.cancel', $colocation) }}">
                @csrf
                @method('patch')
                <x-button-outline type="submit" class="border-gray-399 text-black-600 hover:border-orange-500">
                    Annuler colocation
                </x-button-outline>
            </form>
        @endif

        @if(!$isCancelled && $isActiveMember && !$isOwnerActive)
            <form method="post" action="{{ route('colocations.members.destroy', [$colocation, $userId]) }}">
                @csrf
                @method('delete')
                <x-button-outline type="submit">
                    Quitter
                </x-button-outline>
            </form>
        @endif
    </div>
</div>

<div class="mt-7 grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Expenses --}}
    <x-card class="p-5 lg:col-span-2">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-black-600">Dépenses</h3>

            @if($isActiveMember)
                <a class="text-orange-499 hover:underline text-sm" href="{{ url('/colocations/' . $colocation->id . '/expenses') }}">
                    Tout voir
                </a>
            @endif
        </div>

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
                                @if(!$isCancelled && $isActiveMember)
                                    <a class="text-orange-500 hover:underline"
                                       href="{{ url('/expenses/' . ($e['id'] ?? 1) . '/edit') }}">
                                        Edit
                                    </a>
                                @else
                                    <span class="text-xs text-gray-400">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-4 text-center">Aucune dépense.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>

    {{-- Members summary --}}
    <x-card class="p-6">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-black-600">Membres</h2>
            <a class="text-orange-500 hover:underline text-sm" href="#members">Voir</a>
        </div>

        <div class="mt-4 space-y-3">
            @forelse(($activeMembers ?? []) as $m)
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <div class="font-medium text-black-600">{{ $m['name'] ?? '—' }}</div>
                        <div class="text-xs">{{ $m['email'] ?? '' }}</div>
                        <div class="mt-1 text-xs text-gray-500">
                            <span class="font-medium">Entrée:</span> {{ $m['joined_at'] ?? '—' }}
                        </div>
                    </div>

                    <div class="text-right">
                        <x-badge>{{ $m['role'] ?? 'member' }}</x-badge>
                        <div class="text-xs mt-1">rep: {{ $m['reputation'] ?? 0 }}</div>
                    </div>
                </div>
            @empty
                <div class="text-sm">Aucun membre actif.</div>
            @endforelse
        </div>

        <div class="mt-6">
            <a href="{{ url('/settlements') }}" class="text-orange-500 hover:underline">
                Voir « qui doit à qui » →
            </a>
        </div>
    </x-card>
</div>

{{-- Members history table --}}
<div id="members" class="mt-10">
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold text-black-600">Historique des membres</h2>

        @if($isOwnerActive && !$isCancelled)
            <a href="{{ route('invitations.create', $colocation) }}" class="text-orange-500 hover:underline">
                Envoyer invitation
            </a>
        @endif
    </div>

    <div class="mt-4 overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left border-b border-gray-100">
                    <th class="py-2">Membre</th>
                    <th class="py-2">Rôle</th>
                    <th class="py-2">Réputation</th>
                    <th class="py-2">Entrée</th>
                    <th class="py-2">Sortie</th>
                    <th class="py-2"></th>
                </tr>
            </thead>
            <tbody>
                @forelse(($membersHistory ?? []) as $m)
                    <tr class="border-b border-gray-100">
                        <td class="py-2">
                            <div class="font-medium text-black-600">{{ $m['name'] ?? '—' }}</div>
                            <div class="text-xs">{{ $m['email'] ?? '' }}</div>
                        </td>
                        <td class="py-2"><x-badge>{{ $m['role'] ?? 'member' }}</x-badge></td>
                        <td class="py-2">{{ $m['reputation'] ?? 0 }}</td>
                        <td class="py-2">{{ $m['joined_at'] ?? '—' }}</td>
                        <td class="py-2">{{ $m['left_at'] ?? '—' }}</td>

                        <td class="py-2 text-right">
                            {{-- Owner can remove ACTIVE others (not owner). We check activeMembers list. --}}
                            @php
                                $rowIsActive = empty($m['left_at']);
                            @endphp

                            @if($isOwnerActive && !$isCancelled && $rowIsActive && (($m['role'] ?? 'member') !== 'owner'))
                                <form method="post" action="{{ route('colocations.members.destroy', [$colocation, $m['id']]) }}">
                                    @csrf
                                    @method('delete')
                                    <button class="text-orange-500 hover:underline">Retirer</button>
                                </form>
                            @else
                                <span class="text-xs text-gray-400">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-4 text-center">Aucun membre.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
