<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400 transition-colors">
            <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Dashboard</a>
            <span class="iconify" data-icon="lucide:chevron-right" data-width="14"></span>
            <span class="font-semibold text-slate-800 dark:text-slate-200 transition-colors">Pengaturan Profil</span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white dark:bg-slate-800 overflow-hidden border border-slate-100 dark:border-slate-700/50 sm:rounded-2xl shadow-[4px_4px_24px_rgba(0,0,0,0.02)] dark:shadow-none p-6 sm:p-8 transition-colors duration-300">
                <div class="mb-6 border-b border-slate-100 dark:border-slate-700/50 pb-4">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                        <span class="iconify text-indigo-500" data-icon="lucide:user"></span> Informasi Profil
                    </h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Perbarui informasi profil akun dan alamat email Anda.</p>
                </div>

                <form method="post" action="{{ route('profile.update') }}" class="space-y-6 max-w-xl">
                    @csrf
                    @method('patch')

                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Nama Lengkap</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $indigoUser ?? Auth::user()->name) }}" required autofocus autocomplete="name"
                            class="w-full rounded-xl border-slate-300 dark:border-slate-600 dark:bg-slate-900/50 dark:text-slate-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 text-sm transition-colors">
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Alamat Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email', $indigoUser ?? Auth::user()->email) }}" required autocomplete="username"
                            class="w-full rounded-xl border-slate-300 dark:border-slate-600 dark:bg-slate-900/50 dark:text-slate-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 text-sm transition-colors">
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <div class="flex items-center gap-4 pt-2">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold py-2.5 px-6 rounded-xl shadow-sm transition-all flex items-center gap-2">
                            <span class="iconify" data-icon="lucide:save" data-width="16"></span> Simpan Profil
                        </button>

                        @if (session('status') === 'profile-updated')
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="text-sm text-emerald-600 dark:text-emerald-400 font-medium flex items-center gap-1">
                                <span class="iconify" data-icon="lucide:check-circle" data-width="16"></span> Berhasil disimpan.
                            </p>
                        @endif
                    </div>
                </form>
            </div>

            <div class="bg-white dark:bg-slate-800 overflow-hidden border border-slate-100 dark:border-slate-700/50 sm:rounded-2xl shadow-[4px_4px_24px_rgba(0,0,0,0.02)] dark:shadow-none p-6 sm:p-8 transition-colors duration-300">
                <div class="mb-6 border-b border-slate-100 dark:border-slate-700/50 pb-4">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                        <span class="iconify text-indigo-500" data-icon="lucide:key-round"></span> Perbarui Password
                    </h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Pastikan akun Anda menggunakan password yang panjang dan acak untuk menjaga keamanan.</p>
                </div>

                <form method="post" action="{{ route('password.update') }}" class="space-y-6 max-w-xl">
                    @csrf
                    @method('put')

                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Password Saat Ini</label>
                        <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password"
                            class="w-full rounded-xl border-slate-300 dark:border-slate-600 dark:bg-slate-900/50 dark:text-slate-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 text-sm transition-colors">
                        <x-input-error class="mt-2" :messages="$errors->updatePassword->get('current_password')" />
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Password Baru</label>
                        <input id="update_password_password" name="password" type="password" autocomplete="new-password"
                            class="w-full rounded-xl border-slate-300 dark:border-slate-600 dark:bg-slate-900/50 dark:text-slate-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 text-sm transition-colors">
                        <x-input-error class="mt-2" :messages="$errors->updatePassword->get('password')" />
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Konfirmasi Password Baru</label>
                        <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                            class="w-full rounded-xl border-slate-300 dark:border-slate-600 dark:bg-slate-900/50 dark:text-slate-200 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500/20 text-sm transition-colors">
                        <x-input-error class="mt-2" :messages="$errors->updatePassword->get('password_confirmation')" />
                    </div>

                    <div class="flex items-center gap-4 pt-2">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold py-2.5 px-6 rounded-xl shadow-sm transition-all flex items-center gap-2">
                            <span class="iconify" data-icon="lucide:lock" data-width="16"></span> Perbarui Password
                        </button>

                        @if (session('status') === 'password-updated')
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="text-sm text-emerald-600 dark:text-emerald-400 font-medium flex items-center gap-1">
                                <span class="iconify" data-icon="lucide:check-circle" data-width="16"></span> Password diperbarui.
                            </p>
                        @endif
                    </div>
                </form>
            </div>

            <div x-data="{ confirmDelete: false }" class="bg-white dark:bg-slate-800 overflow-hidden border border-slate-100 dark:border-slate-700/50 sm:rounded-2xl shadow-[4px_4px_24px_rgba(0,0,0,0.02)] dark:shadow-none p-6 sm:p-8 transition-colors duration-300">
                <div class="mb-6 border-b border-slate-100 dark:border-slate-700/50 pb-4">
                    <h3 class="text-lg font-bold text-rose-600 dark:text-rose-400 flex items-center gap-2">
                        <span class="iconify" data-icon="lucide:user-x"></span> Hapus Akun
                    </h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Setelah akun Anda dihapus, semua sumber daya dan data di dalamnya akan dihapus secara permanen.</p>
                </div>

                <div class="max-w-xl">
                    <p class="text-sm text-slate-600 dark:text-slate-400 mb-4 leading-relaxed">
                        Sebelum menghapus akun, harap unduh data atau informasi penting apa pun yang ingin Anda simpan dari dalam workspace Anda.
                    </p>

                    <button x-show="!confirmDelete" @click="confirmDelete = true" type="button" class="bg-rose-50 dark:bg-rose-500/10 hover:bg-rose-100 dark:hover:bg-rose-500/20 text-rose-600 dark:text-rose-400 border border-rose-100 dark:border-rose-500/20 text-sm font-bold py-2.5 px-5 rounded-xl transition-colors shadow-sm">
                        Hapus Akun Saya
                    </button>

                    <div x-show="confirmDelete" x-transition class="bg-rose-50/50 dark:bg-rose-500/5 border border-rose-100 dark:border-rose-500/10 p-5 rounded-xl mt-2">
                        <form method="post" action="{{ route('profile.destroy') }}" class="space-y-4">
                            @csrf
                            @method('delete')

                            <p class="text-xs font-bold text-rose-600 dark:text-rose-400 uppercase tracking-wider">Konfirmasi Penghapusan</p>
                            <p class="text-sm text-slate-600 dark:text-slate-400">Silakan masukkan password Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun ini secara permanen.</p>

                            <div>
                                <input id="password" name="password" type="password" placeholder="Masukkan Password Anda" required
                                    class="w-full max-w-md rounded-xl border-slate-300 dark:border-slate-600 dark:bg-slate-900/50 dark:text-slate-200 shadow-sm focus:border-rose-500 focus:ring focus:ring-rose-500/20 text-sm transition-colors">
                                <x-input-error class="mt-2" :messages="$errors->userDeletion->get('password')" />
                            </div>

                            <div class="flex items-center gap-3 pt-2">
                                <button type="button" @click="confirmDelete = false" class="bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 text-sm font-bold py-2 px-4 rounded-xl transition-colors">
                                    Batal
                                </button>
                                <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-white text-sm font-bold py-2 px-5 rounded-xl shadow-sm transition-colors">
                                    Ya, Hapus Permanen
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>