<?php

namespace App\Http\Controllers;

use App\Models\Obat; // Menggunakan model Obat
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ObatExport; // Pastikan nama Export disesuaikan

class LaporanObatController extends Controller
{
    /**
     * Menampilkan daftar obat untuk laporan.
     */
    public function index(Request $request)
    {
        // Menggunakan paginate agar tampilan tabel tetap rapi (elegant)
        $barangs = Obat::paginate(10);
        
        // Menghitung total seluruh stok obat
        $totalStok = Obat::sum('stok');

        return view('page.laporan.index', compact('barangs', 'totalStok'));
    }

    /**
     * Ekspor data obat ke Excel.
     */
    public function export()
    {
        return Excel::download(new ObatExport, 'laporan_stok_obat_JUJU.xlsx');
    }

    /**
     * Fungsi Print untuk cetak laporan (Tampilan khusus print)
     */
    public function print()
    {
        $barangs = Obat::all();
        return view('page.laporan-masuk.print', compact('barangs'));
    }
}