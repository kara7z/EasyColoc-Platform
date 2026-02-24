<section class="rounded-2xl bg-white shadow-sm border border-gray-100">
    <header class="p-6 border-b border-gray-100">
        <h2 class="text-lg font-semibold text-red-700">Delete Account</h2>
        <p class="text-sm text-gray-600 mt-1">
            Once your account is deleted, all of its resources and data will be permanently deleted.
        </p>
    </header>

    <div class="p-6">
        <button type="button"
                onclick="document.getElementById('deleteModal').classList.remove('hidden')"
                class="rounded-xl bg-red-600 px-4 py-2 text-white hover:bg-red-700">
            Delete account
        </button>

        {{-- Simple modal (no JS framework) --}}
        <div id="deleteModal" class="hidden fixed inset-0 z-50">
            <div class="absolute inset-0 bg-black/40"
                 onclick="document.getElementById('deleteModal').classList.add('hidden')"></div>

            <div class="relative mx-auto mt-24 w-[92%] max-w-lg rounded-2xl bg-white shadow-lg border border-gray-100">
                <div class="p-6">
                    <h3 class="text-lg font-semibold">Are you sure?</h3>
                    <p class="text-sm text-gray-600 mt-2">
                        Please enter your password to confirm you want to permanently delete your account.
                    </p>

                    <form method="post" action="{{ route('profile.destroy') }}" class="mt-5 space-y-4">
                        @csrf
                        @method('delete')

                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="password_delete">Password</label>
                            <input id="password_delete" name="password" type="password"
                                   class="mt-2 w-full rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500"
                                   autocomplete="current-password">
                            @error('password', 'userDeletion')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-2">
                            <button type="button"
                                    onclick="document.getElementById('deleteModal').classList.add('hidden')"
                                    class="rounded-xl border border-gray-200 px-4 py-2 hover:bg-gray-50">
                                Cancel
                            </button>

                            <button class="rounded-xl bg-red-600 px-4 py-2 text-white hover:bg-red-700">
                                Delete account
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
