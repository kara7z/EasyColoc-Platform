@extends('layouts.guest')

@section('title', 'EasyColoc — Gestion de colocation')

@section('content')
  <section class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center" id='features'>
    <div>
      <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-black-600 leading-tight">
        Gérez votre colocation <span class="text-orange-500">sans calculs manuels</span>.
      </h1>
      <p class="mt-5 text-lg">
        EasyColoc suit les dépenses, calcule automatiquement les soldes et affiche une vue claire de
        <span class="font-medium">« qui doit quoi à qui »</span>.
      </p>

      <div class="mt-8 flex flex-col sm:flex-row gap-3">
        <a href="{{ url('/register') }}"><x-button-primary>Créer un compte</x-button-primary></a>
        <a href="{{ url('/login') }}"><x-button-outline>Se connecter</x-button-outline></a>
      </div>

      <ul class="mt-10 space-y-3 relative pl-6" >
        <li class="relative custom-list circle-check">Invitations par lien/token (email)</li>
        <li class="relative custom-list circle-check">Dépenses & catégories, filtre par mois</li>
        <li class="relative custom-list circle-check">Remboursements simplifiés + « Marquer payé »</li>
        <li class="relative custom-list circle-check">Réputation & administration globale</li>
      </ul>
    </div>

    <div class="flex justify-center lg:justify-end">
      <img src="{{ asset('assets/Illustration1.png') }}" alt="EasyColoc" class="w-full max-w-lg" />
    </div>
  </section>

  <section  class="mt-16">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <x-card class="p-6">
        <div class="text-black-600 font-semibold text-lg">Colocations</div>
        <p class="mt-2">Créer, annuler, inviter, gérer membres & rôles (Owner / Member).</p>
      </x-card>
      <x-card class="p-6">
        <div class="text-black-600 font-semibold text-lg">Dépenses</div>
        <p class="mt-2">Ajout / suppression, catégories, historique et statistiques mensuelles.</p>
      </x-card>
      <x-card class="p-6">
        <div class="text-black-600 font-semibold text-lg">Balances & dettes</div>
        <p class="mt-2">Calcul auto des soldes + vue « qui doit à qui » et paiements simples.</p>
      </x-card>
    </div>
  </section>

  <section id="how" class="mt-16 grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
    <div class="order-2 lg:order-1">
      <img src="{{ asset('assets/Illustration2.png') }}" alt="Comment ça marche" class="w-full max-w-lg" />
    </div>
    <div class="order-1 lg:order-2">
      <h2 class="text-2xl sm:text-3xl font-bold text-black-600">Comment ça marche</h2>
      <ol class="mt-6 space-y-4">
        <li class="flex gap-3">
          <x-badge variant="info">1</x-badge>
          <div>
            <div class="font-medium text-black-600">Créez une colocation</div>
            <div class="text-sm">Vous devenez automatiquement Owner.</div>
          </div>
        </li>
        <li class="flex gap-3">
          <x-badge variant="info">2</x-badge>
          <div>
            <div class="font-medium text-black-600">Invitez vos colocataires</div>
            <div class="text-sm">Par email + token unique, acceptation/refus.</div>
          </div>
        </li>
        <li class="flex gap-3">
          <x-badge variant="info">3</x-badge>
          <div>
            <div class="font-medium text-black-600">Ajoutez des dépenses</div>
            <div class="text-sm">EasyColoc recalculera les soldes automatiquement.</div>
          </div>
        </li>
      </ol>
    </div>
  </section>

  <section id="pricing" class="mt-16">
    <x-card class="p-8">
      <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
        <div>
          <h3 class="text-2xl font-bold text-black-600">Simple à déployer</h3>
          <p class="mt-2">Architecture monolithique MVC Laravel + Eloquent + migrations.</p>
        </div>
        <a href="{{ url('/register') }}"><x-button-primary>Commencer</x-button-primary></a>
      </div>
    </x-card>
  </section>
@endsection
