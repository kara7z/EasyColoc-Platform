@extends('layouts.app')

@section('title', 'Inviter un membre — EasyColoc')

@section('content')
  <div class="flex items-start justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-black-600">Inviter un membre</h1>
      <p class="mt-1 text-sm">Envoi email + token unique (implémentation côté backend).</p>
    </div>
    <a href="{{ url()->previous() }}" class="text-orange-500 hover:underline">← Retour</a>
  </div>

  <div class="mt-8 max-w-2xl">
    <x-card class="p-8">
      <form method="POST" action="{{ url('/colocations/' . ($colocation['id'] ?? 1) . '/invitations') }}" class="space-y-4">
        @csrf

        <div>
          <label class="block text-sm font-medium text-black-600">Email du membre</label>
          <input name="email" type="email" required class="mt-1 w-full rounded-lg border border-gray-100 px-3 py-2 outline-none focus:border-orange-500" placeholder="friend@example.com" />
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
          <x-button-primary type="submit">Envoyer invitation</x-button-primary>
          <a href="{{ url('/colocations/' . ($colocation['id'] ?? 1)) }}"><x-button-outline type="button">Annuler</x-button-outline></a>
        </div>
      </form>

      <div class="mt-8 border-t border-gray-100 pt-6">
        <div class="text-sm font-medium text-black-600">Exemple de résultat (placeholder)</div>
        <div class="mt-2 text-sm">
          Token: <span class="font-mono bg-white-300 px-2 py-1 rounded">{{ $token ?? 'INVITE-XXXX-YYYY' }}</span>
        </div>
        <div class="mt-2 text-sm">Lien: <span class="font-mono">{{ url('/invitations/accept?token=INVITE-XXXX-YYYY') }}</span></div>
      </div>
    </x-card>
  </div>
@endsection
