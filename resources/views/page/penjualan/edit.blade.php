<x-app-layout>
    <div class="py-12 max-w-5xl mx-auto px-4">
        <form action="{{ route('penjualan.update', $penjualan->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="bg-white dark:bg-gray-900 shadow-2xl rounded-[2.5rem] p-10">
                <h2 class="text-3xl font-black text-gray-800 dark:text-white mb-8">Edit Transaksi #{{ $penjualan->id }}</h2>
                
                <p class="text-red-500 font-bold">Fitur edit transaksi penjualan sangat berisiko terhadap sinkronisasi stok otomatis. Disarankan untuk menghapus transaksi dan membuat yang baru jika terjadi kesalahan input.</p>
                
                <div class="mt-8">
                    <a href="{{ route('penjualan.index') }}" class="bg-gray-800 text-white px-6 py-3 rounded-xl">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>