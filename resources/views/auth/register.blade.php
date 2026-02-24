@extends('layouts.guest')

@section('title', 'Inscription — EasyColoc')

@section('content')
<div class="max-w-md mx-auto">
    <x-card class="p-8">

        <h1 class="text-2xl font-bold text-black-600">Créer un compte</h1>
        <p class="mt-2 text-sm">Créez votre compte EasyColoc.</p>

        
        @if ($errors->any())
            <div class="mt-4 rounded-lg bg-red-100 p-3 text-red-700 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ url('/register') }}" class="mt-6 space-y-4">
            @csrf

            {{-- NAME --}}
            <div>
                <label class="block text-sm font-medium text-black-600">
                    Nom
                </label>

                <input
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autocomplete="name"
                    class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500"
                    placeholder="Votre nom"
                >

                @error('name')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- EMAIL --}}
            <div>
                <label class="block text-sm font-medium text-black-600">
                    Email
                </label>

                <input
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                    class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500"
                    placeholder="you@example.com"
                >

                @error('email')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- PASSWORD --}}
            <div>
                <label class="block text-sm font-medium text-black-600">
                    Mot de passe
                </label>

                <input
                    name="password"
                    type="password"
                    required
                    autocomplete="new-password"
                    class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500"
                    placeholder="••••••••"
                >

                @error('password')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- PASSWORD CONFIRMATION --}}
            <div>
                <label class="block text-sm font-medium text-black-600">
                    Confirmer le mot de passe
                </label>

                <input
                    name="password_confirmation"
                    type="password"
                    required
                    autocomplete="new-password"
                    class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500"
                    placeholder="••••••••"
                >
            </div>

            {{-- SUBMIT --}}
            <x-button-primary type="submit" class="w-full">
                Inscription
            </x-button-primary>

            <p class="text-sm text-center">
                Déjà un compte ?
                <a href="{{ url('/login') }}"
                   class="text-orange-500 hover:underline">
                    Se connecter
                </a>
            </p>

        </form>

    </x-card>
</div>
@endsection
