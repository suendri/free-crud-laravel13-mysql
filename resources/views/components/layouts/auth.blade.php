<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Suendri">

        <title>{{ $title ?? 'Free CRUD Laravel' }}</title>
        <link rel="icon" href="{{ asset('favicon.ico') }}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#edf1f7] font-sans text-slate-800 antialiased">
        <main class="flex min-h-screen items-center justify-center px-4 py-8 sm:px-6 lg:px-8">
            <div class="grid w-full max-w-5xl overflow-hidden rounded-lg border border-[#dfe5ef] bg-white shadow-[0_24px_70px_rgba(20,32,54,0.12)] lg:grid-cols-2">
                <section class="flex min-h-[360px] flex-col justify-between bg-[#1f334d] p-6 text-white sm:p-10 lg:min-h-[520px]">
                    <div>
                        <div class="mb-4 inline-flex rounded-md bg-white px-3 py-1 text-sm font-medium text-slate-800">
                            Laravel 13
                        </div>
                        <h1 class="text-3xl font-semibold tracking-normal sm:text-4xl">
                            Free CRUD Laravel
                        </h1>
                        <p class="mt-4 max-w-md text-base leading-7 text-white/80 sm:text-lg">
                            Aplikasi latihan CRUD dengan Laravel, Fortify, Livewire, Tailwind CSS, dan database MySQL.
                        </p>
                    </div>

                    <div class="mt-10 text-sm text-white/70">
                        Fortify Auth · Livewire 4 · Tailwind CSS 4
                    </div>
                </section>

                <section class="p-6 sm:p-10">
                    @if (session('status'))
                        <div class="mb-5 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ $slot }}
                </section>
            </div>
        </main>
    </body>
</html>
