@extends('layouts.app')

@section('title', 'Ajouter une dépense — EasyColoc')

@section('content')
  <div class="flex items-start justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-black-600">Ajouter une dépense</h1>
      <p class="mt-1 text-sm">Titre, montant, date, catégorie, payeur.</p>
    </div>
    <a href="{{ url()->previous() }}" class="text-orange-500 hover:underline">← Retour</a>
  </div>

  <div class="mt-8 max-w-2xl">
    <x-card class="p-8">
      <form method="POST" action="{{ route('expenses.store', $colocation->id) }}" class="space-y-4">
        @csrf

        <div>
          <label class="block text-sm font-medium text-black-600">Titre</label>
          <input name="title" required class="mt-1 w-full rounded-lg border border-gray-100 px-3 py-2 outline-none focus:border-orange-500" placeholder="Ex: Courses" value="{{ old('title') }}" />
          @error('title')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-black-600">Montant</label>
            <input name="amount" type="number" step="0.01" required class="mt-1 w-full rounded-lg border border-gray-100 px-3 py-2 outline-none focus:border-orange-500" placeholder="0.00" value="{{ old('amount') }}" />
            @error('amount')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
          </div>
          <div>
            <label class="block text-sm font-medium text-black-600">Date</label>
            <input name="spent_at" type="date" required class="mt-1 w-full rounded-lg border border-gray-100 px-3 py-2 outline-none focus:border-orange-500" value="{{ old('spent_at', date('Y-m-d')) }}" />
            @error('spent_at')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium text-black-600">Catégorie</label>
          <select name="category_id" required class="mt-1 w-full rounded-lg border border-gray-100 px-3 py-2 outline-none focus:border-orange-500">
            @foreach($categories as $cat)
              <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
          </select>
          @error('category_id')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
          <x-button-primary type="submit">Enregistrer</x-button-primary>
          <a href="{{ route('colocations.show', $colocation) }}"><x-button-outline type="button">Annuler</x-button-outline></a>
        </div>
      </form>
    </x-card>
  </div>
@endsection
