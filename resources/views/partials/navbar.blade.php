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

<header class="fixed top-0 w-full z-30 bg-white-500 shadow-md">
  <nav class="max-w-screen-xl px-6 sm:px-8 lg:px-16 mx-auto flex items-center justify-between py-3 sm:py-4">

    {{-- Brand --}}
    <div class="flex items-center gap-3">
      @guest
        <a href="{{ url('/') }}" class="flex items-center gap-3">
          <img src="{{ asset('favicon/favicon-96x96.png') }}" alt="EasyColoc" class="h-8 w-auto" />
          <span class="text-black-600 font-semibold tracking-wide hidden sm:inline">EasyColoc</span>
        </a>
      @endguest

      @auth
        <a href="{{ url('/dashboard') }}" class="flex items-center gap-3">
          <img src="{{ asset('favicon/favicon-96x96.png') }}" alt="EasyColoc" class="h-8 w-auto" />
          <span class="text-black-600 font-semibold tracking-wide hidden sm:inline">EasyColoc</span>
        </a>
      @endauth
    </div>

    {{-- Desktop menu --}}
    <ul class="hidden lg:flex text-black-500 items-center justify-center">
      @auth
        <li>
          <a href="{{ url('/dashboard') }}" class="px-4 py-2 mx-2 cursor-pointer animation-hover inline-block relative hover:text-orange-500">
            Dashboard
          </a>
        </li>

        @if($activeColocation)
          <li>
            <a href="{{ route('colocations.show', $activeColocation) }}" class="px-4 py-2 mx-2 cursor-pointer animation-hover inline-block relative hover:text-orange-500">
              Ma colocation
            </a>
          </li>
        @endif

        <li>
          <a href="{{ url('/colocations') }}" class="px-4 py-2 mx-2 cursor-pointer animation-hover inline-block relative hover:text-orange-500">
            Colocations
          </a>
        </li>
        <li>
          <a href="{{ url('/settlements') }}" class="px-4 py-2 mx-2 cursor-pointer animation-hover inline-block relative hover:text-orange-500">
            Qui doit à qui
          </a>
        </li>
        <li>
          <a href="{{ url('/categories') }}" class="px-4 py-2 mx-2 cursor-pointer animation-hover inline-block relative hover:text-orange-500">
            Catégories
          </a>
        </li>

        @if(auth()->user()->isAdmin())
          <li>
            <a href="{{ url('/admin') }}" class="px-4 py-2 mx-2 cursor-pointer animation-hover inline-block relative hover:text-orange-500">
              Admin
            </a>
          </li>
        @endif
      @endauth

      @guest
        <li><a href="#features" class="px-4 py-2 mx-2 cursor-pointer animation-hover inline-block relative hover:text-orange-500">Fonctionnalités</a></li>
        <li><a href="#how" class="px-4 py-2 mx-2 cursor-pointer animation-hover inline-block relative hover:text-orange-500">Comment ça marche</a></li>
        <li><a href="#pricing" class="px-4 py-2 mx-2 cursor-pointer animation-hover inline-block relative hover:text-orange-500">Simple & gratuit</a></li>
      @endguest
    </ul>

    <div class="font-medium flex items-center gap-2">
      <div class="hidden lg:flex items-center gap-2">
        @auth
          <a href="{{ url('/profile') }}" class="text-black-600 mx-2 sm:mx-4 capitalize tracking-wide hover:text-orange-500 transition-all">
            Profil
          </a>
          <form method="POST" action="{{ url('/logout') }}">
            @csrf
            @method('DELETE')
            <x-button-outline type="submit">Logout</x-button-outline>
          </form>
        @else
          <a href="{{ url('/login') }}" class="text-black-600 mx-2 sm:mx-4 capitalize tracking-wide hover:text-orange-500 transition-all">
            Sign in
          </a>
          <a href="{{ url('/register') }}" class="inline-flex">
            <x-button-outline>Sign up</x-button-outline>
          </a>
        @endauth
      </div>

      {{-- Mobile hamburger --}}
      <button
        type="button"
        class="lg:hidden inline-flex items-center justify-center rounded-lg border border-gray-200 p-2 text-black-600 hover:border-orange-500"
        aria-controls="mobile-menu"
        aria-expanded="false"
        id="mobile-menu-btn"
      >
        {{-- simple icon --}}
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
    </div>
  </nav>

  {{-- Mobile dropdown menu --}}
  <div id="mobile-menu" class="lg:hidden hidden border-t border-gray-100 bg-white">
    <div class="max-w-screen-xl mx-auto px-6 sm:px-8 lg:px-16 py-4 space-y-2">

      @auth
        <a href="{{ url('/dashboard') }}" class="block px-2 py-2 rounded-lg hover:bg-gray-50 hover:text-orange-500">
          Dashboard
        </a>

        @if($activeColocation)
          <a href="{{ route('colocations.show', $activeColocation) }}" class="block px-2 py-2 rounded-lg hover:bg-gray-50 hover:text-orange-500">
            Ma colocation
          </a>
        @endif

        <a href="{{ url('/colocations') }}" class="block px-2 py-2 rounded-lg hover:bg-gray-50 hover:text-orange-500">
          Colocations
        </a>
        <a href="{{ url('/settlements') }}" class="block px-2 py-2 rounded-lg hover:bg-gray-50 hover:text-orange-500">
          Qui doit à qui
        </a>
        <a href="{{ url('/categories') }}" class="block px-2 py-2 rounded-lg hover:bg-gray-50 hover:text-orange-500">
          Catégories
        </a>

        @if(auth()->user()->isAdmin())
          <a href="{{ url('/admin') }}" class="block px-2 py-2 rounded-lg hover:bg-gray-50 hover:text-orange-500">
            Admin
          </a>
        @endif

        <div class="pt-2 border-t border-gray-100"></div>

        <a href="{{ url('/profile') }}" class="block px-2 py-2 rounded-lg hover:bg-gray-50 hover:text-orange-500">
          Profil
        </a>

        <form method="POST" action="{{ url('/logout') }}">
          @csrf
          @method('DELETE')
          <button type="submit" class="w-full text-left px-2 py-2 rounded-lg hover:bg-gray-50 hover:text-orange-500">
            Logout
          </button>
        </form>
      @endauth

      @guest
        <a href="#features" class="block px-2 py-2 rounded-lg hover:bg-gray-50 hover:text-orange-500">Fonctionnalités</a>
        <a href="#how" class="block px-2 py-2 rounded-lg hover:bg-gray-50 hover:text-orange-500">Comment ça marche</a>
        <a href="#pricing" class="block px-2 py-2 rounded-lg hover:bg-gray-50 hover:text-orange-500">Simple & gratuit</a>

        <div class="pt-2 border-t border-gray-100"></div>

        <a href="{{ url('/login') }}" class="block px-2 py-2 rounded-lg hover:bg-gray-50 hover:text-orange-500">
          Sign in
        </a>
        <a href="{{ url('/register') }}" class="block px-2 py-2 rounded-lg hover:bg-gray-50 hover:text-orange-500">
          Sign up
        </a>
      @endguest

    </div>
  </div>
</header>

<script>
  (function () {
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    if (!btn || !menu) return;

    btn.addEventListener('click', () => {
      const isHidden = menu.classList.contains('hidden');
      menu.classList.toggle('hidden', !isHidden);
      btn.setAttribute('aria-expanded', String(isHidden));
    });
  })();
</script>
