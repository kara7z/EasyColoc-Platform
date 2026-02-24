@extends('layouts.app')

@section('title', 'Dépenses — EasyColoc')

@section('content')
  <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-black-600">Dépenses</h1>
      <p class="mt-1 text-sm">Historique et filtrage par mois.</p>
    </div>
    <div class="flex gap-3">
      <a href="{{ url('/colocations/' . ($colocation['id'] ?? 1) . '/expenses/create') }}"><x-button-primary>Ajouter</x-button-primary></a>
      <a href="{{ url('/colocations/' . ($colocation['id'] ?? 1)) }}"><x-button-outline>Retour colocation</x-button-outline></a>
    </div>
  </div>

  <x-card class="mt-8 p-6">
    <form method="GET" action="#" class="flex flex-col md:flex-row md:items-end gap-4">
      <div>
        <label class="block text-sm font-medium text-black-600">Mois</label>
        <select name="month" class="mt-1 rounded-lg border border-gray-100 px-3 py-2 outline-none focus:border-orange-500">
          <option value="">Tous les mois</option>
          @foreach(($months ?? ['2026-02' => 'Février 2026', '2026-01' => 'Janvier 2026']) as $value => $label)
            <option value="{{ $value }}" @selected(request('month') == $value)>{{ $label }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium text-black-600">Catégorie</label>
        <select name="category" class="mt-1 rounded-lg border border-gray-100 px-3 py-2 outline-none focus:border-orange-500">
          <option value="">Toutes</option>
          @foreach(($categories ?? []) as $cat)
            <option value="{{ $cat['id'] ?? '' }}">{{ $cat['name'] ?? '—' }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <x-button-outline type="submit">Filtrer</x-button-outline>
      </div>
    </form>

    <div class="mt-6 overflow-x-auto">
      <table class="w-full text-sm">
        <thead>
          <tr class="text-left border-b border-gray-100">
            <th class="py-2">Titre</th>
            <th class="py-2">Catégorie</th>
            <th class="py-2">Payeur</th>
            <th class="py-2">Montant</th>
            <th class="py-2">Date</th>
            <th class="py-2"></th>
          </tr>
        </thead>
        <tbody>
          @forelse(($expenses ?? []) as $e)
            <tr class="border-b border-gray-100">
              <td class="py-2 font-medium text-black-600">{{ $e['title'] ?? '—' }}</td>
              <td class="py-2">{{ $e['category'] ?? '—' }}</td>
              <td class="py-2">{{ $e['payer'] ?? '—' }}</td>
              <td class="py-2">{{ $e['amount'] ?? '0.00' }}</td>
              <td class="py-2">{{ $e['date'] ?? '—' }}</td>
              <td class="py-2 text-right">
                <div class="inline-flex gap-3">
                  <a href="{{ url('/expenses/' . ($e['id'] ?? 1) . '/edit') }}" class="text-orange-500 hover:underline">Edit</a>
                  <form method="POST" action="{{ url('/expenses/' . ($e['id'] ?? 1)) }}">
                    @csrf
                    @method('DELETE')
                    <button class="text-orange-500 hover:underline">Delete</button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr><td colspan="6" class="py-6 text-center">Aucune dépense.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </x-card>
@endsection
