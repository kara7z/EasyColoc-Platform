@extends('layouts.guest')

@section('title', 'Inscription — EasyColoc')

@section('content')
  <div class="max-w-md mx-auto">
    <x-card class="p-8">
      <h1 class="text-2xl font-bold text-black-600">Créer un compte</h1>
      <p class="mt-2 text-sm">Le premier inscrit peut être promu admin global (selon votre logique).</p>

      <form method="POST" action="{{ url('/register') }}" class="mt-6 space-y-4">
        @csrf

        <div>
          <label class="block text-sm font-medium text-black-600">Nom</label>
          <input name="name" required autocomplete="name" class="mt-1 w-full rounded-lg border border-gray-100 px-3 py-2 outline-none focus:border-orange-500" placeholder="Votre nom" />
        </div>

        <div>
          <label class="block text-sm font-medium text-black-600">Email</label>
          <input name="email" type="email" required autocomplete="email" class="mt-1 w-full rounded-lg border border-gray-100 px-3 py-2 outline-none focus:border-orange-500" placeholder="you@example.com" />
        </div>

        <div>
          <label class="block text-sm font-medium text-black-600">Mot de passe</label>
          <input name="password" type="password" required autocomplete="new-password" class="mt-1 w-full rounded-lg border border-gray-100 px-3 py-2 outline-none focus:border-orange-500" placeholder="••••••••" />
        </div>

        <div>
          <label class="block text-sm font-medium text-black-600">Confirmer</label>
          <input name="password_confirmation" type="password" required autocomplete="new-password" class="mt-1 w-full rounded-lg border border-gray-100 px-3 py-2 outline-none focus:border-orange-500" placeholder="••••••••" />
        </div>

        <x-button-primary type="submit" class="w-full">Inscription</x-button-primary>

        <p class="text-sm text-center">
          Déjà un compte ?
          <a class="text-orange-500 hover:underline" href="{{ url('/login') }}">Se connecter</a>
        </p>
      </form>
    </x-card>
  </div>
@endsection
