<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">Data Pengguna</h2>
    </x-slot>

    <div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header dan Tombol Tambah -->
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Daftar Pengguna</h3>
            <a href="{{ route('user.create') }}"
               class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-500 text-white text-sm font-medium rounded-lg shadow transition"
               title="Tambah Pengguna Baru">
                + Tambah User
            </a>
        </div>

        <!-- Notifikasi -->
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg shadow border border-green-300 dark:bg-green-200 dark:text-green-900">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabel Data -->
        <div class="overflow-x-auto bg-white dark:bg-gray-900 shadow rounded-lg">
            <table class="min-w-full table-auto divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                <thead class="bg-gray-100 dark:bg-gray-800">
                    <tr>
                        <th class="px-6 py-3 text-left font-bold text-gray-700 dark:text-gray-200 uppercase">No</th>
                        <th class="px-6 py-3 text-left font-bold text-gray-700 dark:text-gray-200 uppercase">Nama</th>
                        <th class="px-6 py-3 text-left font-bold text-gray-700 dark:text-gray-200 uppercase">Email</th>
                        <th class="px-6 py-3 text-left font-bold text-gray-700 dark:text-gray-200 uppercase">Role</th>
                        <th class="px-6 py-3 text-center font-bold text-gray-700 dark:text-gray-200 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                            <td class="px-6 py-4 text-gray-800 dark:text-gray-100">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 text-gray-800 dark:text-gray-100">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-gray-800 dark:text-gray-100">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $role = strtolower($user->role);
                                @endphp
                                @if($role === 'admin' || $role === 'a')
                                    <span class="inline-block bg-red-100 text-red-800 px-2 py-1 rounded text-xs font-semibold dark:bg-red-200">
                                        Admin
                                    </span>
                                @elseif($role === 'user' || $role === 'u')
                                    <span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-semibold dark:bg-blue-200">
                                        User
                                    </span>
                                @else
                                    <span class="inline-block text-gray-400 italic text-xs">Tidak Diketahui</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('user.edit', $user->id) }}"
                                       class="px-3 py-1 bg-yellow-500 hover:bg-yellow-400 text-white rounded-lg shadow text-xs font-medium transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-1 bg-red-600 hover:bg-red-500 text-white rounded-lg shadow text-xs font-medium transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center px-6 py-4 text-gray-500 dark:text-gray-400 italic">
                                Belum ada data pengguna.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
