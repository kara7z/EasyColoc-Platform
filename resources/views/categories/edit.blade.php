@extends('layouts.app')

@section('title', 'Modifier catégorie — EasyColoc')

@section('content')
  <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
    <div>
      <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Modifier la catégorie</h1>
      <p class="mt-2 text-slate-500 font-medium">Mettez à jour les informations de cette catégorie.</p>
    </div>
    <a href="{{ url('/categories') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-orange-600 font-bold hover:-translate-x-1 transition-transform">
      <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
      Retour aux catégories
    </a>
  </div>

  <div class="mt-8 max-w-2xl">
    <x-card class="p-8 sm:p-10 shadow-xl shadow-slate-200/50 border-0 ring-1 ring-slate-100">
      <form method="POST" action="{{ url('/categories/' . ($category['id'] ?? 1)) }}" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="group">
          <label class="block text-sm font-bold text-slate-700 tracking-wide mb-2 group-focus-within:text-orange-500 transition-colors">Nom de la catégorie</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
              <svg class="h-5 w-5 text-slate-400 group-focus-within:text-orange-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
            </div>
            <input 
              name="name" 
              value="{{ $category['name'] ?? '' }}" 
              required 
              class="w-full rounded-xl border border-slate-200 bg-slate-50 pl-11 pr-4 py-3 text-slate-800 font-medium outline-none focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-500/10 transition-all placeholder-slate-400" 
            />
          </div>
        </div>

        <div class="group">
          <label class="block text-sm font-bold text-slate-700 tracking-wide mb-2 group-focus-within:text-orange-500 transition-colors">Couleur d'identification</label>
          <div class="flex items-center gap-4">
            <div class="relative w-16 h-16 rounded-xl overflow-hidden border-2 border-slate-200 shadow-sm focus-within:border-orange-500 focus-within:ring-4 focus-within:ring-orange-500/10 transition-all cursor-pointer">
              <input 
                name="color" 
                type="color" 
                value="{{ $category['color'] ?? '#F53855' }}" 
                class="absolute -top-2 -left-2 w-24 h-24 cursor-pointer" 
              />
            </div>
            <span class="text-sm font-medium text-slate-500">Cliquez pour modifier la couleur</span>
          </div>
        </div>

        <div class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row gap-3">
          <x-button-primary type="submit" class="flex-1 justify-center shadow-orange-md hover:shadow-orange-glow text-lg py-3">
            Enregistrer les modifications
          </x-button-primary>
          <a href="{{ url('/categories') }}" class="flex-1">
            <x-button-outline type="button" class="w-full justify-center text-lg py-3">Annuler</x-button-outline>
          </a>
        </div>
      </form>
    </x-card>
  </div>
@endsection
