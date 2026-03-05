@extends('layouts.guest')

@section('title', 'Inscription — EasyColoc')

@section('content')
<div class="max-w-md mx-auto animate-[slideDown_0.4s_ease-out]">
  <div class="text-center mb-10 mt-8">
    <div class="inline-flex items-center justify-center p-3 bg-orange-50 rounded-2xl mb-5 shadow-sm">
      <img src="{{ asset('favicon/favicon-96x96.png') }}" alt="EasyColoc" class="h-12 w-auto drop-shadow-sm" />
    </div>
    <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Créer un compte</h1>
    <p class="mt-3 text-slate-500 font-medium">Rejoignez EasyColoc gratuitement.</p>
  </div>

  <x-card class="p-8 sm:p-10 shadow-xl shadow-slate-200/50 border-0 ring-1 ring-slate-100">
    <form method="POST" action="{{ url('/register') }}" class="space-y-6">
      @csrf

      <div class="group">
        <label class="block text-sm font-bold text-slate-700 tracking-wide mb-2 group-focus-within:text-orange-500 transition-colors">Nom complet</label>
        <div class="relative">
          <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-orange-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
          </div>
          <input
            name="name"
            value="{{ old('name') }}"
            required
            autocomplete="name"
            class="w-full rounded-xl border border-slate-200 bg-slate-50 pl-11 pr-4 py-3 text-slate-800 font-medium outline-none focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-500/10 transition-all placeholder-slate-400"
            placeholder="Jean Dupont"
          >
        </div>
        @error('name')
          <p class="text-red-500 font-medium text-sm mt-2 flex items-center gap-1.5 animate-[slideDown_0.2s_ease-out]">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ $message }}
          </p>
        @enderror
      </div>

      <div class="group">
        <label class="block text-sm font-bold text-slate-700 tracking-wide mb-2 group-focus-within:text-orange-500 transition-colors">Email</label>
        <div class="relative">
          <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-orange-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
          </div>
          <input
            name="email"
            type="email"
            value="{{ old('email') }}"
            required
            autocomplete="email"
            class="w-full rounded-xl border border-slate-200 bg-slate-50 pl-11 pr-4 py-3 text-slate-800 font-medium outline-none focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-500/10 transition-all placeholder-slate-400"
            placeholder="vous@exemple.com"
          >
        </div>
        @error('email')
          <p class="text-red-500 font-medium text-sm mt-2 flex items-center gap-1.5 animate-[slideDown_0.2s_ease-out]">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ $message }}
          </p>
        @enderror
      </div>

      <div class="group">
        <label class="block text-sm font-bold text-slate-700 tracking-wide mb-2 group-focus-within:text-orange-500 transition-colors">Mot de passe</label>
        <div class="relative">
          <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-orange-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
          </div>
          <input
            name="password"
            type="password"
            required
            autocomplete="new-password"
            class="w-full rounded-xl border border-slate-200 bg-slate-50 pl-11 pr-4 py-3 text-slate-800 font-medium outline-none focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-500/10 transition-all placeholder-slate-400 tracking-widest"
            placeholder="••••••••"
          >
        </div>
        @error('password')
          <p class="text-red-500 font-medium text-sm mt-2 flex items-center gap-1.5 animate-[slideDown_0.2s_ease-out]">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ $message }}
          </p>
        @enderror
      </div>

      <div class="group">
        <label class="block text-sm font-bold text-slate-700 tracking-wide mb-2 group-focus-within:text-orange-500 transition-colors">Confirmer le mot de passe</label>
        <div class="relative">
          <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-orange-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
          </div>
          <input
            name="password_confirmation"
            type="password"
            required
            autocomplete="new-password"
            class="w-full rounded-xl border border-slate-200 bg-slate-50 pl-11 pr-4 py-3 text-slate-800 font-medium outline-none focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-500/10 transition-all placeholder-slate-400 tracking-widest"
            placeholder="••••••••"
          >
        </div>
      </div>

      <x-button-primary type="submit" class="w-full justify-center flex items-center gap-2 text-lg shadow-orange-md hover:shadow-orange-glow mt-4">
        Créer mon compte
      </x-button-primary>

      <div class="mt-8 pt-6 border-t border-slate-100 text-center">
        <p class="text-sm font-medium text-slate-500">
          Déjà un compte ?
          <a href="{{ url('/login') }}" class="text-orange-600 hover:text-orange-700 hover:underline hover:underline-offset-2 transition-all font-bold ml-1">Connectez-vous</a>
        </p>
      </div>
    </form>
  </x-card>
</div>

<style>
  @keyframes slideDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection
