<x-guest-layout>
    <div class="mb-8 text-center">
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-brand-gold-dark">Consent Uganda</p>
        <h1 class="mt-2 text-2xl font-semibold tracking-tight text-brand-navy sm:text-3xl">Welcome back</h1>
        <p class="mt-2 text-sm text-brand-navy/60">Sign in to continue to your account</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-brand-navy/80" />
            <x-text-input
                id="email"
                class="mt-1.5 block w-full rounded-lg border-brand-navy/15 bg-white px-3.5 py-2.5 text-brand-navy shadow-none transition focus:border-brand-navy focus:ring-brand-navy/20"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                autocomplete="username"
                placeholder="you@example.com"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div x-data="{ show: false }">
            <div class="flex items-center justify-between">
                <x-input-label for="password" :value="__('Password')" class="text-brand-navy/80" />
                @if (Route::has('password.request'))
                    <a
                        href="{{ route('password.request') }}"
                        class="text-xs font-medium text-brand-navy/55 transition hover:text-brand-gold-dark"
                    >
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <div class="relative mt-1.5">
                <x-text-input
                    id="password"
                    class="block w-full rounded-lg border-brand-navy/15 bg-white py-2.5 pl-3.5 pr-11 text-brand-navy shadow-none transition focus:border-brand-navy focus:ring-brand-navy/20"
                    type="password"
                    x-bind:type="show ? 'text' : 'password'"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="Enter your password"
                />

                <button
                    type="button"
                    @click="show = !show"
                    class="absolute inset-y-0 right-0 flex items-center px-3 text-brand-navy/45 transition hover:text-brand-navy focus:outline-none"
                    :aria-label="show ? 'Hide password' : 'Show password'"
                >
                    <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <svg x-cloak x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center">
            <label for="remember_me" class="inline-flex cursor-pointer items-center gap-2">
                <input
                    id="remember_me"
                    type="checkbox"
                    class="rounded border-brand-navy/25 text-brand-navy shadow-none focus:ring-brand-navy/30"
                    name="remember"
                >
                <span class="text-sm text-brand-navy/70">{{ __('Remember me') }}</span>
            </label>
        </div>

        <button
            type="submit"
            class="group relative mt-2 flex w-full items-center justify-center overflow-hidden bg-brand-navy px-4 py-3 text-sm font-semibold tracking-wide text-white transition duration-300 hover:bg-brand-navy-dark focus:outline-none focus:ring-2 focus:ring-brand-gold focus:ring-offset-2"
        >
            <span class="absolute inset-x-0 bottom-0 h-0.5 origin-left scale-x-0 bg-brand-gold transition duration-300 group-hover:scale-x-100"></span>
            {{ __('Log in') }}
        </button>
    </form>
</x-guest-layout>
