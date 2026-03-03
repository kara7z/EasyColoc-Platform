@extends('layouts.app')

@section('title', 'Invitations — EasyColoc')

@section('content')
  <div class="flex items-start justify-between gap-3">
    <div>
      <h2 class="text-2xl font-bold text-black-600">Invitations</h2>
      <p class="mt-1 text-sm text-black-598">
        Créez un token à copier ou envoyez une invitation par email (optionnel).
      </p>
      <div class="mt-1 text-sm">
        <span class="font-medium text-black-598">Colocation:</span>
        {{ $colocation->name ?? '—' }}
      </div>
    </div>

    <a href="{{ route('colocations.show', $colocation) }}" class="text-orange-500 hover:underline">
      ← Retour
    </a>
  </div>

  @if(session('success'))
    <div class="mt-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-800">
      {{ session('success') }}
    </div>
  @endif

  @if($errors->any())
    <div class="mt-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700">
      {{ $errors->first() }}
    </div>
  @endif

  <div class="mt-7 grid grid-cols-1 lg:grid-cols-2 gap-6">
    <x-card class="p-6">
      <h3 class="text-lg font-semibold text-black-600">Créer une invitation</h3>
      <p class="mt-1 text-sm text-black-598">
        L’email est optionnel. Si vous laissez vide, l’invitation sera “publique” (token partageable).
      </p>

      <form method="POST" action="{{ route('invitations.store', $colocation) }}" class="mt-4 space-y-3">
        @csrf

        <div>
          <label class="block text-sm font-medium text-black-600">Email (optionnel)</label>
          <input
            name="email"
            value="{{ old('email') }}"
            class="mt-1 w-full rounded-lg border border-gray-100 px-3 py-2 outline-none focus:border-orange-500"
            placeholder="ex: user@email.com"
          />
          @error('email')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <x-button-primary type="submit">Créer le token</x-button-primary>
      </form>

      @if(session('token') && session('link'))
        <div class="mt-6 rounded-xl border border-gray-100 bg-white p-4">
          <h4 class="font-semibold text-black-600">Token créé</h4>

          <div class="mt-3 text-sm">
            <div class="font-medium text-black-598">Token</div>
            <div class="mt-1 flex items-center gap-2">
              <code class="px-2 py-1 rounded-lg border border-gray-100 bg-gray-50 font-mono">
                {{ session('token') }}
              </code>

              <button type="button" class="text-orange-500 hover:underline text-sm" data-copy="{{ session('token') }}">
                Copier
              </button>
            </div>
          </div>

          <div class="mt-4 text-sm">
            <div class="font-medium text-black-598">Lien</div>
            <div class="mt-1 flex items-start gap-2">
              <code class="px-2 py-1 rounded-lg border border-gray-100 bg-gray-50 font-mono break-all">
                {{ session('link') }}
              </code>

              <button type="button" class="text-orange-500 hover:underline text-sm mt-1" data-copy="{{ session('link') }}">
                Copier
              </button>
            </div>
          </div>

          <div class="mt-4">
            <a class="text-orange-500 hover:underline text-sm" href="{{ session('link') }}">
              Ouvrir la page d’acceptation →
            </a>
          </div>
        </div>
      @endif
    </x-card>

    <x-card class="p-6">
      <h3 class="text-lg font-semibold text-black-600">Invitations en attente</h3>

      <div class="mt-4 space-y-3 text-sm">
        @forelse(($invites ?? []) as $i)
          <div class="rounded-xl border border-gray-100 p-4">
            <div class="flex items-start justify-between gap-3">
              <div>
                <div class="font-medium text-black-600">{{ $i->token }}</div>
                <div class="mt-1 text-xs text-gray-500">
                  {{ $i->email ?? 'public (sans email)' }}
                  • statut: {{ $i->status ?? 'pending' }}
                  @if($i->expires_at)
                    • expire: {{ $i->expires_at->format('Y-m-d H:i') }}
                  @endif
                </div>
              </div>

              <a class="text-orange-500 hover:underline"
                 href="{{ route('invitations.check', ['token' => $i->token]) }}">
                Voir →
              </a>
            </div>

            <div class="mt-3 flex flex-col sm:flex-row gap-2">
              <button type="button" class="text-orange-500 hover:underline text-sm text-left" data-copy="{{ $i->token }}">
                Copier token
              </button>

              <button type="button" class="text-orange-500 hover:underline text-sm text-left"
                      data-copy="{{ route('invitations.check', ['token' => $i->token]) }}">
                Copier lien
              </button>
            </div>
          </div>
        @empty
          <div class="text-sm text-black-598">Aucune invitation en attente.</div>
        @endforelse
      </div>
    </x-card>
  </div>
@endsection
