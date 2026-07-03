<x-layouts.app title="Free CRUD Laravel | Dashboard">
    @php
        $stats = [
            ['label' => 'Users', 'value' => $totalUsers, 'description' => 'Akun terdaftar'],
            ['label' => 'Categories', 'value' => $totalCategories, 'description' => 'Kategori konten'],
            ['label' => 'Posts', 'value' => $totalPosts, 'description' => 'Artikel tersimpan'],
        ];
    @endphp

    <div class="mb-5 flex flex-col gap-3 sm:mb-6 sm:flex-row sm:items-end sm:justify-between">
        <div class="min-w-0">
            <h1 class="text-xl font-semibold text-slate-900 sm:text-2xl">
                Dashboard
            </h1>
            <p class="mt-1 max-w-2xl text-sm leading-6 text-slate-500">
                Selamat datang, {{ auth()->user()->name }}.
            </p>
        </div>

        <span class="inline-flex w-fit rounded-md bg-blue-600 px-3 py-1 text-xs font-semibold capitalize text-white sm:text-sm">
            {{ auth()->user()->role }}
        </span>
    </div>

    <div class="mb-5 grid grid-cols-1 gap-3 sm:mb-6 sm:grid-cols-2 sm:gap-4 xl:grid-cols-3">
        @foreach ($stats as $stat)
            <div class="min-h-28 rounded-lg border border-[#dfe5ef] bg-white p-4 sm:p-5">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <div class="text-sm font-medium text-slate-500">{{ $stat['label'] }}</div>
                        <div class="mt-1 text-xs leading-5 text-slate-400">{{ $stat['description'] }}</div>
                    </div>
                    <div class="rounded-md bg-[#edf1f7] px-2 py-1 text-xs font-semibold text-slate-600">
                        Total
                    </div>
                </div>

                <div class="mt-5 text-3xl font-semibold leading-none text-slate-900 sm:text-4xl">
                    {{ $stat['value'] }}
                </div>
            </div>
        @endforeach
    </div>

    <div class="grid gap-4 lg:grid-cols-[minmax(0,1fr)_20rem]">
        <div class="rounded-lg border border-[#dfe5ef] bg-white p-4 sm:p-5">
            <h2 class="text-base font-semibold text-slate-900 sm:text-lg">Alur Laravel</h2>
            <p class="mt-2 text-sm leading-6 text-slate-500">
                Route menerima request, middleware memastikan user sudah login, Fortify menangani autentikasi, lalu Blade menampilkan dashboard. Tahap berikutnya adalah membuat model, migration, dan Livewire CRUD untuk categories dan posts.
            </p>
        </div>

        <div class="rounded-lg border border-[#dfe5ef] bg-white p-4 sm:p-5">
            <h2 class="text-base font-semibold text-slate-900 sm:text-lg">Akses Cepat</h2>
            <div class="mt-4 grid gap-2">
                <a href="{{ route('categories.index') }}" class="rounded-md border border-[#dfe5ef] px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-[#edf1f7]">
                    Kelola Categories
                </a>
                <a href="{{ route('posts.index') }}" class="rounded-md border border-[#dfe5ef] px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-[#edf1f7]">
                    Kelola Posts
                </a>
                @can('manage-users')
                    <a href="{{ route('users.index') }}" class="rounded-md border border-[#dfe5ef] px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-[#edf1f7]">
                        Kelola Users & Role
                    </a>
                @endcan
            </div>
        </div>
    </div>
</x-layouts.app>
