<section class="rounded-3xl bg-white shadow-card border border-red-100 overflow-hidden">
    <header class="p-6 sm:p-7 border-b border-red-100 bg-gradient-to-r from-white to-red-50/60">
        <div class="flex items-start gap-3">
            <div class="h-10 w-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center border border-red-200">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-3h4m-7 3h10"/>
                </svg>
            </div>
            <div>
                <h2 class="text-lg font-extrabold text-red-700">Zone sensible</h2>
                <p class="text-sm text-slate-600 mt-1">
                    La suppression est définitive. Toutes vos données seront perdues.
                </p>
            </div>
        </div>
    </header>

    <div class="p-6 sm:p-7">
        <button type="button" data-delete-open
                class="rounded-xl bg-red-600 px-4 py-2.5 text-sm font-bold text-white hover:bg-red-700 shadow-sm">
            Supprimer mon compte
        </button>

        <div id="deleteModal" class="hidden fixed inset-0 z-50">
            <div class="absolute inset-0 bg-black/45 backdrop-blur-[2px]" data-delete-close></div>

            <div class="relative mx-auto mt-20 w-[92%] max-w-lg rounded-2xl bg-white shadow-xl border border-gray-100">
                <div class="p-6 sm:p-7">
                    <h3 class="text-lg font-extrabold text-slate-800">Confirmer la suppression</h3>
                    <p class="text-sm text-slate-600 mt-2">
                        Entrez votre mot de passe pour confirmer la suppression définitive du compte.
                    </p>

                    <form method="post" action="{{ route('profile.destroy') }}" class="mt-5 space-y-4">
                        @csrf
                        @method('delete')

                        <div>
                            <label class="block text-sm font-bold text-slate-700" for="password_delete">Mot de passe</label>
                            <div class="relative mt-2">
                                <input id="password_delete" name="password" type="password"
                                       class="w-full rounded-xl border-2 border-slate-300 bg-slate-50 pr-24 focus:border-red-500 focus:outline-none focus:ring-0"
                                       autocomplete="current-password">
                                <button type="button" data-toggle-password="password_delete" class="absolute right-2 top-1/2 -translate-y-1/2 rounded-lg border border-slate-200 bg-white px-3 py-1 text-xs font-bold text-slate-600 hover:border-red-300 hover:text-red-600">
                                    Afficher
                                </button>
                            </div>
                            @error('password', 'userDeletion')
                                <p data-user-deletion-error class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-2">
                            <button type="button" data-delete-close
                                    class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-bold text-slate-600 hover:bg-slate-50">
                                Annuler
                            </button>

                            <button class="rounded-xl bg-red-600 px-4 py-2 text-sm font-bold text-white hover:bg-red-700">
                                Supprimer définitivement
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
