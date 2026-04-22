<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Pembelian;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // 1. Total data untuk kartu statistik
            $totalBarang = Obat::count();
            $totalStokMasuk = Pembelian::count();
            
            // Mengambil jumlah transaksi keluar KHUSUS hari ini
            $totalStokKeluar = Penjualan::whereDate('created_at', Carbon::today())->count();
            
            // Tambahan: Total nominal uang masuk hari ini (untuk UI "Penjualan Hari Ini")
            $penjualan_hari_ini = Penjualan::whereDate('created_at', Carbon::today())->sum('total');

            // 2. Data Barang Terlaris (Chart Bar)
            $topItems = DB::table('detail_penjualan as dp')
                ->join('obat as o', 'dp.obat_id', '=', 'o.id')
                ->select('o.nama_obat as nama_barang', DB::raw('SUM(dp.jumlah) as total'))
                ->groupBy('o.nama_obat', 'o.id')
                ->orderByDesc('total')
                ->limit(5)
                ->get();

            // 3. Label Hari (Chart Line)
            $weekDays = collect(range(6, 0))->map(function ($i) {
                return Carbon::today()->subDays($i)->isoFormat('dddd'); // Format nama hari (Senin, Selasa, dst)
            });

            // 4. Statistik harian (Chart Line)
            $stokMasukPerHari = collect(range(6, 0))->map(function ($i) {
                return Pembelian::whereDate('created_at', Carbon::today()->subDays($i))->count();
            });

            $stokKeluarPerHari = collect(range(6, 0))->map(function ($i) {
                return Penjualan::whereDate('created_at', Carbon::today()->subDays($i))->count();
            });

            // Tambahan: Ambil 5 transaksi terakhir untuk tabel dashboard
            $recent_sales = Penjualan::with('user')->latest()->limit(5)->get();

            return view('page.dashboard.index', compact(
                'totalBarang', 'totalStokMasuk', 'totalStokKeluar', 
                'topItems', 'weekDays', 'stokMasukPerHari', 'stokKeluarPerHari',
                'penjualan_hari_ini', 'recent_sales'
            ));

        } catch (\Illuminate\Database\QueryException $e) {
            return "Error: Database belum siap. Pastikan migrasi sudah jalan. Detail: " . $e->getMessage();
        }
    }
}