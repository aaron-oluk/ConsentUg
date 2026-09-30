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

        <div>
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

            <div class="mt-1.5">
                <x-text-input
                    id="password"
                    class="block w-full rounded-lg border-brand-navy/15 bg-white py-2.5 pl-3.5 pr-11 text-brand-navy shadow-none transition focus:border-brand-navy focus:ring-brand-navy/20"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="Enter your password"
                />
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
