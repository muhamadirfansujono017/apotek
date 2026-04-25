<nav x-data="{ open: false }" class="bg-indigo-700 text-white shadow-lg border-b border-indigo-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-white" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                        class="text-white hover:text-yellow-300 border-yellow-400 font-bold">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>

                @auth
                    @if(auth()->user()->can('role-A'))
                        <div class="hidden sm:flex sm:items-center sm:ms-4">
                            <x-dropdown align="left" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-bold rounded-xl text-indigo-700 bg-white hover:bg-indigo-50 transition shadow-sm">
                                        <i class="fas fa-database me-2"></i> Master
                                        <svg class="ms-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link :href="route('obat.index')">💊 Data Obat</x-dropdown-link>
                                    <x-dropdown-link :href="route('supplier.index')">🚚 Data Supplier</x-dropdown-link>
                                    <div class="border-t border-gray-100"></div>
                                    <x-dropdown-link :href="route('user.index')">👤 Manajemen User</x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ms-4">
                            <x-dropdown align="left" width="56">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-bold rounded-xl text-indigo-700 bg-white hover:bg-indigo-50 transition shadow-sm">
                                        <i class="fas fa-exchange-alt me-2"></i> Transaksi
                                        <svg class="ms-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <div class="px-4 py-2 text-xs text-gray-400 font-bold uppercase tracking-wider">Arus Barang</div>
                                    <x-dropdown-link :href="route('pembelian.index')">📥 Pembelian</x-dropdown-link>
                                    <x-dropdown-link :href="route('penjualan.index')">📤 penjualan</x-dropdown-link>
                                    <div class="border-t border-gray-100"></div>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @endif

                    @if(auth()->user()->can('role-A') || auth()->user()->can('role-U'))
                        <div class="hidden sm:flex sm:items-center sm:ms-4">
                            <x-dropdown align="left" width="56">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-bold rounded-xl text-indigo-700 bg-white hover:bg-indigo-50 transition shadow-sm">
                                        <i class="fas fa-chart-line me-2"></i> Laporan
                                        <svg class="ms-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link :href="route('stok_log.index')">📦 Stok & Kadaluarsa</x-dropdown-link>
                                    <x-dropdown-link :href="route('laporan.obat.index')">📈 Laporan obat</x-dropdown-link>
                                    <x-dropdown-link :href="route('laporan.masuk.index')">📈 Laporan Pembelian</x-dropdown-link>
                                    <x-dropdown-link :href="route('laporan.keluar.index')">📉 Laporan Penjualan</x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @endif
                @endauth
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-bold text-white hover:text-yellow-300 transition group">
                                <div class="bg-indigo-600 p-2 rounded-full me-2 group-hover:bg-indigo-500 transition">
                                    <i class="fas fa-user-circle text-lg"></i>
                                </div>
                                <span>{{ Auth::user()->name }}</span>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="px-4 py-2 text-xs text-gray-400">Manage Account</div>
                            <x-dropdown-link :href="route('profile.edit')">⚙️ Profile Settings</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600 font-bold">
                                    🚪 Sign Out
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endauth
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="p-2 rounded-lg text-white hover:bg-indigo-800 transition shadow-inner">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden bg-indigo-800 border-t border-indigo-900">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white">Dashboard</x-responsive-nav-link>
            @auth
                @if(auth()->user()->can('role-A'))
                    <div class="px-4 py-2 text-xs font-bold text-indigo-300 uppercase">Master & Transaksi</div>
                    <x-responsive-nav-link :href="route('obat.index')" class="text-white">💊 Data Obat</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('pembelian.index')" class="text-white">📥 Stok Masuk</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('penjualan.index')" class="text-white">📤 Penjualan</x-responsive-nav-link>
                @endif
            @endauth
        </div>
    </div>
</nav>