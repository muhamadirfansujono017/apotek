<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-gray-800 dark:text-white flex items-center">
            <i class="fas fa-history text-indigo-600 me-3"></i> Histori Transaksi Apotek
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" x-data="{ tab: 'penjualan' }">
        
        <div class="flex space-x-4 mb-8 bg-gray-100 dark:bg-gray-800 p-1.5 rounded-2xl w-fit">
            <button @click="tab = 'penjualan'" 
                :class="tab === 'penjualan' ? 'bg-white dark:bg-gray-700 shadow-sm text-indigo-600' : 'text-gray-500 hover:text-gray-700'"
                class="px-6 py-2.5 rounded-xl text-sm font-black uppercase tracking-wider transition-all">
                Penjualan (Keluar)
            </button>
            <button @click="tab = 'pembelian'" 
                :class="tab === 'pembelian' ? 'bg-white dark:bg-gray-700 shadow-sm text-emerald-600' : 'text-gray-500 hover:text-gray-700'"
                class="px-6 py-2.5 rounded-xl text-sm font-black uppercase tracking-wider transition-all">
                Pembelian (Masuk)
            </button>
        </div>

        <div x-show="tab === 'penjualan'" x-transition>
            <div class="bg-white dark:bg-gray-800 shadow-2xl rounded-3xl overflow-hidden border border-gray-100 dark:border-gray-700">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-50 dark:bg-gray-700 text-gray-400">
                        <tr>
                            <th class="px-6 py-4 font-black uppercase text-xs">ID TRX</th>
                            <th class="px-6 py-4 font-black uppercase text-xs">Tanggal</th>
                            <th class="px-6 py-4 font-black uppercase text-xs">Kasir</th>
                            <th class="px-6 py-4 font-black uppercase text-xs text-right">Total</th>
                            <th class="px-6 py-4 font-black uppercase text-xs text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-600">
                        @foreach($penjualan as $pj)
                        <tr class="hover:bg-orange-50/30 transition">
                            <td class="px-6 py-4 font-bold text-indigo-600">#PJL-{{ $pj->id }}</td>
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($pj->tanggal)->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 font-medium">{{ $pj->user->name }}</td>
                            <td class="px-6 py-4 text-right font-black text-gray-900 dark:text-white">
                                Rp {{ number_format($pj->total, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('transaksi.show', $pj->id) }}" class="text-indigo-500 hover:text-indigo-700">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-6">{{ $penjualan->links() }}</div>
            </div>
        </div>

        <div x-show="tab === 'pembelian'" x-transition>
            <div class="bg-white dark:bg-gray-800 shadow-2xl rounded-3xl overflow-hidden border border-gray-100 dark:border-gray-700">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-gray-50 dark:bg-gray-700 text-gray-400">
                        <tr>
                            <th class="px-6 py-4 font-black uppercase text-xs">ID TRX</th>
                            <th class="px-6 py-4 font-black uppercase text-xs">Tanggal</th>
                            <th class="px-6 py-4 font-black uppercase text-xs">Supplier</th>
                            <th class="px-6 py-4 font-black uppercase text-xs text-right">Total</th>
                            <th class="px-6 py-4 font-black uppercase text-xs text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-600">
                        @foreach($pembelian as $pb)
                        <tr class="hover:bg-emerald-50/30 transition">
                            <td class="px-6 py-4 font-bold text-emerald-600">#PBL-{{ $pb->id }}</td>
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($pb->tanggal)->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 font-medium">{{ $pb->supplier->nama_supplier }}</td>
                            <td class="px-6 py-4 text-right font-black text-gray-900 dark:text-white">
                                Rp {{ number_format($pb->total, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="#" class="text-emerald-500 hover:text-emerald-700">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-6">{{ $pembelian->links() }}</div>
            </div>
        </div>

    </div>
</x-app-layout>