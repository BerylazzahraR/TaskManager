<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-100">Selamat Datang Kembali</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Silakan masuk untuk mengelola tugas tim Anda</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-4">
            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Email</label>
            <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                class="w-full rounded-xl border-slate-300 dark:border-slate-600 dark:bg-slate-900/50 dark:text-slate-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 text-sm transition-colors">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mb-4">
            <div class="flex justify-between items-center mb-2">
                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors" href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </div>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="w-full rounded-xl border-slate-300 dark:border-slate-600 dark:bg-slate-900/50 dark:text-slate-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 text-sm transition-colors">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mb-6">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" name="remember" class="rounded-md border-slate-300 dark:border-slate-600 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:bg-slate-900/50">
                <span class="ms-2 text-sm text-slate-600 dark:text-slate-400 font-medium">Ingat akun saya</span>
            </label>
        </div>

        <div class="space-y-4">
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-indigo-200 dark:shadow-none transition-all flex items-center justify-center gap-2 text-sm">
                <span class="iconify" data-icon="lucide:log-in" data-width="16"></span> Masuk ke Akun
            </button>

            @if (Route::has('register'))
                <p class="text-center text-sm text-slate-500 dark:text-slate-400">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="font-bold text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors">Daftar sekarang</a>
                </p>
            @endif
        </div>
    </form>
</x-guest-layout>