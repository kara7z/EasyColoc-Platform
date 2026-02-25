<footer class="border-t border-gray-100 bg-white">
  <div class="max-w-screen-xl px-6 sm:px-8 lg:px-16 mx-auto py-12">
    <div class="grid gap-10 lg:grid-cols-12">
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

        <div class="mt-5 flex items-center gap-3">
          <a href="{{ url('/ui') }}" class="text-sm px-4 py-2 rounded-full border border-gray-200 hover:border-orange-500 hover:text-orange-500 transition">UI Preview</a>
          <a href="#features" class="text-sm px-4 py-2 rounded-full border border-gray-200 hover:border-orange-500 hover:text-orange-500 transition">Fonctionnalités</a>
        </div>
      </div>

      <div class="lg:col-span-7 grid grid-cols-2 sm:grid-cols-3 gap-8">
        <div>
          <div class="font-semibold text-black-600">Produit</div>
          <ul class="mt-4 space-y-3 text-sm text-black-500">
            <li><a class="hover:text-orange-500" href="{{ url('/colocations') }}">Colocations</a></li>
            <li><a class="hover:text-orange-500" href="{{ url('/settlements') }}">Qui doit à qui</a></li>
            <li><a class="hover:text-orange-500" href="{{ url('/categories') }}">Catégories</a></li>
            <li><a class="hover:text-orange-500" href="{{ url('/dashboard') }}">Dashboard</a></li>
          </ul>
        </div>

        <div>
          <div class="font-semibold text-black-600">Compte</div>
          <ul class="mt-4 space-y-3 text-sm text-black-500">
            <li><a class="hover:text-orange-500" href="{{ url('/login') }}">Connexion</a></li>
            <li><a class="hover:text-orange-500" href="{{ url('/register') }}">Inscription</a></li>
            <li><a class="hover:text-orange-500" href="{{ url('/invitations/create') }}">Inviter</a></li>
            <li><a class="hover:text-orange-500" href="{{ url('/profile') }}">Profil</a></li>
          </ul>
        </div>

        <div>
          <div class="font-semibold text-black-600">Admin</div>
          <ul class="mt-4 space-y-3 text-sm text-black-500">
            <li><a class="hover:text-orange-500" href="{{ url('/admin') }}">Dashboard admin</a></li>
            <li><a class="hover:text-orange-500" href="{{ url('/ui') }}">Prévisualisation UI</a></li>
            <li><a class="hover:text-orange-500" href="{{ url('/') }}">Landing</a></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="mt-10 pt-6 border-t border-gray-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 text-sm text-black-500">
      <div>© {{ date('Y') }} EasyColoc — Laravel MVC</div>
      <div class="flex items-center gap-3">
        <span class="px-3 py-1 rounded-full bg-gray-100">UI only</span>
        <span class="px-3 py-1 rounded-full bg-gray-100">Tailwind CDN</span>
      </div>
    </div>
  </div>
</footer>
