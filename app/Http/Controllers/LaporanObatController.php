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
        $query = Obat::query();

        // Filter berdasarkan rentang tanggal
        if ($request->has('tgl_awal') && $request->has('tgl_akhir')) {
            $query->whereBetween('created_at', [$request->tgl_awal . ' 00:00:00', $request->tgl_akhir . ' 23:59:59']);
        }

        $obat = $query->get();
        return view('page.laporanObat.index', compact('obat'));
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
    public function print(Request $request)
    {
        $query = Obat::query();

        if ($request->tgl_awal && $request->tgl_akhir) {
            $query->whereBetween('created_at', [$request->tgl_awal . ' 00:00:00', $request->tgl_akhir . ' 23:59:59']);
        }

        $obat = $query->get();
        $tgl_awal = $request->tgl_awal;
        $tgl_akhir = $request->tgl_akhir;

        return view('page.laporanObat.print', compact('obat', 'tgl_awal', 'tgl_akhir'));
    }
}
