<div class="p-4">
    <div class="mb-6 flex items-center gap-3">
        <img src="{{ asset('img/delitekno.png') }}" class="size-11 object-contain" alt="Brand">
        <div>
            <div class="font-semibold text-slate-900">CRUD Laravel</div>
            <div class="text-sm text-slate-500">Fortify + Livewire</div>
        </div>
    </div>

    <nav class="grid gap-1">
        <a
            href="{{ route('dashboard') }}"
            @class([
                'rounded-md px-3 py-2 text-sm font-medium transition',
                'bg-blue-600 text-white hover:bg-blue-700' => request()->routeIs('dashboard'),
                'text-slate-700 hover:bg-[#edf1f7]' => ! request()->routeIs('dashboard'),
            ])
        >
            Dashboard
        </a>
        <a
            href="{{ route('categories.index') }}"
            @class([
                'rounded-md px-3 py-2 text-sm font-medium transition',
                'bg-blue-600 text-white hover:bg-blue-700' => request()->routeIs('categories.*'),
                'text-slate-700 hover:bg-[#edf1f7]' => ! request()->routeIs('categories.*'),
            ])
        >
            Categories
        </a>
        <a
            href="{{ route('posts.index') }}"
            @class([
                'rounded-md px-3 py-2 text-sm font-medium transition',
                'bg-blue-600 text-white hover:bg-blue-700' => request()->routeIs('posts.*'),
                'text-slate-700 hover:bg-[#edf1f7]' => ! request()->routeIs('posts.*'),
            ])
        >
            Posts
        </a>
        @can('manage-users')
            <a
                href="{{ route('users.index') }}"
                @class([
                    'rounded-md px-3 py-2 text-sm font-medium transition',
                    'bg-blue-600 text-white hover:bg-blue-700' => request()->routeIs('users.*'),
                    'text-slate-700 hover:bg-[#edf1f7]' => ! request()->routeIs('users.*'),
                ])
            >
                Users & Role
            </a>
        @endcan
    </nav>
</div>
