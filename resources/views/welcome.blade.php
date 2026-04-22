<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Apotek JUJU | Sistem Informasi Manajemen Farmasi</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            scroll-behavior: smooth;
        }
        .bg-mesh {
            background-color: #f8fafc;
            background-image: 
                radial-gradient(at 0% 0%, rgba(79, 70, 229, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(192, 132, 252, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(254, 202, 202, 0.15) 0px, transparent 50%),
                radial-gradient(at 0% 100%, rgba(79, 70, 229, 0.15) 0px, transparent 50%);
        }
        .glass {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body class="antialiased bg-mesh text-slate-900 min-h-screen selection:bg-indigo-100 selection:text-indigo-700">

    <header class="fixed top-0 w-full z-50 px-6 py-6 transition-all duration-300">
        <div class="max-w-6xl mx-auto flex justify-between items-center bg-white/70 backdrop-blur-md px-6 py-4 rounded-3xl border border-white/50 shadow-xl shadow-slate-200/50">
            <div class="flex items-center gap-3">
                <div class="bg-indigo-600 w-10 h-10 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-200">
                    <i class="fas fa-kit-medical text-white text-lg"></i>
                </div>
                <span class="font-extrabold text-2xl tracking-tighter text-slate-800 italic uppercase">
                    Apotek<span class="text-indigo-600">JUJU</span>
                </span>
            </div>

            <nav class="flex items-center gap-2">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 bg-indigo-600 text-white rounded-2xl font-bold text-sm hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-200 transition-all duration-300">
                            Dashboard <i class="fas fa-arrow-right ms-2 text-[10px]"></i>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2.5 text-slate-600 font-bold text-sm hover:text-indigo-600 transition-colors">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-6 py-2.5 bg-white text-indigo-600 border border-indigo-100 rounded-2xl font-bold text-sm shadow-sm hover:bg-indigo-50 transition-all">
                                Register
                            </a>
                        @endif
                    @endauth
                @endif
            </nav>
        </div>
    </header>

    <main class="relative pt-40 pb-20 px-6 overflow-hidden">
        <div class="max-w-6xl mx-auto grid lg:grid-cols-12 gap-16 items-center">
            
            <div class="lg:col-span-7 space-y-10 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-white rounded-full border border-slate-200 shadow-sm transition-transform hover:scale-105">
                    <span class="flex h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 italic">Sistem Informasi Apotek Modern</span>
                </div>

                <div class="space-y-4">
                    <h1 class="text-6xl lg:text-[5.5rem] font-extrabold leading-[1] tracking-tighter text-slate-900">
                        Kelola Farmasi <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 italic">Tanpa Ribet.</span>
                    </h1>
                    <p class="text-lg text-slate-500 font-medium max-w-2xl mx-auto lg:mx-0 leading-relaxed">
                        Optimasi inventaris obat, pencatatan transaksi penjualan, dan laporan keuangan dalam satu platform digital yang dirancang khusus untuk efisiensi Apotek JUJU.
                    </p>
                </div>

                <div class="flex flex-wrap justify-center lg:justify-start gap-5">
                    <a href="{{ route('login') }}" class="group px-10 py-5 bg-slate-900 text-white rounded-[2rem] font-bold text-sm uppercase tracking-widest hover:bg-indigo-600 hover:shadow-2xl hover:shadow-indigo-300 transition-all duration-500">
                        Mulai Sistem <i class="fas fa-bolt ms-2 group-hover:text-yellow-400 transition-colors"></i>
                    </a>
                </div>

                <div class="flex flex-wrap justify-center lg:justify-start gap-12 pt-4 border-t border-slate-200">
                    <div>
                        <p class="text-3xl font-black text-slate-800 leading-none">TA</p>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mt-2 italic">Project Final</p>
                    </div>
                    <div>
                        <p class="text-3xl font-black text-slate-800 leading-none italic">LP3I</p>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mt-2">Tasikmalaya</p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5 relative">
                <div class="absolute -top-10 -right-10 w-64 h-64 bg-indigo-200/50 rounded-full blur-3xl -z-10"></div>
                
                <div class="glass rounded-[3rem] p-8 shadow-2xl rotate-2 hover:rotate-0 transition-transform duration-700 border border-white/80">
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex gap-2">
                            <div class="w-3 h-3 rounded-full bg-rose-400"></div>
                            <div class="w-3 h-3 rounded-full bg-amber-400"></div>
                            <div class="w-3 h-3 rounded-full bg-emerald-400"></div>
                        </div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest italic">Inventory Preview</span>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-indigo-600 rounded-[2rem] p-6 text-white shadow-xl shadow-indigo-100">
                            <div class="text-[10px] font-bold uppercase tracking-widest opacity-60 italic">Total Penjualan</div>
                            <div class="text-3xl font-black mt-1 tracking-tighter">Rp 2.450.000</div>
                            <div class="mt-4 flex justify-between items-end">
                                <span class="text-[10px] bg-white/20 px-3 py-1 rounded-full">+12.5% Up</span>
                                <i class="fas fa-chart-line opacity-50"></i>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div class="flex items-center gap-4 bg-white/50 p-4 rounded-2xl border border-white shadow-sm">
                                <div class="bg-emerald-100 text-emerald-600 w-10 h-10 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-capsules"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="h-2 bg-slate-200 rounded-full w-24 mb-2"></div>
                                    <div class="h-1.5 bg-slate-100 rounded-full w-full"></div>
                                </div>
                                <span class="text-[10px] font-bold text-emerald-600">IN STOCK</span>
                            </div>
                            <div class="flex items-center gap-4 bg-white/50 p-4 rounded-2xl border border-white shadow-sm opacity-50">
                                <div class="bg-amber-100 text-amber-600 w-10 h-10 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-truck-medical"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="h-2 bg-slate-200 rounded-full w-16 mb-2"></div>
                                    <div class="h-1.5 bg-slate-100 rounded-full w-full"></div>
                                </div>
                                <span class="text-[10px] font-bold text-slate-400 italic italic">PENDING</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="mt-20 py-12 px-6 border-t border-slate-200/50 relative overflow-hidden">
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-2 grayscale opacity-60">
                <span class="text-xs font-black uppercase tracking-widest text-slate-500">
                    &copy; 2026 Muhamad Irfan Sujono &bull; Politeknik LP3I Tasikmalaya
                </span>
            </div>
            <div class="flex gap-6">
                <a href="#" class="text-slate-400 hover:text-indigo-600 transition-colors"><i class="fab fa-github"></i></a>
                <a href="#" class="text-slate-400 hover:text-indigo-600 transition-colors"><i class="fab fa-linkedin"></i></a>
                <a href="#" class="text-slate-400 hover:text-indigo-600 transition-colors"><i class="fas fa-envelope"></i></a>
            </div>
        </div>
    </footer>

</body>
</html>