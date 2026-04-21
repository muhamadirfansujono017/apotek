<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Pembelian;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // Pastikan importnya seperti ini

class DashboardController extends Controller
{
    public function index()
    {
        // Gunakan try-catch agar jika tabel belum ada, aplikasi tidak langsung "mati" (Internal Server Error)
        try {
            // 1. Total data
            $totalBarang = Obat::count();
            $totalStokMasuk = Pembelian::count();
            $totalStokKeluar = Penjualan::whereDate('created_at', Carbon::today())->count();

            // 2. Data Barang Terlaris
            $topItems = DB::table('detail_penjualan as dp')
                ->join('obat as o', 'dp.obat_id', '=', 'o.id')
                ->select('o.nama_obat as nama_barang', DB::raw('SUM(dp.jumlah) as total'))
                ->groupBy('o.nama_obat', 'o.id')
                ->orderByDesc('total')
                ->limit(5)
                ->get();

            // 3. Label Hari
            $weekDays = collect(range(6, 0))->map(function ($i) {
                return Carbon::today()->subDays($i)->format('d/m');
            });

            // 4. Statistik harian
            $stokMasukPerHari = collect(range(6, 0))->map(function ($i) {
                return Pembelian::whereDate('created_at', Carbon::today()->subDays($i))->count();
            });

            $stokKeluarPerHari = collect(range(6, 0))->map(function ($i) {
                return Penjualan::whereDate('created_at', Carbon::today()->subDays($i))->count();
            });

            return view('page.dashboard.index', compact(
                'totalBarang', 'totalStokMasuk', 'totalStokKeluar', 
                'topItems', 'weekDays', 'stokMasukPerHari', 'stokKeluarPerHari'
            ));

        } catch (\Illuminate\Database\QueryException $e) {
            // Jika tabel 'obat' tidak ditemukan, tampilkan pesan instruksi
            return "Error: Tabel tidak ditemukan. Pastikan Anda sudah menjalankan 'php artisan migrate'. Detail: " . $e->getMessage();
        }
    }
}