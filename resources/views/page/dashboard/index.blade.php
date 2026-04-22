<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-black text-3xl text-gray-900 dark:text-white leading-tight tracking-tighter uppercase italic">
                    <i class="fas fa-chart-pie me-3 text-indigo-600 animate-pulse"></i>
                    Apotek <span class="text-indigo-600">JUJU</span> Center
                </h2>
                <p class="text-gray-500 dark:text-gray-400 font-medium text-sm mt-1">Pantau performa apotek dalam satu dashboard pintar.</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="hidden sm:flex flex-col text-right">
                    <span class="text-xs font-black text-gray-400 uppercase tracking-widest">Hari Ini</span>
                    <span class="text-sm font-bold text-gray-800 dark:text-white">{{ date('d F Y') }}</span>
                </div>
                <div class="h-12 w-12 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-center text-indigo-600 shadow-indigo-100">
                    <i class="far fa-calendar-alt text-xl"></i>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-[#f8fafc] dark:bg-gray-950 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white dark:bg-gray-900 p-8 rounded-[2.5rem] shadow-xl shadow-gray-200/50 dark:shadow-none border border-white dark:border-gray-800 group hover:scale-[1.02] transition-all duration-300">
                    <div class="flex flex-col h-full justify-between">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-4 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 rounded-2xl group-hover:rotate-12 transition-transform">
                                <i class="fas fa-pills text-2xl"></i>
                            </div>
                            <span class="text-[10px] font-black bg-indigo-100 text-indigo-600 px-3 py-1 rounded-full uppercase">Katalog</span>
                        </div>
                        <div>
                            <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Total Jenis Obat</p>
                            <h3 class="text-4xl font-black text-gray-900 dark:text-white">{{ $totalBarang }}</h3>
                        </div>
                    </div>
                </div>

                <div class="bg-indigo-600 p-8 rounded-[2.5rem] shadow-xl shadow-indigo-200 dark:shadow-none text-white group hover:scale-[1.02] transition-all duration-300">
                    <div class="flex flex-col h-full justify-between">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-4 bg-white/20 text-white rounded-2xl">
                                <i class="fas fa-truck-moving text-2xl"></i>
                            </div>
                            <span class="text-[10px] font-black bg-white/20 text-white px-3 py-1 rounded-full uppercase">Restock</span>
                        </div>
                        <div>
                            <p class="text-xs font-black text-indigo-100 uppercase tracking-widest mb-1">Obat Masuk</p>
                            <h3 class="text-4xl font-black">{{ $totalStokMasuk }}</h3>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-900 p-8 rounded-[2.5rem] shadow-xl shadow-gray-200/50 dark:shadow-none border border-white dark:border-gray-800 group hover:scale-[1.02] transition-all duration-300">
                    <div class="flex flex-col h-full justify-between">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-4 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 rounded-2xl">
                                <i class="fas fa-shopping-bag text-2xl"></i>
                            </div>
                            <span class="text-[10px] font-black bg-emerald-100 text-emerald-600 px-3 py-1 rounded-full uppercase">Sales</span>
                        </div>
                        <div>
                            <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Penjualan Hari Ini</p>
                            <h3 class="text-4xl font-black text-gray-900 dark:text-white">{{ $totalStokKeluar }}</h3>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-900 dark:bg-indigo-900 p-8 rounded-[2.5rem] shadow-xl text-white flex flex-col items-center justify-center text-center group hover:bg-indigo-700 transition-all">
                    <p class="text-xs font-black text-indigo-300 uppercase tracking-widest mb-4">Aksi Cepat</p>
                    <a href="{{ route('penjualan.create') }}" class="bg-white text-gray-900 px-6 py-3 rounded-2xl font-black text-sm uppercase tracking-tighter hover:scale-110 transition-transform">
                        <i class="fas fa-plus me-2"></i> Transaksi Baru
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="bg-white dark:bg-gray-900 rounded-[3rem] shadow-xl shadow-gray-200/50 dark:shadow-none border border-white dark:border-gray-800 p-10">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-xl font-black text-gray-900 dark:text-white uppercase italic tracking-tighter">Obat Terlaris</h3>
                        <div class="h-10 w-10 bg-gray-50 dark:bg-gray-800 rounded-xl flex items-center justify-center">
                            <i class="fas fa-fire text-orange-500"></i>
                        </div>
                    </div>
                    <div class="relative" style="height: 300px;">
                        <canvas id="topItemsChart"></canvas>
                    </div>
                </div>

                <div class="lg:col-span-2 bg-white dark:bg-gray-900 rounded-[3rem] shadow-xl shadow-gray-200/50 dark:shadow-none border border-white dark:border-gray-800 p-10">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-xl font-black text-gray-900 dark:text-white uppercase italic tracking-tighter">Analisis Tren Mingguan</h3>
                            <p class="text-xs font-bold text-gray-400 uppercase mt-1">Perbandingan stok masuk & keluar</p>
                        </div>
                        <div class="flex gap-2">
                            <span class="flex items-center gap-2 text-[10px] font-black uppercase bg-emerald-50 text-emerald-600 px-3 py-1 rounded-lg italic">● Masuk</span>
                            <span class="flex items-center gap-2 text-[10px] font-black uppercase bg-rose-50 text-rose-600 px-3 py-1 rounded-lg italic">● Keluar</span>
                        </div>
                    </div>
                    <div class="relative" style="height: 300px;">
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
                Chart.defaults.color = '#94a3b8';
                
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
                            borderRadius: 15,
                            barThickness: 20,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { display: false, beginAtZero: true },
                            x: { grid: { display: false }, ticks: { font: { weight: 'bold' } } }
                        }
                    }
                });

                // 2. Line Chart: Tren Mingguan
                const weeklyCtx = document.getElementById('weeklyChart').getContext('2d');
                
                const createGradient = (color) => {
                    const gradient = weeklyCtx.createLinearGradient(0, 0, 0, 300);
                    gradient.addColorStop(0, `${color}33`);
                    gradient.addColorStop(1, `${color}00`);
                    return gradient;
                };

                new Chart(weeklyCtx, {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($weekDays) !!},
                        datasets: [
                            {
                                label: 'Masuk',
                                data: {!! json_encode($stokMasukPerHari) !!},
                                borderColor: '#10b981',
                                backgroundColor: createGradient('#10b981'),
                                fill: true,
                                tension: 0.5,
                                pointRadius: 0,
                                borderWidth: 4
                            },
                            {
                                label: 'Keluar',
                                data: {!! json_encode($stokKeluarPerHari) !!},
                                borderColor: '#f43f5e',
                                backgroundColor: createGradient('#f43f5e'),
                                fill: true,
                                tension: 0.5,
                                pointRadius: 0,
                                borderWidth: 4
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { beginAtZero: true, grid: { borderDash: [8, 8], color: '#e2e8f0' } },
                            x: { grid: { display: false }, ticks: { font: { weight: 'bold' } } }
                        }
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>