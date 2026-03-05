<section class="rounded-3xl bg-white shadow-card border border-slate-100 overflow-hidden">
    <header class="p-6 sm:p-7 border-b border-slate-100 bg-gradient-to-r from-white to-slate-50/70">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div class="flex items-start gap-3">
                <div class="h-10 w-10 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center border border-orange-100">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A9 9 0 1118.88 17.8M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-slate-800">Informations personnelles</h2>
                    <p class="text-sm text-slate-500 mt-1">Mettez à jour votre nom et votre adresse email.</p>
                </div>
            </div>

            @if (session('status') === 'profile-updated')
                <span class="inline-flex items-center rounded-full bg-green-50 text-green-700 border border-green-200 px-3 py-1 text-xs font-bold">
                    Profil mis à jour
                </span>
            @endif
        </div>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="p-6 sm:p-7 space-y-6">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-bold text-slate-700" for="name">Nom</label>
                <input id="name" name="name" type="text"
                       class="mt-2 w-full rounded-xl border-2 border-slate-300 bg-slate-50 focus:border-orange-500 focus:outline-none focus:ring-0"
                       value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700" for="email">Email</label>
                <input id="email" name="email" type="email"
                       class="mt-2 w-full rounded-xl border-2 border-slate-300 bg-slate-50 focus:border-orange-500 focus:outline-none focus:ring-0"
                       value="{{ old('email', $user->email) }}" required autocomplete="username">
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm">
                <p class="text-amber-800 font-medium">
                    Votre email n'est pas encore vérifié.
                    <button form="send-verification" class="underline font-bold text-amber-700 hover:text-amber-900">
                        Renvoyer le lien de vérification
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 text-green-700 font-semibold">Un nouveau lien de vérification a été envoyé.</p>
                @endif
            </div>
        @endif

        <div class="flex items-center gap-4">
            <button type="submit"
                class="inline-flex items-center rounded-xl bg-gradient-to-r from-orange-500 to-red-500 px-5 py-2.5 text-sm font-bold text-white hover:from-red-500 hover:to-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:ring-offset-2 shadow-orange">
                Enregistrer
            </button>
            @if (session('status') === 'profile-updated')
                <p class="text-sm text-green-700 font-semibold">Enregistré.</p>
            @endif
        </div>
    </form>

    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
        <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="hidden">
            @csrf
        </form>
    @endif
</section>
