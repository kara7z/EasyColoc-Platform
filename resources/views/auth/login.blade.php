@extends('layouts.guest')

@section('title', 'Connexion — EasyColoc')

@section('content')
  <div class="max-w-md mx-auto">
    <x-card class="p-8">
      <h1 class="text-2xl font-bold text-black-600">Se connecter</h1>
      <p class="mt-2 text-sm">Accédez à votre colocation et à vos soldes.</p>

      <form method="POST" action="{{ url('/login') }}" class="mt-6 space-y-4">
        @csrf

        <div>
          <label class="block text-sm font-medium text-black-600">Email</label>
          <input name="email" type="email" required autocomplete="email" class="mt-1 w-full rounded-lg border border-gray-100 px-3 py-2 outline-none focus:border-orange-500" placeholder="you@example.com" />
        </div>

        <div>
          <label class="block text-sm font-medium text-black-600">Mot de passe</label>
          <input name="password" type="password" required autocomplete="current-password" class="mt-1 w-full rounded-lg border border-gray-100 px-3 py-2 outline-none focus:border-orange-500" placeholder="••••••••" />
        </div>

        <div class="flex items-center justify-between">
          <label class="inline-flex items-center gap-2 text-sm">
            <input type="checkbox" name="remember" class="rounded border-gray-100" />
            Se souvenir de moi
          </label>
          <a href="{{ url('/forgot-password') }}" class="text-sm text-orange-500 hover:underline">Mot de passe oublié ?</a>
        </div>

        <x-button-primary type="submit" class="w-full">Connexion</x-button-primary>

        <p class="text-sm text-center">
          Pas de compte ?
          <a class="text-orange-500 hover:underline" href="{{ url('/register') }}">Créer un compte</a>
        </p>
      </form>
    </x-card>
  </div>
@endsection
