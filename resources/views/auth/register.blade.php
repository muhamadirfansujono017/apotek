<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-50 via-white to-cyan-50 dark:from-gray-950 dark:via-gray-900 dark:to-indigo-950 px-4 py-12">
        <div class="w-full max-w-lg">
            
            <div class="text-center mb-8">
                <div class="inline-flex p-4 rounded-[1.5rem] bg-indigo-600 shadow-xl shadow-indigo-200 dark:shadow-none mb-4">
                    <i class="fas fa-user-plus text-2xl text-white"></i>
                </div>
                <h1 class="text-3xl font-black text-gray-900 dark:text-white tracking-tighter uppercase italic">
                    Daftar <span class="text-indigo-600">Akun</span>
                </h1>
                <p class="text-gray-500 dark:text-gray-400 mt-2 font-semibold">Buat akses baru untuk Sistem Apotek JUJU</p>
            </div>

            <div class="bg-white/70 dark:bg-gray-900/80 backdrop-blur-2xl p-8 rounded-[2.5rem] shadow-2xl border border-white dark:border-gray-800">
                
                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Nama Lengkap</label>
                            <input type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                                class="w-full px-5 py-3 bg-gray-50/50 dark:bg-gray-800 border-none rounded-xl focus:ring-2 focus:ring-indigo-600 transition-all text-gray-900 dark:text-white" 
                                placeholder="Nama Anda">
                            <x-input-error :messages="$errors->get('name')" class="mt-1" />
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Email</label>
                            <input type="email" name="email" :value="old('email')" required autocomplete="username"
                                class="w-full px-5 py-3 bg-gray-50/50 dark:bg-gray-800 border-none rounded-xl focus:ring-2 focus:ring-indigo-600 transition-all text-gray-900 dark:text-white" 
                                placeholder="email@apotek.com">
                            <x-input-error :messages="$errors->get('email')" class="mt-1" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Password</label>
                            <input type="password" name="password" required autocomplete="new-password"
                                class="w-full px-5 py-3 bg-gray-50/50 dark:bg-gray-800 border-none rounded-xl focus:ring-2 focus:ring-indigo-600 transition-all text-gray-900 dark:text-white" 
                                placeholder="••••••••">
                            <x-input-error :messages="$errors->get('password')" class="mt-1" />
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Konfirmasi</label>
                            <input type="password" name="password_confirmation" required autocomplete="new-password"
                                class="w-full px-5 py-3 bg-gray-50/50 dark:bg-gray-800 border-none rounded-xl focus:ring-2 focus:ring-indigo-600 transition-all text-gray-900 dark:text-white" 
                                placeholder="••••••••">
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Role Akses</label>
                        <select name="role" id="role" required
                            class="w-full px-5 py-3 bg-gray-50/50 dark:bg-gray-800 border-none rounded-xl focus:ring-2 focus:ring-indigo-600 transition-all text-gray-900 dark:text-white appearance-none cursor-pointer">
                            <option value="" disabled selected>Pilih Role...</option>
                            <option value="A">ADMIN</option>
                            <option value="U">USER</option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-1" />
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 rounded-2xl shadow-lg shadow-indigo-200 dark:shadow-none transition-all active:scale-[0.98] uppercase tracking-widest text-xs">
                            Daftarkan Sekarang
                        </button>
                    </div>

                    <div class="text-center mt-4">
                        <a class="text-xs font-bold text-gray-500 hover:text-indigo-600 transition-colors uppercase tracking-tighter" href="{{ route('login') }}">
                            Sudah punya akun? <span class="underline">Login di sini</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>