<?php

namespace App\Http\Controllers;

use App\Models\Pembelian; // Gunakan model Pembelian
use App\Exports\ObatMasukExport; // Gunakan export yang baru
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanObatMasukController extends Controller
{
    /**
     * Tampilkan halaman laporan obat masuk dengan pagination.
     */
    public function index()
    {
        // Mengambil data pembelian beserta supplier-nya
        $stok_masuk = Pembelian::with(['supplier'])
                        ->latest()
                        ->paginate(10);

        return view('page.laporanmasuk.index', compact('stok_masuk'));
    }

    /**
     * Tampilkan halaman cetak (print) laporan obat masuk tanpa pagination.
     */
    public function print()
    {
        // Mengambil semua data pembelian untuk dicetak
        $stok_masuk = Pembelian::with(['supplier'])
                        ->latest()
                        ->get();

        return view('page.laporanmasuk.print', compact('stok_masuk'));
    }

    /**
     * Export laporan obat masuk ke dalam file Excel.
     */
    public function export()
    {
        // Nama file Excel profesional untuk Apotek Irfan
        return Excel::download(new ObatMasukExport, 'laporan_pembelian_obat_irfan.xlsx');
    }
}