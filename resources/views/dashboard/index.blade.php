<x-layouts.app title="Free CRUD Laravel | Dashboard">
    <div class="mb-6 flex flex-col justify-between gap-3 md:flex-row md:items-center">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">
                Dashboard
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Selamat datang, {{ auth()->user()->name }}.
            </p>
        </div>

        <span class="inline-flex w-fit rounded-md bg-blue-600 px-3 py-1 text-sm font-medium capitalize text-white">
            operator
        </span>
    </div>

    <div class="mb-6 grid gap-4 md:grid-cols-3">
        <div class="rounded-lg border border-[#dfe5ef] bg-white p-5">
            <div class="mb-2 text-sm text-slate-500">Users</div>
            <div class="text-4xl font-semibold text-slate-900">{{ $totalUsers }}</div>
        </div>

        <div class="rounded-lg border border-[#dfe5ef] bg-white p-5">
            <div class="mb-2 text-sm text-slate-500">Categories</div>
            <div class="text-4xl font-semibold text-slate-900">{{ $totalCategories }}</div>
        </div>

        <div class="rounded-lg border border-[#dfe5ef] bg-white p-5">
            <div class="mb-2 text-sm text-slate-500">Posts</div>
            <div class="text-4xl font-semibold text-slate-900">{{ $totalPosts }}</div>
        </div>
    </div>

    <div class="rounded-lg border border-[#dfe5ef] bg-white p-5">
        <h2 class="text-lg font-semibold text-slate-900">Alur Laravel</h2>
        <p class="mt-2 text-sm leading-6 text-slate-500">
            Route menerima request, middleware memastikan user sudah login, Fortify menangani autentikasi, lalu Blade menampilkan dashboard. Tahap berikutnya adalah membuat model, migration, dan Livewire CRUD untuk categories dan posts.
        </p>
    </div>
</x-layouts.app>
