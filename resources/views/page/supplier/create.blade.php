<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('supplier.index') }}" class="text-gray-400 hover:text-indigo-600 transition">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight">
                {{ __('Tambah Rekanan Supplier') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-2xl border border-gray-100 dark:border-gray-700">
                <div class="p-6 border-b border-gray-50 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white flex items-center">
                        <i class="fas fa-file-signature me-3 text-indigo-600"></i>
                        Informasi Supplier Baru
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">Lengkapi detail di bawah ini untuk mendaftarkan supplier baru.</p>
                </div>

                <form action="{{ route('supplier.store') }}" method="POST" class="p-8 space-y-6">
                    @csrf

                    <div>
                        <label for="nama_supplier" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                            Nama Perusahaan / Supplier <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-building text-gray-400"></i>
                            </div>
                            <input type="text" name="nama_supplier" id="nama_supplier" 
                                value="{{ old('nama_supplier') }}" required
                                class="block w-full pl-10 rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition-all"
                                placeholder="Contoh: PT. Kimia Farma">
                        </div>
                        @error('nama_supplier')
                            <p class="text-rose-600 text-xs mt-2 font-medium"><i class="fas fa-exclamation-circle me-1"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="no_telp" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                                No. WhatsApp / HP
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-phone-alt text-gray-400"></i>
                                </div>
                                <input type="text" name="no_telp" id="no_telp" 
                                    value="{{ old('no_telp') }}"
                                    class="block w-full pl-10 rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition-all"
                                    placeholder="0812xxxx">
                            </div>
                            @error('no_telp')
                                <p class="text-rose-600 text-xs mt-2 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="alamat" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2 text-indigo-600">
                            Alamat Kantor
                        </label>
                        <textarea name="alamat" id="alamat" rows="3" 
                            class="block w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition-all"
                            placeholder="Jl. Raya No. 123, Kota...">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <p class="text-rose-600 text-xs mt-2 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-50 dark:border-gray-700">
                        <a href="{{ route('supplier.index') }}" 
                            class="px-6 py-2.5 text-sm font-bold text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-all duration-200">
                            Batal
                        </a>
                        <button type="submit" 
                            class="px-6 py-2.5 text-sm font-bold text-white bg-indigo-600 rounded-xl shadow-lg shadow-indigo-100 hover:bg-indigo-700 hover:shadow-indigo-200 transition-all duration-200 transform hover:-translate-y-0.5">
                            <i class="fas fa-save me-2"></i> Simpan Supplier
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>