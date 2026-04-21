<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Manajemen Konsumen</h2>
    </x-slot>

    <div class="py-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Tombol Tambah & Flash Message --}}
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Daftar Konsumen</h3>
            <a href="{{ route('konsumen.create') }}"
               class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-xl shadow transition duration-200">
                + Tambah Konsumen
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded shadow">
                {{ session('success') }}
            </div>
        @endif

        {{-- Tabel Data --}}
        <div class="overflow-x-auto bg-white dark:bg-gray-900 shadow rounded-2xl">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-800 text-sm text-gray-800 dark:text-gray-300">
                <thead class="bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 uppercase text-xs font-semibold">
                    <tr>
                        <th class="px-6 py-4 text-left">#</th>
                        <th class="px-6 py-4 text-left">Nama Konsumen</th>
                        <th class="px-6 py-4 text-left">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($konsumen as $index => $item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition duration-200">
                            <td class="px-6 py-4">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 font-medium">{{ $item->nama }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-block px-3 py-1 text-xs font-medium rounded-full
                                    {{ $item->status === 'Aktif' 
                                        ? 'bg-green-100 text-green-700 dark:bg-green-700/20 dark:text-green-400' 
                                        : 'bg-red-100 text-red-700 dark:bg-red-700/20 dark:text-red-400' }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center space-x-2">
                                <a href="{{ route('konsumen.edit', $item->id) }}"
                                   class="bg-amber-500 hover:bg-amber-600 px-3 py-1 rounded-md text-xs text-white">
                                    ✏️ Edit
                                </a>
                                <form action="{{ route('konsumen.destroy', $item->id) }}" method="POST"
                                      class="inline-block"
                                      onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded-md text-xs text-white">
                                            🗑️ Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center px-6 py-6 italic text-gray-500 dark:text-gray-400">
                                Tidak ada data konsumen.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
