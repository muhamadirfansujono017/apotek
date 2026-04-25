<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-white flex items-center">
                <i class="fas fa-truck-loading text-indigo-600 me-3"></i> Tabel Pembelian
            </h2>
            <a href="{{ route('pembelian.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-2xl text-sm font-bold shadow-lg shadow-indigo-100 transition transform active:scale-95">
                <i class="fas fa-plus me-2"></i> Tambah Stok
            </a>
        </div>
    </x-slot>

    <div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Alert Notifikasi --}}
        @if (session('success'))
            <div class="mb-6 p-4 bg-indigo-50 border-l-4 border-indigo-500 text-indigo-700 rounded-r-xl shadow-sm flex items-center">
                <i class="fas fa-check-circle me-3 text-lg"></i>
                <span class="font-bold">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-900 shadow-2xl rounded-3xl overflow-hidden border border-gray-100 dark:border-gray-800">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-gray-800/50">
                            <th class="px-6 py-5 text-xs font-black text-gray-400 uppercase tracking-widest border-b border-gray-100 dark:border-gray-700">No</th>
                            <th class="px-6 py-5 text-xs font-black text-gray-400 uppercase tracking-widest border-b border-gray-100 dark:border-gray-700">Info Transaksi</th>
                            <th class="px-6 py-5 text-xs font-black text-gray-400 uppercase tracking-widest border-b border-gray-100 dark:border-gray-700">Supplier</th>
                            <th class="px-6 py-5 text-xs font-black text-gray-400 uppercase tracking-widest border-b border-gray-100 dark:border-gray-700">Total Biaya</th>
                            <th class="px-6 py-5 text-xs font-black text-gray-400 uppercase tracking-widest border-b border-gray-100 dark:border-gray-700 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                        @forelse ($pembelian as $key => $item)
                            <tr class="hover:bg-indigo-50/30 dark:hover:bg-gray-800/50 transition">
                                <td class="px-6 py-4 text-sm font-medium text-gray-500">
                                    {{ $pembelian->firstItem() + $key }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-800 dark:text-white">
                                        {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                                    </div>
                                    <div class="text-[10px] text-indigo-500 font-black uppercase tracking-tighter">
                                        ID: #BY-{{ str_pad($item->id, 5, '0', STR_PAD_LEFT) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 mr-3 text-xs font-bold">
                                            {{ substr($item->supplier->nama_supplier, 0, 1) }}
                                        </div>
                                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                            {{ $item->supplier->nama_supplier }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-black text-gray-900 dark:text-white">
                                        Rp {{ number_format($item->total, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center items-center space-x-2">
                                        {{-- Detail --}}
                                        <a href="{{ route('pembelian.show', $item->id) }}" class="p-2 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white rounded-xl transition-all shadow-sm" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        {{-- Edit --}}
                                        <a href="{{ route('pembelian.edit', $item->id) }}" class="p-2 bg-amber-50 text-amber-600 hover:bg-amber-600 hover:text-white rounded-xl transition-all shadow-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('pembelian.destroy', $item->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white rounded-xl transition-all shadow-sm" title="Hapus" onclick="return confirm('Hapus data ini? Stok obat akan dikurangi kembali secara otomatis.')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                            <i class="fas fa-box-open text-gray-200 text-4xl"></i>
                                        </div>
                                        <p class="text-gray-400 font-medium italic">Belum ada data pembelian stok.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($pembelian->hasPages())
                <div class="px-6 py-5 bg-gray-50 dark:bg-gray-800/30 border-t border-gray-100 dark:border-gray-700">
                    {{ $pembelian->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>