@extends('layouts.app')

@section('title', 'Créer catégorie — EasyColoc')

@section('content')
  <div class="flex items-start justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-black-600">Créer une catégorie</h1>
      <p class="mt-1 text-sm">Template uniquement.</p>
    </div>
    <a href="{{ url('/categories') }}" class="text-orange-500 hover:underline">← Retour</a>
  </div>

  <div class="mt-8 max-w-2xl">
    <x-card class="p-8">
      <form method="POST" action="{{ url('/categories') }}" class="space-y-4">
        @csrf
        <div>
          <label class="block text-sm font-medium text-black-600">Nom</label>
          <input name="name" required class="mt-1 w-full rounded-lg border border-gray-100 px-3 py-2 outline-none focus:border-orange-500" placeholder="Ex: Courses" />
        </div>
        <div>
          <label class="block text-sm font-medium text-black-600">Couleur</label>
          <input name="color" type="color" value="#F53855" class="mt-1 h-10 w-20 rounded border border-gray-100" />
        </div>
        <div class="flex flex-col sm:flex-row gap-3">
          <x-button-primary type="submit">Créer</x-button-primary>
          <a href="{{ url('/categories') }}"><x-button-outline type="button">Annuler</x-button-outline></a>
        </div>
      </form>
    </x-card>
  </div>
@endsection
