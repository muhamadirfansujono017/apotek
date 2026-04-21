<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('obat.index') }}" class="text-gray-400 hover:text-indigo-600 transition"><i class="fas fa-arrow-left text-xl"></i></a>
            <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight">{{ __('Input Data Obat') }}</h2>
        </div>
    </x-slot>

    <div class="py-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-2xl rounded-3xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            <form action="{{ route('obat.store') }}" method="POST" class="p-8 space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Kode Obat</label>
                            <input type="text" name="kode_obat" value="{{ $latestKodeObat }}" readonly class="block w-full rounded-2xl border-gray-200 bg-gray-50 text-indigo-500 font-bold shadow-inner">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nama Obat</label>
                            <input type="text" name="nama_obat" required class="block w-full rounded-2xl border-gray-200 focus:ring-indigo-500 focus:border-indigo-500 transition-all shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Kategori</label>
                            <select name="kategori" required class="block w-full rounded-2xl border-gray-200 focus:ring-indigo-500 transition-all shadow-sm">
                                <option value="Tablet">Tablet</option>
                                <option value="Sirup">Sirup</option>
                                <option value="Kapsul">Kapsul</option>
                                <option value="Injeksi">Injeksi</option>
                                <option value="Salep">Salep</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Satuan</label>
                            <select name="satuan" required class="block w-full rounded-2xl border-gray-200 focus:ring-indigo-500 transition-all shadow-sm">
                                <option value="Botol">Botol</option>
                                <option value="Strip">Strip</option>
                                <option value="Pcs">Pcs</option>
                                <option value="Tube">Tube</option>
                                <option value="Ampul">Ampul</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Harga Beli</label>
                                <input type="number" name="harga_beli" required class="block w-full rounded-2xl border-gray-200 focus:ring-indigo-500 shadow-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2 text-indigo-600">Harga Jual</label>
                                <input type="number" name="harga_jual" required class="block w-full rounded-2xl border-gray-200 focus:ring-indigo-600 shadow-sm font-bold">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Stok</label>
                            <input type="number" name="stok" required class="block w-full rounded-2xl border-gray-200 focus:ring-indigo-500 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 text-rose-500">Expired Date</label>
                            <input type="date" name="expired" required class="block w-full rounded-2xl border-gray-200 focus:ring-rose-500 shadow-sm">
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-4 pt-8 border-t border-gray-50">
                    <a href="{{ route('obat.index') }}" class="px-6 py-3 text-sm font-bold text-gray-500">Batal</a>
                    <button type="submit" class="px-10 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-xl hover:bg-indigo-700 transition-all transform hover:-translate-y-1">
                        <i class="fas fa-save me-2"></i> Simpan Data Obat
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>