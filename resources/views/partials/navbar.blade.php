<header class="fixed top-0 w-full z-30 bg-white-500 shadow-md">
  <nav class="max-w-screen-xl px-6 sm:px-8 lg:px-16 mx-auto grid grid-flow-col py-3 sm:py-4 items-center">
    <div class="col-start-1 col-end-3 flex items-center gap-3">
      <a href="{{ url('/') }}" class="flex items-center gap-3">
        <img src="{{ asset('favicon/favicon-96x96.png') }}" alt="EasyColoc" class="h-8 w-auto" />
        <span class="text-black-600 font-semibold tracking-wide hidden sm:inline">EasyColoc</span>
      </a>
    </div>

    <ul class="hidden lg:flex col-start-4 col-end-9 text-black-500 items-center justify-center">
      @auth
        <li><a href="{{ url('/dashboard') }}" class="px-4 py-2 mx-2 cursor-pointer animation-hover inline-block relative hover:text-orange-500">Dashboard</a></li>
        <li><a href="{{ url('/colocations') }}" class="px-4 py-2 mx-2 cursor-pointer animation-hover inline-block relative hover:text-orange-500">Colocations</a></li>
        <li><a href="{{ url('/settlements') }}" class="px-4 py-2 mx-2 cursor-pointer animation-hover inline-block relative hover:text-orange-500">Qui doit à qui</a></li>
        <li><a href="{{ url('/categories') }}" class="px-4 py-2 mx-2 cursor-pointer animation-hover inline-block relative hover:text-orange-500">Catégories</a></li>
        <li>

          <a href="{{ url('/admin') }}" class="px-4 py-2 mx-2 cursor-pointer animation-hover inline-block relative hover:text-orange-500">Admin</a>
        </li>
      @else
        <li><a href="#features" class="px-4 py-2 mx-2 cursor-pointer animation-hover inline-block relative hover:text-orange-500">Fonctionnalités</a></li>
        <li><a href="#how" class="px-4 py-2 mx-2 cursor-pointer animation-hover inline-block relative hover:text-orange-500">Comment ça marche</a></li>
        <li><a href="#pricing" class="px-4 py-2 mx-2 cursor-pointer animation-hover inline-block relative hover:text-orange-500">Simple & gratuit</a></li>
      @endauth
    </ul>

    <div class="col-start-10 col-end-13 font-medium flex justify-end items-center gap-2">
      @auth
        <a href="{{ url('/profile') }}" class="text-black-600 mx-2 sm:mx-4 capitalize tracking-wide hover:text-orange-500 transition-all">Profil</a>
        <form method="POST" action="{{ url('/logout') }}">
          @csrf
          @method('DELETE')
          <x-button-outline type="submit">Logout</x-button-outline>
        </form>
      @else
        <a href="{{ url('/login') }}" class="text-black-600 mx-2 sm:mx-4 capitalize tracking-wide hover:text-orange-500 transition-all">Sign in</a>
        <a href="{{ url('/register') }}" class="inline-flex">
          <x-button-outline>Sign up</x-button-outline>
        </a>
      @endauth
    </div>
  </nav>
</header>
