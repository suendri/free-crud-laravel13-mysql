<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Suendri">

        <title>{{ $title ?? 'Free CRUD Laravel | Dashboard' }}</title>
        <link rel="icon" href="{{ asset('favicon.ico') }}">

        @livewireStyles
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#f6f7fb] font-sans text-slate-800 antialiased">
        <div x-data="{ mobileMenuOpen: false }">
            <nav class="fixed inset-x-0 top-0 z-40 border-b border-[#dfe5ef] bg-white">
                <div class="flex h-14 items-center gap-2 px-3 sm:gap-3 sm:px-4">
                    <button
                        type="button"
                        class="inline-flex size-10 items-center justify-center rounded-md border border-slate-300 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 lg:hidden"
                        aria-label="Buka navigasi"
                        x-bind:aria-expanded="mobileMenuOpen.toString()"
                        x-on:click="mobileMenuOpen = true"
                    >
                        <span class="text-lg leading-none">&#9776;</span>
                    </button>

                    <a href="{{ route('dashboard') }}" class="min-w-0 truncate text-base font-semibold text-slate-900">
                        Free CRUD
                    </a>

                    <div class="ml-auto flex min-w-0 items-center gap-2 sm:gap-4">
                        <div class="hidden text-right sm:block">
                            <div class="text-sm font-semibold text-slate-900">{{ auth()->user()->name }}</div>
                            <div class="text-xs capitalize text-slate-500">{{ auth()->user()->role }}</div>
                        </div>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="rounded-md border border-red-200 px-3 py-1.5 text-sm font-medium text-red-600 transition hover:bg-red-50">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </nav>

            <div
                class="fixed inset-0 top-14 z-50 lg:hidden"
                x-cloak
                x-show="mobileMenuOpen"
                x-transition.opacity
            >
                <button
                    type="button"
                    class="absolute inset-0 bg-slate-950/40"
                    aria-label="Tutup navigasi"
                    x-on:click="mobileMenuOpen = false"
                ></button>
                <aside
                    class="relative h-full w-[min(20rem,85vw)] overflow-y-auto border-r border-[#dfe5ef] bg-white shadow-xl"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="-translate-x-full"
                    x-transition:enter-end="translate-x-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="-translate-x-full"
                >
                    <div class="flex items-center justify-between border-b border-[#dfe5ef] px-4 py-3">
                        <h2 class="text-base font-semibold text-slate-900">Navigasi</h2>
                        <button
                            type="button"
                            class="inline-flex size-9 items-center justify-center rounded-md border border-slate-300 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                            aria-label="Tutup navigasi"
                            x-on:click="mobileMenuOpen = false"
                        >
                            &times;
                        </button>
                    </div>

                    @include('partials.sidebar')
                </aside>
            </div>

            <aside class="fixed bottom-0 left-0 top-14 hidden w-[260px] overflow-y-auto border-r border-[#dfe5ef] bg-white lg:block">
                @include('partials.sidebar')
            </aside>

            <main class="min-h-screen pt-14 lg:pl-[260px]">
                <div class="px-4 py-5 sm:px-6 sm:py-6 lg:px-8">
                    {{ $slot }}
                </div>
            </main>
        </div>

        @livewireScriptConfig
    </body>
</html>
