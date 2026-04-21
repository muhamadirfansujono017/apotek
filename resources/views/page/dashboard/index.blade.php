<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight flex items-center">
                <i class="fas fa-prescription-bottle-alt me-3 text-indigo-600"></i>
                {{ __('Dashboard Apotek Juju') }}
            </h2>
            <div class="text-sm text-gray-500 font-medium bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-100">
                <i class="far fa-calendar-alt me-1"></i> {{ date('d F Y') }}
            </div>
        </div>
    </x-slot>

    <div class="py-10 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition-all duration-300 group">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Total Jenis Obat</p>
                            <h3 class="text-4xl font-extrabold text-gray-800 dark:text-white mt-1">{{ $totalBarang }}</h3>
                        </div>
                        <div class="p-4 bg-indigo-50 text-indigo-600 rounded-xl group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                            <i class="fas fa-pills text-2xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm text-indigo-600 font-medium">
                        <span class="bg-indigo-100 px-2 py-0.5 rounded mr-2">Update</span>
                        <span>Stok inventaris aktif</span>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition-all duration-300 group">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Transaksi Masuk</p>
                            <h3 class="text-4xl font-extrabold text-gray-800 dark:text-white mt-1">{{ $totalStokMasuk }}</h3>
                        </div>
                        <div class="p-4 bg-emerald-50 text-emerald-600 rounded-xl group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
                            <i class="fas fa-truck-loading text-2xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm text-emerald-600 font-medium">
                        <span class="bg-emerald-100 px-2 py-0.5 rounded mr-2">Suplai</span>
                        <span>Total pengadaan barang</span>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition-all duration-300 group">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Penjualan Hari Ini</p>
                            <h3 class="text-4xl font-extrabold text-gray-800 dark:text-white mt-1">{{ $totalStokKeluar }}</h3>
                        </div>
                        <div class="p-4 bg-rose-50 text-rose-600 rounded-xl group-hover:bg-rose-600 group-hover:text-white transition-colors duration-300">
                            <i class="fas fa-shopping-cart text-2xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm text-rose-600 font-medium">
                        <span class="bg-rose-100 px-2 py-0.5 rounded mr-2">Live</span>
                        <span>Data transaksi hari ini</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white">Obat Terlaris</h3>
                        <i class="fas fa-chart-bar text-gray-400"></i>
                    </div>
                    <div class="relative" style="height: 320px;">
                        <canvas id="topItemsChart"></canvas>
                    </div>
                </div>

                <div class="lg:col-span-3 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white">Tren Aktivitas (7 Hari Terakhir)</h3>
                        <div class="flex space-x-4 text-xs font-semibold uppercase tracking-tighter">
                            <span class="flex items-center text-emerald-600"><div class="w-3 h-3 bg-emerald-500 rounded-full me-1"></div> Masuk</span>
                            <span class="flex items-center text-rose-600"><div class="w-3 h-3 bg-rose-500 rounded-full me-1"></div> Keluar</span>
                        </div>
                    </div>
                    <div class="relative" style="height: 320px;">
                        <canvas id="weeklyChart"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Chart.defaults.font.family = 'Figtree, ui-sans-serif, system-ui';
                
                // 1. Bar Chart: Obat Terlaris
                const topItemsCtx = document.getElementById('topItemsChart').getContext('2d');
                new Chart(topItemsCtx, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($topItems->pluck('nama_barang')) !!},
                        datasets: [{
                            data: {!! json_encode($topItems->pluck('total')) !!},
                            backgroundColor: '#6366f1',
                            hoverBackgroundColor: '#4f46e5',
                            borderRadius: 10,
                            barThickness: 25,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { beginAtZero: true, grid: { borderDash: [5, 5], color: '#f3f4f6' } },
                            x: { grid: { display: false } }
                        }
                    }
                });

                // 2. Line Chart: Tren Mingguan
                const weeklyCtx = document.getElementById('weeklyChart').getContext('2d');
                const gradientMasuk = weeklyCtx.createLinearGradient(0, 0, 0, 400);
                gradientMasuk.addColorStop(0, 'rgba(16, 185, 129, 0.2)');
                gradientMasuk.addColorStop(1, 'rgba(16, 185, 129, 0)');

                const gradientKeluar = weeklyCtx.createLinearGradient(0, 0, 0, 400);
                gradientKeluar.addColorStop(0, 'rgba(244, 63, 94, 0.2)');
                gradientKeluar.addColorStop(1, 'rgba(244, 63, 94, 0)');

                new Chart(weeklyCtx, {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($weekDays) !!},
                        datasets: [
                            {
                                label: 'Obat Masuk',
                                data: {!! json_encode($stokMasukPerHari) !!},
                                borderColor: '#10b981',
                                backgroundColor: gradientMasuk,
                                fill: true,
                                tension: 0.4,
                                pointRadius: 4,
                                pointBackgroundColor: '#fff',
                                pointBorderWidth: 2,
                                borderWidth: 3
                            },
                            {
                                label: 'Obat Keluar',
                                data: {!! json_encode($stokKeluarPerHari) !!},
                                borderColor: '#f43f5e',
                                backgroundColor: gradientKeluar,
                                fill: true,
                                tension: 0.4,
                                pointRadius: 4,
                                pointBackgroundColor: '#fff',
                                pointBorderWidth: 2,
                                borderWidth: 3
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { beginAtZero: true, grid: { color: '#f3f4f6' } },
                            x: { grid: { display: false } }
                        }
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>