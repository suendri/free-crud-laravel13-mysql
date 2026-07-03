<div>
    <div class="mb-6 flex flex-col justify-between gap-3 md:flex-row md:items-center">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Users & Role</h1>
            <p class="mt-1 text-sm text-slate-500">Admin dapat menambah user dan mengubah operator menjadi admin.</p>
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

    <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_400px]">
        <div class="rounded-lg border border-[#dfe5ef] bg-white">
            <div class="border-b border-[#dfe5ef] p-4">
                <label for="user-search" class="sr-only">Cari user</label>
                <input
                    id="user-search"
                    type="search"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Cari nama, email, atau role..."
                    class="block w-full rounded-md border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                >
            </div>

            <div class="overflow-x-auto">
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
                                            class="block w-36 rounded-md border border-slate-300 bg-white px-2 py-1.5 text-sm capitalize text-slate-900 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100 disabled:cursor-not-allowed disabled:bg-slate-100 disabled:text-slate-500"
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
                                        <button
                                            type="button"
                                            wire:click="delete({{ $user->id }})"
                                            wire:confirm="Hapus user ini?"
                                            @disabled($user->is(auth()->user()))
                                            class="rounded-md border border-red-200 px-3 py-1.5 text-sm font-medium text-red-600 transition hover:bg-red-50 disabled:cursor-not-allowed disabled:opacity-50"
                                        >
                                            Hapus
                                        </button>
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

        <div class="rounded-lg border border-[#dfe5ef] bg-white p-5">
            <h2 class="text-lg font-semibold text-slate-900">
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
                        class="block w-full rounded-md border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100 disabled:cursor-not-allowed disabled:bg-slate-100 disabled:text-slate-500"
                    >
                        <option value="operator">Operator</option>
                        <option value="admin">Admin</option>
                    </select>
                    @error('role')
                        <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <div class="flex gap-2">
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
