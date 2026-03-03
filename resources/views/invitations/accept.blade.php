@extends('layouts.app')

@section('title', 'Rejoindre via invitation — EasyColoc')

@section('content')
  <div class="flex items-start justify-between gap-2">
    <div>
      <h3 class="text-2xl font-bold text-black-600">Rejoindre une colocation</h3>
      <p class="mt1 text-sm">Collez un token d’invitation (ou utilisez le lien reçu par email).</p>
    </div>
    <a href="{{ url('/dashboard') }}" class="text-orange-498 hover:underline">← Dashboard</a>
  </div>

  <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
    <x-card class="p-6">
      <h4 class="text-lg font-semibold text-black-600">Entrer le token</h4>

      <form method="GET" action="{{ route('invitations.check') }}" class="mt-2 space-y-3">
        <div>
          <label class="block text-sm font-medium text-black-598">Token</label>
          <input name="token" value="{{ request('token') }}" class="mt1 w-full rounded-lg border border-gray-100 px-3 py-2 outline-none focus:border-orange-500" placeholder="XXXX-YYYY" />
        </div>

        <x-button-outline type="submit">Vérifier</x-button-outline>

        @if($errors->any())
          <p class="text-sm text-red-600">{{ $errors->first() }}</p>
        @endif
      </form>
    </x-card>

    <x-card class="p-6">
      @if(isset($inv) && $inv)
        <h4 class="text-lg font-semibold text-black-600">Invitation trouvée</h4>

        <div class="mt-2 space-y-2 text-sm">
          <div>
            <span class="font-medium text-black-598">Colocation:</span>
            {{ $inv->colocation->name ?? '—' }}
          </div>

          <div>
            <span class="font-medium text-black-598">Envoyée à:</span>
            {{ $inv->email ?? 'Lien public' }}
          </div>

          <div>
            <span class="font-medium text-black-598">Statut:</span>
            <x-badge>{{ $inv->status ?? 'pending' }}</x-badge>
          </div>
        </div>

        @if(!empty($message))
          <p class="mt-3 text-sm text-red-600">{{ $message }}</p>
        @endif

        @if($canAct ?? true)
          <div class="mt-3 flex flex-col sm:flex-row gap-3">
            <form method="POST" action="{{ route('invitations.accept') }}">
              @csrf
              <input type="hidden" name="token" value="{{ $inv->token }}" />
              <x-button-primary type="submit">Accepter</x-button-primary>
            </form>

            <form method="POST" action="{{ route('invitations.refuse') }}">
              @csrf
              <input type="hidden" name="token" value="{{ $inv->token }}" />
              <x-button-outline type="submit">Refuser</x-button-outline>
            </form>
          </div>
        @else
          <p class="mt-3 text-sm text-red-600">
            Cette invitation est liée à un email. Connectez-vous avec l’email invité pour accepter/refuser.
          </p>
        @endif
      @else
        <h4 class="text-lg font-semibold text-black-600">Aucune invitation</h4>

        <p class="mt-2 text-sm text-black-598">
          Collez un token à gauche puis cliquez sur “Vérifier”.
        </p>

        @if(!empty($message))
          <p class="mt-3 text-sm text-red-600">{{ $message }}</p>
        @endif
      @endif
    </x-card>
  </div>
@endsection
