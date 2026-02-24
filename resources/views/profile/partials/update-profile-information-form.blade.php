<section class="rounded-2xl bg-white shadow-sm border border-gray-100">
    <header class="p-6 border-b border-gray-100">
        <h2 class="text-lg font-semibold">Profile Information</h2>
        <p class="text-sm text-gray-600 mt-1">Update your name and email address.</p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="p-6 space-y-5">
        @csrf
        @method('patch')

        <div>
            <label class="block text-sm font-medium text-gray-700" for="name">Name</label>
            <input id="name" name="name" type="text"
                   class="mt-2 w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500"
                   value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700" for="email">Email</label>
            <input id="email" name="email" type="email"
                   class="mt-2 w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500"
                   value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 text-sm">
                    <p class="text-gray-600">
                        Your email address is unverified.
                        <button form="send-verification" class="underline text-indigo-600 hover:text-indigo-700">
                            Click here to re-send verification email.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-green-700">A new verification link has been sent.</p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-3">
            <button class="inline-flex items-center rounded-xl bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-700">
                Save
            </button>

            @if (session('status') === 'profile-updated')
                <p class="text-sm text-gray-600">Saved.</p>
            @endif
        </div>
    </form>

    {{-- Email verification form (Breeze-style) --}}
    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
        <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="hidden">
            @csrf
        </form>
    @endif
</section>
