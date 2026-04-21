<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-gray-800 dark:text-white uppercase tracking-tighter">
                <i class="fas fa-shopping-cart text-indigo-600 me-2"></i> Transaksi Penjualan
            </h2>
            <a href="{{ route('penjualan.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-xl font-bold text-sm shadow-lg transition">
                + Transaksi Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12 px-4 max-w-7xl mx-auto">
        <div class="bg-white dark:bg-gray-900 shadow-xl rounded-[2rem] overflow-hidden border border-gray-100 dark:border-gray-800">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 dark:bg-gray-800/50">
                    <tr>
                        <th class="p-5 text-xs font-black text-gray-400 uppercase">ID PJL</th>
                        <th class="p-5 text-xs font-black text-gray-400 uppercase">Tanggal</th>
                        <th class="p-5 text-xs font-black text-gray-400 uppercase text-right">Total</th>
                        <th class="p-5 text-xs font-black text-gray-400 uppercase text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach($penjualan as $p)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                        <td class="p-5 font-bold text-indigo-600">#PJL-{{ str_pad($p->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td class="p-5 text-gray-600 dark:text-gray-300">{{ \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') }}</td>
                        <td class="p-5 text-right font-black text-gray-800 dark:text-white">Rp {{ number_format($p->total, 0, ',', '.') }}</td>
                        <td class="p-5 text-center flex justify-center gap-2">
                            <a href="{{ route('penjualan.show', $p->id) }}" class="p-2 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="{{ route('penjualan.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus transaksi ini?')">
                                @csrf @method('DELETE')
                                <button class="p-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-5 bg-gray-50 dark:bg-gray-800/30">
                {{ $penjualan->links() }}
            </div>
        </div>
    </div>
</x-app-layout>