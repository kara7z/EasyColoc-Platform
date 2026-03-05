<section class="rounded-3xl bg-white shadow-card border border-slate-100 overflow-hidden">
    <header class="p-6 sm:p-7 border-b border-slate-100 bg-gradient-to-r from-white to-slate-50/70">
        <div class="flex items-start gap-3">
            <div class="h-10 w-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-100">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c1.657 0 3-1.567 3-3.5S13.657 4 12 4 9 5.567 9 7.5 10.343 11 12 11z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 20a7 7 0 0114 0"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11h2a2 2 0 012 2v5"/>
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-extrabold text-slate-800">Sécurité du compte</h2>
                <p class="text-sm text-slate-500 mt-1">Utilisez un mot de passe fort et unique.</p>
            </div>
        </div>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="p-6 sm:p-7 space-y-5">
        @csrf
        @method('put')

        <div>
            <label class="block text-sm font-bold text-slate-700" for="current_password">Mot de passe actuel</label>
            <div class="relative mt-2">
                <input id="current_password" name="current_password" type="password"
                    class="w-full rounded-xl border-2 border-slate-300 bg-slate-50 pr-24 focus:border-orange-500 focus:outline-none focus:ring-0"
                    autocomplete="current-password">
                <button type="button" data-toggle-password="current_password" class="absolute right-2 top-1/2 -translate-y-1/2 rounded-lg border border-slate-200 bg-white px-3 py-1 text-xs font-bold text-slate-600 hover:border-orange-300 hover:text-orange-600">
                    Afficher
                </button>
            </div>
            @error('current_password', 'updatePassword')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-bold text-slate-700" for="password">Nouveau mot de passe</label>
            <div class="relative mt-2">
                <input id="password" name="password" type="password"
                    class="w-full rounded-xl border-2 border-slate-300 bg-slate-50 pr-24 focus:border-orange-500 focus:outline-none focus:ring-0"
                    autocomplete="new-password">
                <button type="button" data-toggle-password="password" class="absolute right-2 top-1/2 -translate-y-1/2 rounded-lg border border-slate-200 bg-white px-3 py-1 text-xs font-bold text-slate-600 hover:border-orange-300 hover:text-orange-600">
                    Afficher
                </button>
            </div>
            @error('password', 'updatePassword')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-bold text-slate-700" for="password_confirmation">Confirmer le nouveau mot de passe</label>
            <div class="relative mt-2">
                <input id="password_confirmation" name="password_confirmation" type="password"
                    class="w-full rounded-xl border-2 border-slate-300 bg-slate-50 pr-24 focus:border-orange-500 focus:outline-none focus:ring-0"
                    autocomplete="new-password">
                <button type="button" data-toggle-password="password_confirmation" class="absolute right-2 top-1/2 -translate-y-1/2 rounded-lg border border-slate-200 bg-white px-3 py-1 text-xs font-bold text-slate-600 hover:border-orange-300 hover:text-orange-600">
                    Afficher
                </button>
            </div>
            @error('password_confirmation', 'updatePassword')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">
            Conseil: utilisez au moins 8 caractères, avec lettres et chiffres.
        </div>

        <div class="flex items-center gap-3">
            <button class="inline-flex items-center rounded-xl bg-gradient-to-r from-orange-500 to-red-500 px-5 py-2.5 text-sm font-bold text-white hover:from-red-500 hover:to-orange-500 shadow-orange">
                Enregistrer
            </button>

            @if (session('status') === 'password-updated')
                <p class="text-sm text-green-700 font-semibold">Mot de passe mis à jour.</p>
            @endif
        </div>
    </form>
</section>
