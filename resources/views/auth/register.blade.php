<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-100">Buat Akun Baru</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Mulai kelola tugas dan kolaborasi tim Anda</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-4">
            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Nama Lengkap</label>
            <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                class="w-full rounded-xl border-slate-300 dark:border-slate-600 dark:bg-slate-900/50 dark:text-slate-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 text-sm transition-colors">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mb-4">
            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Email</label>
            <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                class="w-full rounded-xl border-slate-300 dark:border-slate-600 dark:bg-slate-900/50 dark:text-slate-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 text-sm transition-colors">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mb-4">
            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                class="w-full rounded-xl border-slate-300 dark:border-slate-600 dark:bg-slate-900/50 dark:text-slate-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 text-sm transition-colors">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mb-6">
            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                class="w-full rounded-xl border-slate-300 dark:border-slate-600 dark:bg-slate-900/50 dark:text-slate-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 text-sm transition-colors">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="space-y-4">
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-indigo-200 dark:shadow-none transition-all flex items-center justify-center gap-2 text-sm">
                <span class="iconify" data-icon="lucide:user-plus" data-width="16"></span> Daftar Akun
            </button>

            <p class="text-center text-sm text-slate-500 dark:text-slate-400">
                Sudah punya akun? masuk dengan email Anda. 
                <a href="{{ route('login') }}" class="font-bold text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors">Login di sini</a>
            </p>
        </div>
    </form>
</x-guest-layout>