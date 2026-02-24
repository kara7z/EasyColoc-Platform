<section class="rounded-2xl bg-white shadow-sm border border-gray-100">
    <header class="p-6 border-b border-gray-100">
        <h2 class="text-lg font-semibold">Update Password</h2>
        <p class="text-sm text-gray-600 mt-1">Make sure your account uses a strong password.</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="p-6 space-y-5">
        @csrf
        @method('put')

        <div>
            <label class="block text-sm font-medium text-gray-700" for="current_password">Current password</label>
            <input id="current_password" name="current_password" type="password"
                   class="mt-2 w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500"
                   autocomplete="current-password">
            @error('current_password', 'updatePassword')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700" for="password">New password</label>
            <input id="password" name="password" type="password"
                   class="mt-2 w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500"
                   autocomplete="new-password">
            @error('password', 'updatePassword')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700" for="password_confirmation">Confirm new password</label>
            <input id="password_confirmation" name="password_confirmation" type="password"
                   class="mt-2 w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500"
                   autocomplete="new-password">
            @error('password_confirmation', 'updatePassword')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-3">
            <button class="inline-flex items-center rounded-xl bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">
                Save
            </button>

            @if (session('status') === 'password-updated')
                <p class="text-sm text-gray-600">Saved.</p>
            @endif
        </div>
    </form>
</section>
