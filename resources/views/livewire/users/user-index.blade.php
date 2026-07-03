<div>
    <div class="mb-5 flex flex-col gap-3 sm:mb-6 sm:flex-row sm:items-end sm:justify-between">
        <div class="min-w-0">
            <h1 class="text-xl font-semibold text-slate-900 sm:text-2xl">Users & Role</h1>
            <p class="mt-1 text-sm leading-6 text-slate-500">Admin dapat menambah user dan mengubah operator menjadi admin.</p>
        </div>

        <div class="inline-flex w-fit rounded-md bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700 sm:text-sm">
            {{ $users->total() }} user
        </div>
    </div>

    @if (session('success'))
        <div class="mb-5 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-5 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid gap-4 xl:grid-cols-[minmax(0,1fr)_400px]">
        <div class="min-w-0 rounded-lg border border-[#dfe5ef] bg-white">
            <div class="border-b border-[#dfe5ef] p-4 sm:p-5">
                <label for="user-search" class="sr-only">Cari user</label>
                <input
                    id="user-search"
                    type="search"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Cari nama, email, atau role..."
                    class="block w-full rounded-md border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                >
            </div>

            <div class="grid gap-3 p-4 md:hidden">
                @forelse ($users as $user)
                    <div wire:key="user-card-{{ $user->id }}" class="rounded-lg border border-[#dfe5ef] bg-white p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <div class="text-xs font-semibold uppercase text-slate-400">
                                    #{{ $users->firstItem() + $loop->index }}
                                </div>
                                <h2 class="mt-1 break-words text-base font-semibold text-slate-900">
                                    {{ $user->name }}
                                </h2>
                                <p class="mt-1 break-all text-sm leading-6 text-slate-500">
                                    {{ $user->email }}
                                </p>
                            </div>

                            @if ($user->is(auth()->user()))
                                <span class="shrink-0 rounded-md bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-600">
                                    Aktif
                                </span>
                            @endif
                        </div>

                        <div class="mt-4">
                            <label for="user-role-card-{{ $user->id }}" class="mb-2 block text-xs font-semibold uppercase text-slate-400">Role</label>
                            <select
                                id="user-role-card-{{ $user->id }}"
                                wire:change="updateRole({{ $user->id }}, $event.target.value)"
                                @disabled($user->is(auth()->user()))
                                class="form-select-control block w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm capitalize text-slate-900 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100 disabled:cursor-not-allowed disabled:bg-slate-100 disabled:text-slate-500"
                                aria-label="Role user"
                            >
                                <option value="operator" @selected($user->role === 'operator')>Operator</option>
                                <option value="admin" @selected($user->role === 'admin')>Admin</option>
                            </select>
                        </div>

                        <div class="mt-4 grid grid-cols-2 gap-2">
                            <button
                                type="button"
                                wire:click="edit({{ $user->id }})"
                                class="rounded-md border border-blue-200 px-3 py-2 text-sm font-medium text-blue-600 transition hover:bg-blue-50"
                            >
                                Edit
                            </button>

                            @if ($user->is(auth()->user()))
                                <button
                                    type="button"
                                    disabled
                                    class="rounded-md border border-red-200 px-3 py-2 text-sm font-medium text-red-600 opacity-50"
                                >
                                    Hapus
                                </button>
                            @else
                                <x-confirm-dialog
                                    class="w-full"
                                    action="delete({{ $user->id }})"
                                    title="Hapus user?"
                                    message="User {{ $user->name }} akan dihapus permanen."
                                    confirm-label="Hapus"
                                >
                                    <x-slot:trigger>
                                        <button
                                            type="button"
                                            class="w-full rounded-md border border-red-200 px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50"
                                        >
                                            Hapus
                                        </button>
                                    </x-slot:trigger>
                                </x-confirm-dialog>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="rounded-lg border border-dashed border-[#dfe5ef] px-4 py-8 text-center text-sm text-slate-500">
                        Belum ada user.
                    </div>
                @endforelse
            </div>

            <div class="hidden overflow-x-auto md:block">
                <table class="w-full min-w-[860px] text-left text-sm">
                    <thead class="bg-slate-50 text-xs uppercase text-slate-500">
                        <tr>
                            <th class="w-20 px-4 py-3 font-semibold">No</th>
                            <th class="px-4 py-3 font-semibold">Email</th>
                            <th class="px-4 py-3 font-semibold">Nama</th>
                            <th class="w-64 px-4 py-3 font-semibold">Role</th>
                            <th class="w-44 px-4 py-3 text-right font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($users as $user)
                            <tr wire:key="user-{{ $user->id }}" class="hover:bg-slate-50">
                                <td class="px-4 py-3 text-slate-500">
                                    {{ $users->firstItem() + $loop->index }}
                                </td>
                                <td class="px-4 py-3 text-slate-700">{{ $user->email }}</td>
                                <td class="px-4 py-3 font-medium text-slate-900">{{ $user->name }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <select
                                            wire:change="updateRole({{ $user->id }}, $event.target.value)"
                                            @disabled($user->is(auth()->user()))
                                            class="form-select-control block w-36 rounded-md border border-slate-300 bg-white px-2 py-1.5 text-sm capitalize text-slate-900 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100 disabled:cursor-not-allowed disabled:bg-slate-100 disabled:text-slate-500"
                                            aria-label="Role user"
                                        >
                                            <option value="operator" @selected($user->role === 'operator')>Operator</option>
                                            <option value="admin" @selected($user->role === 'admin')>Admin</option>
                                        </select>

                                        @if ($user->is(auth()->user()))
                                            <span class="text-xs text-slate-500">Akun aktif</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-end gap-2">
                                        <button
                                            type="button"
                                            wire:click="edit({{ $user->id }})"
                                            class="rounded-md border border-blue-200 px-3 py-1.5 text-sm font-medium text-blue-600 transition hover:bg-blue-50"
                                        >
                                            Edit
                                        </button>
                                        @if ($user->is(auth()->user()))
                                            <button
                                                type="button"
                                                disabled
                                                class="rounded-md border border-red-200 px-3 py-1.5 text-sm font-medium text-red-600 opacity-50"
                                            >
                                                Hapus
                                            </button>
                                        @else
                                            <x-confirm-dialog
                                                action="delete({{ $user->id }})"
                                                title="Hapus user?"
                                                message="User {{ $user->name }} akan dihapus permanen."
                                                confirm-label="Hapus"
                                            >
                                                <x-slot:trigger>
                                                    <button
                                                        type="button"
                                                        class="rounded-md border border-red-200 px-3 py-1.5 text-sm font-medium text-red-600 transition hover:bg-red-50"
                                                    >
                                                        Hapus
                                                    </button>
                                                </x-slot:trigger>
                                            </x-confirm-dialog>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-sm text-slate-500">
                                    Belum ada user.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($users->hasPages())
                <div class="border-t border-[#dfe5ef] px-4 py-3">
                    {{ $users->links() }}
                </div>
            @endif
        </div>

        <div class="rounded-lg border border-[#dfe5ef] bg-white p-4 sm:p-5">
            <h2 class="text-base font-semibold text-slate-900 sm:text-lg">
                {{ $editingUserId ? 'Edit User' : 'Tambah User' }}
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                {{ $editingUserId ? 'Kosongkan password jika tidak ingin mengubahnya.' : 'Admin dapat membuat akun operator atau admin.' }}
            </p>

            <form wire:submit="save" class="mt-5 grid gap-4">
                <div>
                    <label for="user-name" class="mb-2 block text-sm font-medium text-slate-700">Nama Lengkap</label>
                    <input
                        id="user-name"
                        type="text"
                        wire:model="name"
                        class="block w-full rounded-md border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                    >
                    @error('name')
                        <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="user-email" class="mb-2 block text-sm font-medium text-slate-700">Email</label>
                    <input
                        id="user-email"
                        type="email"
                        wire:model="email"
                        class="block w-full rounded-md border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                    >
                    @error('email')
                        <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="user-password" class="mb-2 block text-sm font-medium text-slate-700">
                        {{ $editingUserId ? 'Password Baru' : 'Password' }}
                    </label>
                    <input
                        id="user-password"
                        type="password"
                        wire:model="password"
                        class="block w-full rounded-md border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                    >
                    @error('password')
                        <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="user-role" class="mb-2 block text-sm font-medium text-slate-700">Role</label>
                    <select
                        id="user-role"
                        wire:model="role"
                        @disabled($editingUserId === auth()->id())
                        class="form-select-control block w-full rounded-md border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100 disabled:cursor-not-allowed disabled:bg-slate-100 disabled:text-slate-500"
                    >
                        <option value="operator">Operator</option>
                        <option value="admin">Admin</option>
                    </select>
                    @error('role')
                        <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <div class="grid gap-2 sm:flex">
                    <button
                        type="submit"
                        class="rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700 disabled:opacity-60"
                        wire:loading.attr="disabled"
                        wire:target="save"
                    >
                        {{ $editingUserId ? 'Update' : 'Simpan' }}
                    </button>

                    @if ($editingUserId)
                        <button
                            type="button"
                            wire:click="cancel"
                            class="rounded-md border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
                        >
                            Batal
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
