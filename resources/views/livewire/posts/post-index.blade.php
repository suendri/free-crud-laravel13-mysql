<div>
    <div class="mb-5 flex flex-col gap-3 sm:mb-6 sm:flex-row sm:items-end sm:justify-between">
        <div class="min-w-0">
            <h1 class="text-xl font-semibold text-slate-900 sm:text-2xl">Posts</h1>
            <p class="mt-1 text-sm leading-6 text-slate-500">Kelola konten post berdasarkan kategori.</p>
        </div>

        <div class="inline-flex w-fit rounded-md bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700 sm:text-sm">
            {{ $posts->total() }} post
        </div>
    </div>

    @if (session('success'))
        <div class="mb-5 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid gap-4 xl:grid-cols-[minmax(0,1fr)_420px]">
        <div class="min-w-0 rounded-lg border border-[#dfe5ef] bg-white">
            <div class="border-b border-[#dfe5ef] p-4 sm:p-5">
                <label for="post-search" class="sr-only">Cari post</label>
                <input
                    id="post-search"
                    type="search"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Cari judul, teks, atau kategori..."
                    class="block w-full rounded-md border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                >
            </div>

            <div class="grid gap-3 p-4 md:hidden">
                @forelse ($posts as $post)
                    <div wire:key="post-card-{{ $post->id }}" class="rounded-lg border border-[#dfe5ef] bg-white p-4">
                        <div class="flex flex-col gap-3">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <div class="text-xs font-semibold uppercase text-slate-400">
                                        #{{ $posts->firstItem() + $loop->index }}
                                    </div>
                                    <h2 class="mt-1 break-words text-base font-semibold text-slate-900">
                                        {{ $post->title }}
                                    </h2>
                                </div>
                                <span class="shrink-0 rounded-md bg-slate-100 px-2 py-1 text-xs font-medium text-slate-700">
                                    {{ $post->category->name }}
                                </span>
                            </div>

                            @if ($post->text)
                                <p class="line-clamp-3 text-sm leading-6 text-slate-500">
                                    {{ $post->text }}
                                </p>
                            @endif
                        </div>

                        <div class="mt-4 grid grid-cols-2 gap-2">
                            <button
                                type="button"
                                wire:click="edit({{ $post->id }})"
                                class="rounded-md border border-blue-200 px-3 py-2 text-sm font-medium text-blue-600 transition hover:bg-blue-50"
                            >
                                Edit
                            </button>
                            <x-confirm-dialog
                                class="w-full"
                                action="delete({{ $post->id }})"
                                title="Hapus post?"
                                message="Post {{ $post->title }} akan dihapus permanen."
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
                        Belum ada post.
                    </div>
                @endforelse
            </div>

            <div class="hidden overflow-x-auto md:block">
                <table class="w-full min-w-[720px] text-left text-sm">
                    <thead class="bg-slate-50 text-xs uppercase text-slate-500">
                        <tr>
                            <th class="w-20 px-4 py-3 font-semibold">No</th>
                            <th class="w-44 px-4 py-3 font-semibold">Kategori</th>
                            <th class="px-4 py-3 font-semibold">Judul</th>
                            <th class="w-48 px-4 py-3 text-right font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($posts as $post)
                            <tr wire:key="post-{{ $post->id }}" class="hover:bg-slate-50">
                                <td class="px-4 py-3 text-slate-500">
                                    {{ $posts->firstItem() + $loop->index }}
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex rounded-md bg-slate-100 px-2 py-1 text-xs font-medium text-slate-700">
                                        {{ $post->category->name }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="font-medium text-slate-900">{{ $post->title }}</div>
                                    @if ($post->text)
                                        <div class="mt-1 max-w-xl truncate text-sm text-slate-500">
                                            {{ $post->text }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-end gap-2">
                                        <button
                                            type="button"
                                            wire:click="edit({{ $post->id }})"
                                            class="rounded-md border border-blue-200 px-3 py-1.5 text-sm font-medium text-blue-600 transition hover:bg-blue-50"
                                        >
                                            Edit
                                        </button>
                                        <x-confirm-dialog
                                            action="delete({{ $post->id }})"
                                            title="Hapus post?"
                                            message="Post {{ $post->title }} akan dihapus permanen."
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
                                <td colspan="4" class="px-4 py-8 text-center text-sm text-slate-500">
                                    Belum ada post.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($posts->hasPages())
                <div class="border-t border-[#dfe5ef] px-4 py-3">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>

        <div class="rounded-lg border border-[#dfe5ef] bg-white p-4 sm:p-5">
            <h2 class="text-base font-semibold text-slate-900 sm:text-lg">
                {{ $editingPostId ? 'Edit Post' : 'Tambah Post' }}
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                {{ $editingPostId ? 'Perbarui kategori dan isi post.' : 'Pilih kategori dan tulis konten post.' }}
            </p>

            @if ($categories->isEmpty())
                <div class="mt-5 rounded-md border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
                    Buat kategori terlebih dahulu sebelum menambahkan post.
                </div>
            @endif

            <form wire:submit="save" class="mt-5 grid gap-4">
                <div>
                    <label for="post-category" class="mb-2 block text-sm font-medium text-slate-700">Kategori</label>
                    <select
                        id="post-category"
                        wire:model="categoryId"
                        class="form-select-control block w-full rounded-md border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                    >
                        <option value="">Pilih kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" wire:key="post-category-option-{{ $category->id }}">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('categoryId')
                        <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="post-title" class="mb-2 block text-sm font-medium text-slate-700">Judul</label>
                    <input
                        id="post-title"
                        type="text"
                        wire:model="title"
                        class="block w-full rounded-md border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                    >
                    @error('title')
                        <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="post-text" class="mb-2 block text-sm font-medium text-slate-700">Teks</label>
                    <textarea
                        id="post-text"
                        wire:model="text"
                        rows="8"
                        class="block w-full rounded-md border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
                    ></textarea>
                    @error('text')
                        <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                    @enderror
                </div>

                <div class="grid gap-2 sm:flex">
                    <button
                        type="submit"
                        @disabled($categories->isEmpty())
                        class="rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-60"
                        wire:loading.attr="disabled"
                        wire:target="save"
                    >
                        {{ $editingPostId ? 'Update' : 'Simpan' }}
                    </button>

                    @if ($editingPostId)
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
