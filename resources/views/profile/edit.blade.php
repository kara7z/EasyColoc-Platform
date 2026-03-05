@extends('layouts.app')

@section('title', 'Profile')

@section('content')
@php
    $profileUser = auth()->user();
    $initial = strtoupper(substr($profileUser?->name ?? 'U', 0, 1));
@endphp

<div class="max-w-5xl mx-auto px-4 py-8 sm:py-10">
    <div class="relative overflow-hidden rounded-3xl border border-slate-200 bg-gradient-to-br from-white to-orange-50/40 shadow-card p-6 sm:p-8">
        <div class="pointer-events-none absolute -top-12 -right-12 h-40 w-40 rounded-full bg-orange-200/40 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-12 -left-12 h-44 w-44 rounded-full bg-rose-200/30 blur-3xl"></div>

        <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center gap-4">
                <div class="h-16 w-16 rounded-2xl bg-gradient-to-br from-orange-500 to-rose-500 text-white font-extrabold text-2xl flex items-center justify-center shadow-orange-md">
                    {{ $initial }}
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Mon profil</h1>
                    <p class="mt-1 text-slate-500 font-medium">Gérez vos informations et la sécurité de votre compte.</p>
                    <div class="mt-3 flex flex-wrap gap-2">
                        <span class="inline-flex items-center rounded-full border border-slate-200 bg-white px-3 py-1 text-xs font-bold text-slate-600">
                            {{ $profileUser?->email }}
                        </span>
                        <span class="inline-flex items-center rounded-full border border-orange-200 bg-orange-50 px-3 py-1 text-xs font-bold text-orange-600">
                            Réputation: {{ $profileUser?->reputation ?? 0 }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="#profile-info" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-bold text-slate-600 hover:border-orange-300 hover:text-orange-600">Infos</a>
                <a href="#profile-security" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-bold text-slate-600 hover:border-orange-300 hover:text-orange-600">Sécurité</a>
                <a href="#profile-danger" class="rounded-xl border border-red-200 bg-red-50 px-4 py-2 text-sm font-bold text-red-600 hover:bg-red-100">Suppression</a>
            </div>
        </div>
    </div>

    <div class="mt-8 space-y-6">
        <div id="profile-info">
            @include('profile.partials.update-profile-information-form')
        </div>
        <div id="profile-security">
            @include('profile.partials.update-password-form')
        </div>
        <div id="profile-danger">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-toggle-password]').forEach(function (button) {
      button.addEventListener('click', function () {
        const inputId = button.getAttribute('data-toggle-password');
        const input = document.getElementById(inputId);
        if (!input) return;
        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        button.textContent = isHidden ? 'Masquer' : 'Afficher';
      });
    });

    const modal = document.getElementById('deleteModal');
    document.querySelectorAll('[data-delete-open]').forEach(function (btn) {
      btn.addEventListener('click', function () {
        modal?.classList.remove('hidden');
      });
    });

    document.querySelectorAll('[data-delete-close]').forEach(function (btn) {
      btn.addEventListener('click', function () {
        modal?.classList.add('hidden');
      });
    });

    document.addEventListener('keydown', function (event) {
      if (event.key === 'Escape') {
        modal?.classList.add('hidden');
      }
    });

    if (document.querySelector('[data-user-deletion-error]')) {
      modal?.classList.remove('hidden');
    }
  });
</script>
@endsection
