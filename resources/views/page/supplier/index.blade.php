<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white leading-tight flex items-center">
                <i class="fas fa-truck-moving me-3 text-indigo-600"></i>
                {{ __('Data Supplier') }}
            </h2>
            <a href="{{ route('supplier.create') }}"
                class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg shadow-indigo-100 transition-all duration-200 transform hover:-translate-y-0.5">
                <i class="fas fa-plus-circle me-2"></i>
                Tambah Supplier
            </a>
        </div>
    </x-slot>

    <div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Flash Message Mewah --}}
        @if (session('success'))
            <div
                class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-r-xl shadow-sm flex items-center">
                <i class="fas fa-check-circle me-3 text-emerald-500 text-xl"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Table Card --}}
        <div
            class="bg-white dark:bg-gray-800 shadow-sm rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-50 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white">Daftar Rekanan</h3>
                <p class="text-sm text-gray-500">Kelola informasi seluruh penyedia stok obat Apotek Irfan.</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600 dark:text-gray-300">
                    <thead
                        class="bg-gray-50 dark:bg-gray-700/50 text-xs uppercase font-bold text-gray-500 dark:text-gray-300">
                        <tr>
                            <th class="px-6 py-4 text-center">No</th>
                            <th class="px-6 py-4">Nama Supplier</th>
                            <th class="px-6 py-4">Kontak (HP)</th>
                            <th class="px-6 py-4">Alamat</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse($supplier as $index => $item)
                            <tr class="hover:bg-gray-50/80 dark:hover:bg-gray-800 transition-colors">
                                {{-- Gunakan pagination friendly numbering --}}
                                <td class="px-6 py-4 text-center font-medium">
                                    {{ $supplier instanceof \Illuminate\Pagination\LengthAwarePaginator ? $supplier->firstItem() + $index : $loop->iteration }}
                                </td>
                                <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">
                                    {{ $item->nama_supplier }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $item->no_telp }}
                                </td>
                                <td class="px-6 py-4 max-w-xs truncate">
                                    {{ $item->alamat }}
                                </td>
                                <td class="px-6 py-4 text-center space-x-2 whitespace-nowrap">
                                    <a href="{{ route('supplier.edit', $item->id) }}"
                                        class="inline-flex items-center bg-amber-50 text-amber-600 border border-amber-200 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-amber-500 hover:text-white transition-all duration-200">
                                        <i class="fas fa-edit me-1"></i> Edit
                                    </a>
                                    <form action="{{ route('supplier.destroy', $item->id) }}" method="POST"
                                        class="inline"
                                        onsubmit="return confirm('Hapus supplier {{ $item->nama_supplier }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center bg-rose-50 text-rose-600 border border-rose-200 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-rose-500 hover:text-white transition-all duration-200">
                                            <i class="fas fa-trash-alt me-1"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center px-6 py-12 text-gray-400">
                                    <i class="fas fa-box-open text-4xl mb-3 block"></i>
                                    <span class="italic">Belum ada data supplier yang terdaftar.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($supplier instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="p-6 bg-gray-50 border-t border-gray-100 dark:bg-gray-800/50">
                    {{ $supplier->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
