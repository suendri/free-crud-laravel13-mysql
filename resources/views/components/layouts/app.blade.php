<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Suendri">

        <title>{{ $title ?? 'Free CRUD Laravel | Dashboard' }}</title>
        <link rel="icon" href="{{ asset('favicon.ico') }}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#f6f7fb] font-sans text-slate-800 antialiased">
        <div>
            <nav class="fixed inset-x-0 top-0 z-40 border-b border-[#dfe5ef] bg-white">
                <div class="flex h-14 items-center gap-3 px-4">
                    <details class="lg:hidden">
                        <summary class="inline-flex cursor-pointer list-none rounded-md border border-slate-300 px-3 py-1.5 text-sm font-medium text-slate-700">
                            Menu
                        </summary>

                        <div class="fixed inset-0 top-14 z-50">
                            <div class="absolute inset-0 bg-slate-950/40"></div>
                            <aside class="relative h-full w-[260px] border-r border-[#dfe5ef] bg-white">
                                <div class="border-b border-[#dfe5ef] px-4 py-3">
                                    <h2 class="text-base font-semibold text-slate-900">Navigasi</h2>
                                </div>

                                @include('partials.sidebar')
                            </aside>
                        </div>
                    </details>

                    <a href="{{ route('dashboard') }}" class="text-base font-semibold text-slate-900">
                        Free CRUD
                    </a>

                    <div class="ml-auto flex items-center gap-4">
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

            <aside class="fixed bottom-0 left-0 top-14 hidden w-[260px] overflow-y-auto border-r border-[#dfe5ef] bg-white lg:block">
                @include('partials.sidebar')
            </aside>

            <main class="min-h-screen pt-14 lg:pl-[260px]">
                <div class="px-4 py-6 sm:px-6 lg:px-8">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>
