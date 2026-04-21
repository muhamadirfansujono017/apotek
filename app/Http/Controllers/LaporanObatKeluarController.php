<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Exports\ObatKeluarExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanObatKeluarController extends Controller
{
    /**
     * Menampilkan daftar laporan obat keluar (dengan pagination).
     */
    public function index()
    {
        // Gunakan 'detailPenjualan.obat' sesuai nama fungsi di Model kamu
        $barangKeluar = Penjualan::with(['user', 'detailPenjualan.obat'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('page.laporankeluar.index', compact('barangKeluar'));
    }

    public function print()
    {
        // Sama seperti di atas, sesuaikan nama relasinya
        $barangKeluar = Penjualan::with(['user', 'detailPenjualan.obat'])->latest()->get();

        return view('page.laporankeluar.print', compact('barangKeluar'));
    }

    /**
     * Mengekspor laporan obat keluar ke dalam file Excel.
     */
    public function export()
    {
        return Excel::download(new ObatKeluarExport, 'laporan_penjualan_obat_irfan.xlsx');
    }
}
