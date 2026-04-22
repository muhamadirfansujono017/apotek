<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-black text-2xl text-gray-800 dark:text-white flex items-center uppercase italic tracking-tighter">
                <i class="fas fa-history text-indigo-600 me-3 animate-pulse"></i> Histori Transaksi <span class="text-indigo-600 ml-2">Apotek JUJU</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" x-data="{ tab: 'penjualan' }">
        
        <div class="flex space-x-2 mb-8 bg-white dark:bg-gray-800 p-2 rounded-[2rem] w-fit shadow-xl shadow-indigo-100/50 dark:shadow-none border border-gray-100 dark:border-gray-700">
            <button @click="tab = 'penjualan'" 
                :class="tab === 'penjualan' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'text-gray-400 hover:bg-gray-50'"
                class="px-8 py-3 rounded-[1.5rem] text-xs font-black uppercase tracking-widest transition-all duration-300">
                <i class="fas fa-shopping-cart me-2"></i> Penjualan
            </button>
            <button @click="tab = 'pembelian'" 
                :class="tab === 'pembelian' ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-200' : 'text-gray-400 hover:bg-gray-50'"
                class="px-8 py-3 rounded-[1.5rem] text-xs font-black uppercase tracking-widest transition-all duration-300">
                <i class="fas fa-truck-loading me-2"></i> Pembelian
            </button>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 rounded-2xl font-bold text-sm shadow-sm">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif

        <div x-show="tab === 'penjualan'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95">
            <div class="bg-white dark:bg-gray-900 shadow-2xl rounded-[2.5rem] overflow-hidden border border-white dark:border-gray-800">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-50/50 dark:bg-gray-800 text-gray-400">
                        <tr>
                            <th class="px-8 py-5 font-black uppercase text-[10px] tracking-widest">No. Faktur</th>
                            <th class="px-8 py-5 font-black uppercase text-[10px] tracking-widest text-center">Tanggal</th>
                            <th class="px-8 py-5 font-black uppercase text-[10px] tracking-widest">Kasir</th>
                            <th class="px-8 py-5 font-black uppercase text-[10px] tracking-widest text-right">Total Transaksi</th>
                            <th class="px-8 py-5 font-black uppercase text-[10px] tracking-widest text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @foreach($penjualan as $pj)
                        <tr class="hover:bg-indigo-50/30 dark:hover:bg-indigo-900/10 transition group">
                            <td class="px-8 py-6 font-black text-indigo-600 italic">#PJL-{{ $pj->id }}</td>
                            <td class="px-8 py-6 text-center font-bold text-gray-500">{{ \Carbon\Carbon::parse($pj->tanggal)->format('d/m/Y') }}</td>
                            <td class="px-8 py-6 font-black text-gray-900 dark:text-white uppercase tracking-tighter">{{ $pj->user->name }}</td>
                            <td class="px-8 py-6 text-right font-black text-xl text-gray-900 dark:text-white tracking-tighter">
                                Rp {{ number_format($pj->total, 0, ',', '.') }}
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('penjualan.show', $pj->id) }}" class="h-10 w-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                                        <i class="fas fa-eye text-xs"></i>
                                    </a>
                                    <a href="{{ route('penjualan.edit', $pj->id) }}" class="h-10 w-10 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center hover:bg-amber-600 hover:text-white transition-all shadow-sm">
                                        <i class="fas fa-edit text-xs"></i>
                                    </a>
                                    <form action="{{ route('penjualan.destroy', $pj->id) }}" method="POST" onsubmit="return confirm('Hapus transaksi? Stok akan dikembalikan.')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="h-10 w-10 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center hover:bg-rose-600 hover:text-white transition-all shadow-sm">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-8 bg-gray-50/50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-800">
                    {{ $penjualan->links() }}
                </div>
            </div>
        </div>

        <div x-show="tab === 'pembelian'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95">
            <div class="bg-white dark:bg-gray-900 shadow-2xl rounded-[2.5rem] overflow-hidden border border-white dark:border-gray-800">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-50/50 dark:bg-gray-800 text-gray-400">
                        <tr>
                            <th class="px-8 py-5 font-black uppercase text-[10px] tracking-widest">No. Faktur</th>
                            <th class="px-8 py-5 font-black uppercase text-[10px] tracking-widest text-center">Tanggal</th>
                            <th class="px-8 py-5 font-black uppercase text-[10px] tracking-widest">Supplier</th>
                            <th class="px-8 py-5 font-black uppercase text-[10px] tracking-widest text-right">Total Pembelian</th>
                            <th class="px-8 py-5 font-black uppercase text-[10px] tracking-widest text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @foreach($pembelian as $pb)
                        <tr class="hover:bg-emerald-50/30 dark:hover:bg-emerald-900/10 transition group">
                            <td class="px-8 py-6 font-black text-emerald-600 italic">#PBL-{{ $pb->id }}</td>
                            <td class="px-8 py-6 text-center font-bold text-gray-500 italic">{{ \Carbon\Carbon::parse($pb->tanggal)->format('d/m/Y') }}</td>
                            <td class="px-8 py-6 font-black text-gray-900 dark:text-white uppercase tracking-tighter">
                                <i class="fas fa-building text-emerald-500 mr-2"></i> {{ $pb->supplier->nama_supplier }}
                            </td>
                            <td class="px-8 py-6 text-right font-black text-xl text-gray-900 dark:text-white tracking-tighter">
                                Rp {{ number_format($pb->total, 0, ',', '.') }}
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('pembelian.show', $pb->id) }}" class="h-10 w-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center hover:bg-emerald-600 hover:text-white transition-all shadow-sm">
                                        <i class="fas fa-eye text-xs"></i>
                                    </a>
                                    <a href="{{ route('pembelian.edit', $pb->id) }}" class="h-10 w-10 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center hover:bg-amber-600 hover:text-white transition-all shadow-sm">
                                        <i class="fas fa-edit text-xs"></i>
                                    </a>
                                    <form action="{{ route('pembelian.destroy', $pb->id) }}" method="POST" onsubmit="return confirm('Hapus pembelian? Stok akan dikurangi.')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="h-10 w-10 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center hover:bg-rose-600 hover:text-white transition-all shadow-sm">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-8 bg-gray-50/50 dark:bg-gray-800/50 border-t border-gray-100 dark:border-gray-800">
                    {{ $pembelian->links() }}
                </div>
            </div>
        </div>

    </div>
</x-app-layout>