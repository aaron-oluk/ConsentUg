<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Consent Uganda') }}</title>

        <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="{{ asset('js/password-toggle.js') }}" defer></script>
    </head>
    <body class="font-sans text-brand-navy antialiased">
        <div class="relative min-h-screen overflow-hidden bg-brand-mist">
            <div class="pointer-events-none absolute inset-0">
                <div class="absolute -left-24 -top-24 h-80 w-80 rounded-full bg-brand-navy/10 blur-3xl"></div>
                <div class="absolute -bottom-32 -right-20 h-96 w-96 rounded-full bg-brand-gold/20 blur-3xl"></div>
                <div class="absolute left-1/2 top-1/3 h-64 w-64 -translate-x-1/2 rounded-full bg-brand-navy/5 blur-2xl"></div>
            </div>

            <div class="relative z-10 flex min-h-screen flex-col items-center justify-center px-4 py-10 sm:px-6">
                <a href="/" class="mb-8 transition duration-300 hover:opacity-80">
                    <x-application-logo class="h-16 w-auto" />
                </a>

                <div class="w-full max-w-md border border-white/60 bg-white/80 px-6 py-8 shadow-[0_20px_60px_-20px_rgba(38,59,92,0.25)] backdrop-blur-md sm:px-8 sm:py-10">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
