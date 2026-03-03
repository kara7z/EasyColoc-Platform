@php
  $activeColocation = null;

  if(auth()->check()){
    $activeColocation = \App\Models\Colocation::query()
      ->where('status', 'active')
      ->whereHas('memberships', function ($q) {
        $q->where('user_id', auth()->id())->whereNull('left_at');
      })
      ->latest()
      ->first();
  }
@endphp

<footer class="border-t border-gray-100 bg-white">
  <div class="max-w-screen-xl px-6 sm:px-8 lg:px-16 mx-auto py-12">

    <div class="grid gap-10 lg:grid-cols-12">
      {{-- Brand + description --}}
      <div class="lg:col-span-5">
        <div class="flex items-center gap-3">
          <img src="{{ asset('favicon/favicon-96x96.png') }}" alt="EasyColoc" class="h-8 w-auto" />
          <div>
            <div class="text-black-600 font-semibold">EasyColoc</div>
            <div class="text-sm text-black-500">Plateforme Web de Gestion de Colocation</div>
          </div>
        </div>

        <p class="mt-4 text-black-500 leading-relaxed max-w-md">
          Suivez les dépenses partagées, calculez automatiquement les soldes, et obtenez une vue claire de
          <span class="font-medium text-black-600">« qui doit quoi à qui »</span>.
        </p>

        <div class="mt-5 flex flex-wrap items-center gap-3">
          <a href="{{ url('/ui') }}"
             class="text-sm px-4 py-2 rounded-full border border-gray-200 hover:border-orange-500 hover:text-orange-500 transition">
            UI Preview
          </a>
          <a href="#features"
             class="text-sm px-4 py-2 rounded-full border border-gray-200 hover:border-orange-500 hover:text-orange-500 transition">
            Fonctionnalités
          </a>
        </div>
      </div>

      {{-- Links --}}
      <div class="lg:col-span-7">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
          {{-- Produit --}}
          <div>
            <div class="font-semibold text-black-600">Produit</div>
            <ul class="mt-4 space-y-2 text-sm text-black-500">
              <li>
                <a class="block rounded-lg px-2 py-2 hover:bg-gray-50 hover:text-orange-500 transition"
                   href="{{ url('/colocations') }}">
                  Colocations
                </a>
              </li>
              <li>
                <a class="block rounded-lg px-2 py-2 hover:bg-gray-50 hover:text-orange-500 transition"
                   href="{{ url('/settlements') }}">
                  Qui doit à qui
                </a>
              </li>
              <li>
                <a class="block rounded-lg px-2 py-2 hover:bg-gray-50 hover:text-orange-500 transition"
                   href="{{ url('/categories') }}">
                  Catégories
                </a>
              </li>
              <li>
                <a class="block rounded-lg px-2 py-2 hover:bg-gray-50 hover:text-orange-500 transition"
                   href="{{ url('/dashboard') }}">
                  Dashboard
                </a>
              </li>
            </ul>
          </div>

          {{-- Compte --}}
          <div>
            <div class="font-semibold text-black-600">Compte</div>
            <ul class="mt-4 space-y-2 text-sm text-black-500">
              @guest
                <li>
                  <a class="block rounded-lg px-2 py-2 hover:bg-gray-50 hover:text-orange-500 transition"
                     href="{{ url('/login') }}">
                    Connexion
                  </a>
                </li>
                <li>
                  <a class="block rounded-lg px-2 py-2 hover:bg-gray-50 hover:text-orange-500 transition"
                     href="{{ url('/register') }}">
                    Inscription
                  </a>
                </li>
              @endguest

              @auth
                <li>
                  <a class="block rounded-lg px-2 py-2 hover:bg-gray-50 hover:text-orange-500 transition"
                     href="{{ url('/profile') }}">
                    Profil
                  </a>
                </li>

                @if($activeColocation)
                  <li>
                    <a class="block rounded-lg px-2 py-2 hover:bg-gray-50 hover:text-orange-500 transition"
                       href="{{ route('invitations.create', $activeColocation) }}">
                      Inviter
                    </a>
                  </li>
                @endif
              @endauth
            </ul>
          </div>

          {{-- Admin --}}
          <div>
            <div class="font-semibold text-black-600">Admin</div>
            <ul class="mt-4 space-y-2 text-sm text-black-500">
              @auth
                @if(auth()->user()->isAdmin())
                  <li>
                    <a class="block rounded-lg px-2 py-2 hover:bg-gray-50 hover:text-orange-500 transition"
                       href="{{ url('/admin') }}">
                      Dashboard admin
                    </a>
                  </li>
                @endif
              @endauth

              <li>
                <a class="block rounded-lg px-2 py-2 hover:bg-gray-50 hover:text-orange-500 transition"
                   href="{{ url('/ui') }}">
                  Prévisualisation UI
                </a>
              </li>
              <li>
                <a class="block rounded-lg px-2 py-2 hover:bg-gray-50 hover:text-orange-500 transition"
                   href="{{ url('/') }}">
                  Landing
                </a>
              </li>
            </ul>
          </div>

        </div>
      </div>
    </div>

    {{-- Bottom --}}
    <div class="mt-9 pt-6 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-sm text-black-500">
      <div>© {{ date('Y') }} EasyColoc — Laravel MVC</div>

      <div class="flex flex-wrap items-center gap-2">
        <span class="px-2 py-1 rounded-full bg-gray-100">UI only</span>
        <span class="px-2 py-1 rounded-full bg-gray-100">Tailwind CDN</span>
      </div>
    </div>

  </div>
</footer>
