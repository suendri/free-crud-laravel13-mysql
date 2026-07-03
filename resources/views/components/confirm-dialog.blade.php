@props([
    'action',
    'title' => 'Konfirmasi tindakan',
    'message' => 'Apakah Anda yakin ingin melanjutkan?',
    'confirmLabel' => 'Ya, lanjutkan',
    'cancelLabel' => 'Batal',
])

<span
    {{ $attributes->class('inline-flex') }}
    x-data="{ open: false }"
    x-on:keydown.escape.window="open = false"
>
    <span x-on:click="open = true">
        {{ $trigger }}
    </span>

    <template x-teleport="body">
        <div
            class="fixed inset-0 z-[80] flex items-end justify-center px-4 py-6 sm:items-center"
            x-cloak
            x-show="open"
        >
            <div
                class="absolute inset-0 bg-slate-950/50"
                aria-hidden="true"
                x-transition.opacity
            ></div>

            <section
                class="relative w-full max-w-md rounded-lg border border-[#dfe5ef] bg-white shadow-xl"
                role="dialog"
                aria-modal="true"
                x-show="open"
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="translate-y-3 opacity-0 sm:scale-95 sm:translate-y-0"
                x-transition:enter-end="translate-y-0 opacity-100 sm:scale-100"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="translate-y-0 opacity-100 sm:scale-100"
                x-transition:leave-end="translate-y-3 opacity-0 sm:scale-95 sm:translate-y-0"
            >
                <div class="p-5">
                    <h2 class="text-base font-semibold text-slate-900">{{ $title }}</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-500">{{ $message }}</p>
                </div>

                <div class="flex flex-col-reverse gap-2 border-t border-[#dfe5ef] px-5 py-4 sm:flex-row sm:justify-end">
                    <button
                        type="button"
                        class="rounded-md border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
                        x-on:click="open = false"
                    >
                        {{ $cancelLabel }}
                    </button>
                    <button
                        type="button"
                        class="rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-red-700"
                        x-on:click="$wire.{{ $action }}; open = false"
                    >
                        {{ $confirmLabel }}
                    </button>
                </div>
            </section>
        </div>
    </template>
</span>
