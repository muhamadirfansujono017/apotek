<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-50 via-white to-cyan-50 dark:from-gray-950 dark:via-gray-900 dark:to-indigo-950 px-4">
        <div class="w-full max-w-md">
            
            <div class="text-center mb-10">
                <div class="inline-flex p-5 rounded-[2rem] bg-indigo-600 shadow-2xl shadow-indigo-200 dark:shadow-none mb-6">
                    <i class="fas fa-mortar-pestle text-4xl text-white"></i>
                </div>
                <h1 class="text-4xl font-black text-gray-900 dark:text-white tracking-tighter uppercase italic">
                    Apotek <span class="text-indigo-600">JUJU</span>
                </h1>
                <p class="text-gray-500 dark:text-gray-400 mt-3 font-semibold tracking-wide">Sistem Informasi Penjualan Obat</p>
            </div>

            <div class="bg-white/70 dark:bg-gray-900/80 backdrop-blur-2xl p-10 rounded-[3rem] shadow-2xl border border-white dark:border-gray-800">
                
                <x-auth-session-status class="mb-6" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-7">
                    @csrf

                    <div>
                        <label class="block text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-3 ml-1">Email Address</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                                class="w-full pl-12 pr-5 py-4 bg-gray-50/50 dark:bg-gray-800 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 transition-all text-gray-900 dark:text-white placeholder-gray-400" 
                                placeholder="Masukkan email anda...">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-3 ml-1">
                            <label class="text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Password</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-[10px] font-black text-indigo-600 uppercase hover:underline">Lupa?</a>
                            @endif
                        </div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" name="password" required autocomplete="current-password"
                                class="w-full pl-12 pr-5 py-4 bg-gray-50/50 dark:bg-gray-800 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 transition-all text-gray-900 dark:text-white placeholder-gray-400" 
                                placeholder="••••••••">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center ml-1">
                        <input id="remember_me" type="checkbox" name="remember" 
                            class="w-5 h-5 rounded-lg border-gray-200 text-indigo-600 focus:ring-indigo-500 transition cursor-pointer">
                        <span class="ms-3 text-sm text-gray-500 font-bold tracking-tight select-none cursor-pointer">{{ __('Remember me') }}</span>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-5 rounded-[1.5rem] shadow-xl shadow-indigo-200 dark:shadow-none transition-all active:scale-[0.97] uppercase tracking-[0.15em] text-sm">
                            Masuk Ke Sistem
                        </button>
                    </div>
                </form>
            </div>

            <p class="text-center mt-10 text-xs font-bold text-gray-400 uppercase tracking-widest">
                &copy; 2026 Politeknik LP3I Tasikmalaya
            </p>
        </div>
    </div>
</x-guest-layout>