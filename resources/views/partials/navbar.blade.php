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

<header class="fixed top-0 w-full z-30 bg-white/80 backdrop-blur-md shadow-[0_4px_20px_-10px_rgba(0,0,0,0.1)] border-b border-slate-200/50 transition-all duration-300">
  <nav class="max-w-screen-xl px-6 sm:px-8 lg:px-16 mx-auto flex items-center justify-between py-3.5 sm:py-4">

    {{-- Brand --}}
    <div class="flex items-center gap-3">
      @guest
        <a href="{{ url('/') }}" class="flex items-center gap-2.5 group">
          <img src="{{ asset('favicon/favicon-96x96.png') }}" alt="EasyColoc" class="h-8 sm:h-9 w-auto group-hover:scale-105 transition-transform duration-300 drop-shadow-sm" />
          <span class="text-slate-800 font-extrabold text-xl tracking-tight hidden sm:inline group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-orange-500 group-hover:to-red-500 transition-all">EasyColoc</span>
        </a>
      @endguest

      @auth
        <a href="{{ url('/dashboard') }}" class="flex items-center gap-2.5 group">
          <img src="{{ asset('favicon/favicon-96x96.png') }}" alt="EasyColoc" class="h-8 sm:h-9 w-auto group-hover:scale-105 transition-transform duration-300 drop-shadow-sm" />
          <span class="text-slate-800 font-extrabold text-xl tracking-tight hidden sm:inline group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-orange-500 group-hover:to-red-500 transition-all">EasyColoc</span>
        </a>
      @endauth
    </div>

    {{-- Desktop menu --}}
    <ul class="hidden lg:flex text-slate-600 items-center justify-center gap-1 font-bold text-base">
      @auth
        <li>
          <a href="{{ url('/dashboard') }}" class="px-4 py-2.5 cursor-pointer animation-hover inline-block relative hover:text-orange-600 rounded-xl hover:bg-orange-50 transition-colors">
            Dashboard
          </a>
        </li>

        @if($activeColocation)
          <li>
            <a href="{{ route('colocations.show', $activeColocation) }}" class="px-4 py-2.5 cursor-pointer animation-hover inline-block relative hover:text-orange-600 rounded-xl hover:bg-orange-50 transition-colors">
              Ma colocation
            </a>
          </li>
        @endif

        <li>
          <a href="{{ url('/colocations') }}" class="px-4 py-2.5 cursor-pointer animation-hover inline-block relative hover:text-orange-600 rounded-xl hover:bg-orange-50 transition-colors">
            Colocations
          </a>
        </li>
        <li>
          <a href="{{ url('/settlements') }}" class="px-4 py-2.5 cursor-pointer animation-hover inline-block relative hover:text-orange-600 rounded-xl hover:bg-orange-50 transition-colors">
            Qui doit à qui
          </a>
        </li>
        <li>
          <a href="{{ url('/categories') }}" class="px-4 py-2.5 cursor-pointer animation-hover inline-block relative hover:text-orange-600 rounded-xl hover:bg-orange-50 transition-colors">
            Catégories
          </a>
        </li>

        @if(auth()->user()->isAdmin())
          <li>
            <a href="{{ url('/admin') }}" class="px-4 py-2.5 cursor-pointer animation-hover inline-block relative hover:text-orange-600 rounded-xl hover:bg-orange-50 transition-colors flex items-center gap-1">
              <svg class="w-4 h-4 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
              Admin
            </a>
          </li>
        @endif
      @endauth

      @guest
        <li><a href="#features" class="px-4 py-2.5 cursor-pointer animation-hover inline-block relative hover:text-orange-600 rounded-xl hover:bg-orange-50 transition-colors">Fonctionnalités</a></li>
        <li><a href="#how" class="px-4 py-2.5 cursor-pointer animation-hover inline-block relative hover:text-orange-600 rounded-xl hover:bg-orange-50 transition-colors">Comment ça marche</a></li>
        <li><a href="#pricing" class="px-4 py-2.5 cursor-pointer animation-hover inline-block relative hover:text-orange-600 rounded-xl hover:bg-orange-50 transition-colors">Simple &amp; gratuit</a></li>
      @endguest
    </ul>

    <div class="font-bold flex items-center gap-2">
      <div class="hidden lg:flex items-center gap-2">
        @auth
          <a href="{{ url('/profile') }}" class="text-slate-600 mx-2 sm:mx-3 capitalize hover:text-orange-600 transition-colors text-base">
            Profil
          </a>
          <form method="POST" action="{{ url('/logout') }}">
            @csrf
            @method('DELETE')
            <x-button-outline type="submit" class="!py-2 !px-5 text-base">Déconnexion</x-button-outline>
          </form>
        @else
          <a href="{{ url('/login') }}" class="text-slate-600 mx-2 sm:mx-3 hover:text-orange-600 transition-colors text-base">
            Connexion
          </a>
          <a href="{{ url('/register') }}" class="inline-flex">
            <x-button-primary class="!py-2.5 !px-6 text-base">Inscription</x-button-primary>
          </a>
        @endauth
      </div>

      {{-- Mobile hamburger --}}
      <button
        type="button"
        class="lg:hidden inline-flex items-center justify-center rounded-xl border border-gray-200 p-2 text-black-600 hover:border-orange-500 hover:text-orange-500 transition-all hover:bg-orange-50 focus:ring-2 focus:ring-orange-500/20 active:scale-95"
        aria-controls="mobile-menu"
        aria-expanded="false"
        id="mobile-menu-btn"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
    </div>
  </nav>

  {{-- Mobile dropdown menu --}}
  <div id="mobile-menu" class="lg:hidden hidden border-t border-gray-100 bg-white/95 backdrop-blur-md absolute w-full shadow-lg origin-top transition-all duration-300 transform scale-y-0 opacity-0" style="transform-origin: top;">
    <div class="max-w-screen-xl mx-auto px-6 sm:px-8 lg:px-16 py-4 space-y-1 font-medium">

      @auth
        <a href="{{ url('/dashboard') }}" class="block px-3 py-2.5 rounded-xl text-black-500 hover:bg-orange-50 hover:text-orange-600 transition-all active:scale-95">
          Dashboard
        </a>

        @if($activeColocation)
          <a href="{{ route('colocations.show', $activeColocation) }}" class="block px-3 py-2.5 rounded-xl text-black-500 hover:bg-orange-50 hover:text-orange-600 transition-all active:scale-95">
            Ma colocation
          </a>
        @endif

        <a href="{{ url('/colocations') }}" class="block px-3 py-2.5 rounded-xl text-black-500 hover:bg-orange-50 hover:text-orange-600 transition-all active:scale-95">
          Colocations
        </a>
        <a href="{{ url('/settlements') }}" class="block px-3 py-2.5 rounded-xl text-black-500 hover:bg-orange-50 hover:text-orange-600 transition-all active:scale-95">
          Qui doit à qui
        </a>
        <a href="{{ url('/categories') }}" class="block px-3 py-2.5 rounded-xl text-black-500 hover:bg-orange-50 hover:text-orange-600 transition-all active:scale-95">
          Catégories
        </a>

        @if(auth()->user()->isAdmin())
          <a href="{{ url('/admin') }}" class="block px-3 py-2.5 rounded-xl text-black-500 hover:bg-orange-50 hover:text-orange-600 transition-all active:scale-95">
            Admin
          </a>
        @endif

        <div class="pt-2 pb-2"><div class="border-t border-gray-100"></div></div>

        <a href="{{ url('/profile') }}" class="block px-3 py-2.5 rounded-xl text-black-500 hover:bg-orange-50 hover:text-orange-600 transition-all active:scale-95">
          Profil
        </a>

        <form method="POST" action="{{ url('/logout') }}">
          @csrf
          @method('DELETE')
          <button type="submit" class="w-full text-left px-3 py-2.5 rounded-xl text-red-500 hover:bg-red-50 hover:text-red-600 transition-all active:scale-95 font-medium">
            Logout
          </button>
        </form>
      @endauth

      @guest
        <a href="#features" class="block px-3 py-2.5 rounded-xl text-slate-600 font-bold hover:bg-orange-50 hover:text-orange-600 transition-all active:scale-95">Fonctionnalités</a>
        <a href="#how" class="block px-3 py-2.5 rounded-xl text-slate-600 font-bold hover:bg-orange-50 hover:text-orange-600 transition-all active:scale-95">Comment ça marche</a>
        <a href="#pricing" class="block px-3 py-2.5 rounded-xl text-slate-600 font-bold hover:bg-orange-50 hover:text-orange-600 transition-all active:scale-95">Simple &amp; gratuit</a>

        <div class="pt-2 pb-2"><div class="border-t border-gray-100"></div></div>

        <a href="{{ url('/login') }}" class="block px-3 py-2.5 rounded-xl text-slate-600 font-bold hover:bg-orange-50 hover:text-orange-600 transition-all active:scale-95">
          Connexion
        </a>
        <a href="{{ url('/register') }}" class="block px-3 py-2.5 rounded-xl bg-gradient-to-r from-orange-500 to-red-500 text-white shadow-orange-md font-bold hover:to-orange-500 hover:from-red-500 transition-all active:scale-95 mt-2 text-center">
          Inscription
        </a>
      @endguest

    </div>
  </div>
</header>

<script>
  (function () {
    // Mobile menu toggle with smooth animation
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    if (btn && menu) {
      btn.addEventListener('click', () => {
        const isHidden = menu.classList.contains('hidden');
        
        if (isHidden) {
          menu.classList.remove('hidden');
          // Trigger reflow
          void menu.offsetWidth;
          menu.classList.remove('scale-y-0', 'opacity-0');
          menu.classList.add('scale-y-100', 'opacity-100');
        } else {
          menu.classList.remove('scale-y-100', 'opacity-100');
          menu.classList.add('scale-y-0', 'opacity-0');
          setTimeout(() => {
            menu.classList.add('hidden');
          }, 300); // match transition duration
        }
        
        btn.setAttribute('aria-expanded', String(isHidden));
      });
    }
  })();
</script>
