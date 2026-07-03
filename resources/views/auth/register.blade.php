<x-layouts.auth title="Free CRUD Laravel | Register">
    <div class="mb-8">
        <h2 class="text-2xl font-semibold text-slate-900">
            Registrasi Operator
        </h2>
        <p class="mt-2 text-sm text-slate-500">
            Akun baru menggunakan proses registrasi Laravel Fortify.
        </p>
    </div>

    @if ($errors->any())
        <div class="mb-5 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <ul class="list-inside list-disc space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register.store') }}" method="POST" class="grid gap-5">
        @csrf

        <div>
            <label for="name" class="mb-2 block text-sm font-medium text-slate-700">Nama Lengkap</label>
            <input
                id="name"
                name="name"
                type="text"
                value="{{ old('name') }}"
                required
                autofocus
                autocomplete="name"
                class="block w-full rounded-md border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
            >
        </div>

        <div>
            <label for="email" class="mb-2 block text-sm font-medium text-slate-700">Email</label>
            <input
                id="email"
                name="email"
                type="email"
                value="{{ old('email') }}"
                required
                autocomplete="username"
                placeholder="nama@email.com"
                class="block w-full rounded-md border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
            >
        </div>

        <div>
            <label for="password" class="mb-2 block text-sm font-medium text-slate-700">Password</label>
            <input
                id="password"
                name="password"
                type="password"
                required
                autocomplete="new-password"
                class="block w-full rounded-md border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
            >
        </div>

        <div>
            <label for="password_confirmation" class="mb-2 block text-sm font-medium text-slate-700">Konfirmasi Password</label>
            <input
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                required
                autocomplete="new-password"
                class="block w-full rounded-md border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
            >
        </div>

        <button type="submit" class="w-full rounded-md bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100">
            Daftar
        </button>
    </form>

    <div class="mt-8 border-t border-slate-200 pt-6 text-center text-sm">
        <span class="text-slate-500">Sudah punya akun?</span>
        <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-700">Login</a>
    </div>
</x-layouts.auth>
