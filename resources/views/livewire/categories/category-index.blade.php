<div>
    <div class="mb-5 flex flex-col gap-3 sm:mb-6 sm:flex-row sm:items-end sm:justify-between">
        <div class="min-w-0">
            <h1 class="text-xl font-semibold text-slate-900 sm:text-2xl">Categories</h1>
            <p class="mt-1 text-sm leading-6 text-slate-500">Kelola kategori untuk post.</p>
        </div>

        <div class="inline-flex w-fit rounded-md bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700 sm:text-sm">
            {{ $categories->total() }} kategori
        </div>
    </div>

    @if (session('success'))
        <div class="mb-5 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid gap-4 xl:grid-cols-[minmax(0,1fr)_360px]">
        <div class="min-w-0 rounded-lg border border-[#dfe5ef] bg-white">
            <div class="border-b border-[#dfe5ef] p-4 sm:p-5">
                <label for="category-search" class="sr-only">Cari kategori</label>
                <input
                    id="category-search"
                    type="search"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Cari kategori..."
                    class="block w-full rounded-md border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                >
            </div>

            <div class="grid gap-3 p-4 md:hidden">
                @forelse ($categories as $category)
                    <div wire:key="category-card-{{ $category->id }}" class="rounded-lg border border-[#dfe5ef] bg-white p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <div class="text-xs font-semibold uppercase text-slate-400">
                                    #{{ $categories->firstItem() + $loop->index }}
                                </div>
                                <div class="mt-1 break-words text-base font-semibold text-slate-900">
                                    {{ $category->name }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 grid grid-cols-2 gap-2">
                            <button
                                type="button"
                                wire:click="edit({{ $category->id }})"
                                class="rounded-md border border-blue-200 px-3 py-2 text-sm font-medium text-blue-600 transition hover:bg-blue-50"
                            >
                                Edit
                            </button>
                            <x-confirm-dialog
                                class="w-full"
                                action="delete({{ $category->id }})"
                                title="Hapus kategori?"
                                message="Kategori {{ $category->name }} akan dihapus permanen."
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
                        </div>
                    </div>
                @empty
                    <div class="rounded-lg border border-dashed border-[#dfe5ef] px-4 py-8 text-center text-sm text-slate-500">
                        Belum ada kategori.
                    </div>
                @endforelse
            </div>

            <div class="hidden overflow-x-auto md:block">
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
                                        <x-confirm-dialog
                                            action="delete({{ $category->id }})"
                                            title="Hapus kategori?"
                                            message="Kategori {{ $category->name }} akan dihapus permanen."
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

        <div class="rounded-lg border border-[#dfe5ef] bg-white p-4 sm:p-5">
            <h2 class="text-base font-semibold text-slate-900 sm:text-lg">
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

                <div class="grid gap-2 sm:flex">
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
