<div>
    <div class="mb-6 flex flex-col justify-between gap-3 md:flex-row md:items-center">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Categories</h1>
            <p class="mt-1 text-sm text-slate-500">Kelola kategori untuk post.</p>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-5 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid gap-5 lg:grid-cols-[minmax(0,1fr)_360px]">
        <div class="rounded-lg border border-[#dfe5ef] bg-white">
            <div class="border-b border-[#dfe5ef] p-4">
                <label for="category-search" class="sr-only">Cari kategori</label>
                <input
                    id="category-search"
                    type="search"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Cari kategori..."
                    class="block w-full rounded-md border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                >
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[560px] text-left text-sm">
                    <thead class="bg-slate-50 text-xs uppercase text-slate-500">
                        <tr>
                            <th class="w-20 px-4 py-3 font-semibold">No</th>
                            <th class="px-4 py-3 font-semibold">Nama</th>
                            <th class="w-48 px-4 py-3 text-right font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($categories as $category)
                            <tr wire:key="category-{{ $category->id }}" class="hover:bg-slate-50">
                                <td class="px-4 py-3 text-slate-500">
                                    {{ $categories->firstItem() + $loop->index }}
                                </td>
                                <td class="px-4 py-3 font-medium text-slate-900">
                                    {{ $category->name }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-end gap-2">
                                        <button
                                            type="button"
                                            wire:click="edit({{ $category->id }})"
                                            class="rounded-md border border-blue-200 px-3 py-1.5 text-sm font-medium text-blue-600 transition hover:bg-blue-50"
                                        >
                                            Edit
                                        </button>
                                        <button
                                            type="button"
                                            wire:click="delete({{ $category->id }})"
                                            wire:confirm="Hapus kategori ini?"
                                            class="rounded-md border border-red-200 px-3 py-1.5 text-sm font-medium text-red-600 transition hover:bg-red-50"
                                        >
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-8 text-center text-sm text-slate-500">
                                    Belum ada kategori.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($categories->hasPages())
                <div class="border-t border-[#dfe5ef] px-4 py-3">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>

        <div class="rounded-lg border border-[#dfe5ef] bg-white p-5">
            <h2 class="text-lg font-semibold text-slate-900">
                {{ $editingCategoryId ? 'Edit Category' : 'Tambah Category' }}
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                {{ $editingCategoryId ? 'Perbarui nama kategori.' : 'Masukkan nama kategori baru.' }}
            </p>

            <form wire:submit="save" class="mt-5 grid gap-4">
                <div>
                    <label for="category-name" class="mb-2 block text-sm font-medium text-slate-700">Nama</label>
                    <input
                        id="category-name"
                        type="text"
                        wire:model="name"
                        class="block w-full rounded-md border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                    >
                    @error('name')
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
                        {{ $editingCategoryId ? 'Update' : 'Simpan' }}
                    </button>

                    @if ($editingCategoryId)
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
