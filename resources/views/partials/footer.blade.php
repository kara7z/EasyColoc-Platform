@php
  $activeColocation = null;
  $isOwnerActive = false;

  if(auth()->check()){
    $activeColocation = \App\Models\Colocation::query()
      ->where('status', 'active')
      ->whereHas('memberships', function ($q) {
        $q->where('user_id', auth()->id())->whereNull('left_at');
      })
      ->latest()
      ->first();

    if ($activeColocation) {
      $isOwnerActive = $activeColocation->memberships()
        ->where('user_id', auth()->id())
        ->where('role', 'owner')
        ->whereNull('left_at')
        ->exists();
    }
  }
@endphp

<footer class="bg-slate-50 relative mt-16 pt-12 overflow-hidden border-t border-gray-100">
  {{-- Decorative Background Elements --}}
  <div class="absolute top-0 right-[-10%] w-64 h-64 bg-orange-400/5 rounded-full blur-3xl mix-blend-multiply"></div>
  <div class="absolute bottom-[-10%] left-[-10%] w-96 h-96 bg-red-400/5 rounded-full blur-3xl mix-blend-multiply"></div>

  <div class="max-w-screen-xl px-6 sm:px-8 lg:px-16 mx-auto relative z-10">

    <div class="grid gap-12 lg:grid-cols-12 mb-12">
      {{-- Brand + description --}}
      <div class="lg:col-span-5 flex flex-col items-start pr-0 sm:pr-8">
        <a href="{{ url('/') }}" class="flex items-center gap-3 group">
          <img src="{{ asset('favicon/favicon-96x96.png') }}" alt="EasyColoc" class="h-10 w-auto group-hover:scale-105 transition-transform duration-300" />
          <div>
            <div class="text-black-600 font-bold text-xl tracking-tight group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-orange-500 group-hover:to-red-500 transition-all">EasyColoc</div>
            <div class="text-xs text-gray-500 font-medium tracking-wide uppercase mt-0.5">Plateforme de Colocation</div>
          </div>
        </a>

        <p class="mt-6 text-gray-500 leading-relaxed text-sm max-w-sm">
          Suivez les dépenses partagées, calculez automatiquement les soldes, et obtenez une vue claire de 
          <span class="font-medium text-black-500">« qui doit quoi à qui »</span> sans aucune friction.
        </p>

        <div class="mt-8">
          <a href="#features"
             class="inline-flex items-center justify-center text-sm font-bold px-6 py-3 rounded-xl bg-orange-50 text-orange-600 hover:bg-orange-100 transition-colors shadow-sm active:scale-95 group/btn">
            Découvrir les fonctionnalités
            <svg class="w-4 h-4 ml-2 group-hover/btn:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
          </a>
        </div>
      </div>

      {{-- Links --}}
      <div class="lg:col-span-7">
        <div class="grid grid-cols-2 md:grid-cols-3 gap-8">
          {{-- Produit --}}
          <div>
            <h4 class="font-semibold text-black-600 text-sm tracking-widest uppercase mb-5">Produit</h4>
            <ul class="space-y-3 text-sm text-gray-500 font-medium">
              <li>
                <a class="hover:text-orange-600 hover:translate-x-1 inline-flex items-center gap-2 transition-transform duration-200" href="{{ url('/colocations') }}">
                  Colocations
                </a>
              </li>
              <li>
                <a class="hover:text-orange-600 hover:translate-x-1 inline-flex items-center gap-2 transition-transform duration-200" href="{{ url('/settlements') }}">
                  Qui doit à qui
                </a>
              </li>
              <li>
                <a class="hover:text-orange-600 hover:translate-x-1 inline-flex items-center gap-2 transition-transform duration-200" href="{{ url('/categories') }}">
                  Catégories
                </a>
              </li>
              <li>
                <a class="hover:text-orange-600 hover:translate-x-1 inline-flex items-center gap-2 transition-transform duration-200" href="{{ url('/dashboard') }}">
                  Dashboard
                </a>
              </li>
            </ul>
          </div>

          {{-- Compte --}}
          <div>
            <h4 class="font-semibold text-black-600 text-sm tracking-widest uppercase mb-5">Compte</h4>
            <ul class="space-y-3 text-sm text-gray-500 font-medium">
              @guest
                <li>
                  <a class="hover:text-orange-600 hover:translate-x-1 inline-flex items-center gap-2 transition-transform duration-200" href="{{ url('/login') }}">
                    Connexion
                  </a>
                </li>
                <li>
                  <a class="hover:text-orange-600 hover:translate-x-1 inline-flex items-center gap-2 transition-transform duration-200" href="{{ url('/register') }}">
                    Inscription
                  </a>
                </li>
              @endguest

              @auth
                <li>
                  <a class="hover:text-orange-600 hover:translate-x-1 inline-flex items-center gap-2 transition-transform duration-200" href="{{ url('/profile') }}">
                    Profil
                  </a>
                </li>

                @if($activeColocation && $isOwnerActive)
                  <li>
                    <a class="hover:text-orange-600 hover:translate-x-1 inline-flex items-center gap-2 transition-transform duration-200" href="{{ route('invitations.create', $activeColocation) }}">
                      Inviter
                    </a>
                  </li>
                @endif
              @endauth
            </ul>
          </div>

          {{-- Admin --}}
          <div>
            <h4 class="font-semibold text-black-600 text-sm tracking-widest uppercase mb-5">Administration</h4>
            <ul class="space-y-3 text-sm text-gray-500 font-medium">
              @auth
                @if(auth()->user()->isAdmin())
                  <li>
                    <a class="hover:text-orange-600 hover:translate-x-1 inline-flex items-center gap-2 transition-transform duration-200" href="{{ url('/admin') }}">
                      <svg class="w-4 h-4 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                      Dashboard Global
                    </a>
                  </li>
                @endif
              @endauth
              
              <li>
                <a class="hover:text-orange-600 hover:translate-x-1 inline-flex items-center gap-2 transition-transform duration-200" href="{{ url('/') }}">
                  Page d'accueil
                </a>
              </li>
              <li>
                <a class="hover:text-orange-600 hover:translate-x-1 inline-flex items-center gap-2 transition-transform duration-200" href="mailto:contact@easycoloc.com">
                  Nous Contacter
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    {{-- Bottom Bar --}}
    <div class="py-8 border-t border-gray-200/60 flex items-center justify-between">
      <div class="text-sm text-gray-400 font-medium">
        © {{ date('Y') }} EasyColoc. Conçu avec soin pour la colocation.
      </div>
    </div>

  </div>
</footer>
