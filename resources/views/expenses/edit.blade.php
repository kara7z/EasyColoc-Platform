@extends('layouts.app')

@section('title', 'Modifier dépense — EasyColoc')

@section('content')
  <div class="flex items-start justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-black-600">Modifier dépense</h1>
      <p class="mt-1 text-sm">Template uniquement (remplissage côté backend).</p>
    </div>
    <a href="{{ url()->previous() }}" class="text-orange-500 hover:underline">← Retour</a>
  </div>

  <div class="mt-8 max-w-2xl">
    <x-card class="p-8">
      <form method="POST" action="{{ route('expenses.update', $expense->id) }}" class="space-y-4">
        @csrf
        @method('PATCH')

        <div>
          <label class="block text-sm font-medium text-black-600">Titre</label>
          <input name="title" value="{{ old('title', $expense->title) }}" required class="mt-1 w-full rounded-lg border border-gray-100 px-3 py-2 outline-none focus:border-orange-500" />
          @error('title')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-black-600">Montant</label>
            <input name="amount" type="number" step="0.01" value="{{ old('amount', $expense->amount) }}" required class="mt-1 w-full rounded-lg border border-gray-100 px-3 py-2 outline-none focus:border-orange-500" />
            @error('amount')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
          </div>
          <div>
            <label class="block text-sm font-medium text-black-600">Date</label>
            <input name="spent_at" type="date" value="{{ old('spent_at', $expense->spent_at->format('Y-m-d')) }}" required class="mt-1 w-full rounded-lg border border-gray-100 px-3 py-2 outline-none focus:border-orange-500" />
            @error('spent_at')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium text-black-600">Catégorie</label>
          <select name="category_id" class="mt-1 w-full rounded-lg border border-gray-100 px-3 py-2 outline-none focus:border-orange-500">
            @foreach($categories as $cat)
              <option value="{{ $cat->id }}" @selected($cat->id == $expense->category_id)>{{ $cat->name }}</option>
            @endforeach
          </select>
          @error('category_id')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
          <x-button-primary type="submit">Enregistrer</x-button-primary>
          <a href="{{ url()->previous() }}"><x-button-outline type="button">Annuler</x-button-outline></a>
        </div>
      </form>
    </x-card>
  </div>
@endsection
