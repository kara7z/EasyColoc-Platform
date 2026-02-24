@extends('layouts.app')

@section('title', 'Modifier catégorie — EasyColoc')

@section('content')
  <div class="flex items-start justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-black-600">Modifier catégorie</h1>
      <p class="mt-1 text-sm">Template uniquement.</p>
    </div>
    <a href="{{ url('/categories') }}" class="text-orange-500 hover:underline">← Retour</a>
  </div>

  <div class="mt-8 max-w-2xl">
    <x-card class="p-8">
      <form method="POST" action="{{ url('/categories/' . ($category['id'] ?? 1)) }}" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
          <label class="block text-sm font-medium text-black-600">Nom</label>
          <input name="name" value="{{ $category['name'] ?? '' }}" required class="mt-1 w-full rounded-lg border border-gray-100 px-3 py-2 outline-none focus:border-orange-500" />
        </div>
        <div>
          <label class="block text-sm font-medium text-black-600">Couleur</label>
          <input name="color" type="color" value="{{ $category['color'] ?? '#F53855' }}" class="mt-1 h-10 w-20 rounded border border-gray-100" />
        </div>
        <div class="flex flex-col sm:flex-row gap-3">
          <x-button-primary type="submit">Enregistrer</x-button-primary>
          <a href="{{ url('/categories') }}"><x-button-outline type="button">Annuler</x-button-outline></a>
        </div>
      </form>
    </x-card>
  </div>
@endsection
