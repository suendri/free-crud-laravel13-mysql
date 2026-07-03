<x-layouts.auth title="Free CRUD Laravel | Login">
    <div class="mb-8">
        <h2 class="text-2xl font-semibold text-slate-900">
            Login
        </h2>
        <p class="mt-2 text-sm text-slate-500">
            Masuk sebagai operator atau admin.
        </p>
    </div>

    @if ($errors->any())
        <div class="mb-5 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('login.store') }}" method="POST" class="grid gap-5">
        @csrf

        <div>
            <label for="email" class="mb-2 block text-sm font-medium text-slate-700">Email</label>
            <input
                id="email"
                name="email"
                type="email"
                value="{{ old('email') }}"
                required
                autofocus
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
                autocomplete="current-password"
                class="block w-full rounded-md border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100"
            >
        </div>

        <div class="flex items-center justify-between gap-3">
            <label class="inline-flex items-center gap-2 text-sm text-slate-600">
                <input
                    name="remember"
                    type="checkbox"
                    value="1"
                    class="size-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500"
                >
                Ingat saya
            </label>

            <a href="{{ route('password.request') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700">
                Lupa password?
            </a>
        </div>

        <button type="submit" class="w-full rounded-md bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-100">
            Login
        </button>
    </form>

    <div class="mt-8 border-t border-slate-200 pt-6 text-center text-sm">
        <span class="text-slate-500">Belum punya akun operator?</span>
        <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-700">Registrasi</a>
    </div>
</x-layouts.auth>
