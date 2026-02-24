@extends('layouts.app')

@section('title', 'Rejoindre via invitation — EasyColoc')

@section('content')
  <div class="flex items-start justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-black-600">Rejoindre une colocation</h1>
      <p class="mt-1 text-sm">Collez un token d’invitation (ou utilisez le lien reçu par email).</p>
    </div>
    <a href="{{ url('/dashboard') }}" class="text-orange-500 hover:underline">← Dashboard</a>
  </div>

  <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-6">
    <x-card class="p-8">
      <h2 class="text-lg font-semibold text-black-600">Entrer le token</h2>
      <form method="GET" action="{{ url('/invitations/accept') }}" class="mt-4 space-y-3">
        <div>
          <label class="block text-sm font-medium text-black-600">Token</label>
          <input name="token" value="{{ request('token') }}" required class="mt-1 w-full rounded-lg border border-gray-100 px-3 py-2 outline-none focus:border-orange-500" placeholder="INVITE-XXXX-YYYY" />
        </div>
        <x-button-outline type="submit">Vérifier</x-button-outline>
        <p class="text-xs">La vérification email/token + blocage multi-colocation se fait côté backend.</p>
      </form>
    </x-card>

    <x-card class="p-8">
      <h2 class="text-lg font-semibold text-black-600">Invitation trouvée (placeholder)</h2>
      <div class="mt-4 space-y-2 text-sm">
        <div><span class="font-medium text-black-600">Colocation:</span> {{ $invitation['colocation_name'] ?? 'Appartement Agdal' }}</div>
        <div><span class="font-medium text-black-600">Envoyée à:</span> {{ $invitation['email'] ?? 'you@example.com' }}</div>
        <div><span class="font-medium text-black-600">Statut:</span> <x-badge>{{ $invitation['status'] ?? 'pending' }}</x-badge></div>
      </div>

      <div class="mt-6 flex flex-col sm:flex-row gap-3">
        <form method="POST" action="{{ url('/invitations/accept') }}">
          @csrf
          <input type="hidden" name="token" value="{{ request('token') }}" />
          <x-button-primary type="submit">Accepter</x-button-primary>
        </form>
        <form method="POST" action="{{ url('/invitations/refuse') }}">
          @csrf
          <input type="hidden" name="token" value="{{ request('token') }}" />
          <x-button-outline type="submit">Refuser</x-button-outline>
        </form>
      </div>
    </x-card>
  </div>
@endsection
