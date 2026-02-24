@extends('layouts.app')

@section('title', 'Catégories — EasyColoc')

@section('content')
  <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-black-600">Catégories</h1>
      <p class="mt-1 text-sm">Gérées par l’Owner (selon votre périmètre).</p>
    </div>
    <a href="{{ url('/categories/create') }}"><x-button-primary>Nouvelle catégorie</x-button-primary></a>
  </div>

  <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
    <x-card class="p-6 lg:col-span-2">
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead>
            <tr class="text-left border-b border-gray-100">
              <th class="py-2">Nom</th>
              <th class="py-2">Couleur</th>
              <th class="py-2">Créée le</th>
              <th class="py-2"></th>
            </tr>
          </thead>
          <tbody>
            @forelse(($categories ?? []) as $cat)
              <tr class="border-b border-gray-100">
                <td class="py-2 font-medium text-black-600">{{ $cat['name'] ?? '—' }}</td>
                <td class="py-2">
                  <span class="inline-flex items-center gap-2">
                    <span class="h-3 w-3 rounded-full" style="background: {{ $cat['color'] ?? '#F53855' }}"></span>
                    <span class="text-xs font-mono">{{ $cat['color'] ?? '#F53855' }}</span>
                  </span>
                </td>
                <td class="py-2">{{ $cat['created_at'] ?? '—' }}</td>
                <td class="py-2 text-right">
                  <div class="inline-flex gap-3">
                    <a href="{{ url('/categories/' . ($cat['id'] ?? 1) . '/edit') }}" class="text-orange-500 hover:underline">Edit</a>
                    <form method="POST" action="{{ url('/categories/' . ($cat['id'] ?? 1)) }}">
                      @csrf
                      @method('DELETE')
                      <button class="text-orange-500 hover:underline">Delete</button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr><td colspan="4" class="py-6 text-center">Aucune catégorie.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </x-card>

    <x-card class="p-6">
      <h2 class="text-lg font-semibold text-black-600">Conseil</h2>
      <p class="mt-2 text-sm">Gardez des catégories simples: Loyer, Courses, Internet, Électricité…</p>
      <div class="mt-4">
        <a class="text-orange-500 hover:underline" href="{{ url('/expenses/create') }}">Ajouter une dépense →</a>
      </div>
    </x-card>
  </div>
@endsection
