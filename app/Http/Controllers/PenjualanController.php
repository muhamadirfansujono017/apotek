<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Obat;
use Illuminate\Support\Facades\Auth;

class PenjualanController extends Controller
{
    /**
     * Menampilkan daftar riwayat penjualan.
     * FIX: Menggunakan paginate() agar method links() di Blade (baris 46) tidak error.
     */
    public function index()
    {
        // Mengambil data penjualan dengan relasi user, urutkan terbaru, 10 data per halaman
        $penjualan = Penjualan::with('user')->latest()->paginate(10);
        
        return view('page.penjualan.index', compact('penjualan'));
    }

    /**
     * Menampilkan form untuk transaksi penjualan baru.
     * FIX: Menambahkan method create() agar rute penjualan/create tidak error 500.
     */
    public function create()
    {
        // Mengambil data obat yang stoknya tersedia untuk dipilih di form
        $obat = Obat::where('stok', '>', 0)->get();
        
        return view('page.penjualan.create', compact('obat'));
    }

    /**
     * Menyimpan data transaksi penjualan ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'no_faktur' => 'required|unique:penjualan,no_faktur',
            'tanggal'   => 'required|date',
            // Tambahkan validasi lain sesuai kolom tabel penjualan kamu
        ]);

        // Tambahkan logika simpan data (insert) ke tabel penjualan & penjualan_detail di sini

        return redirect()->route('penjualan.index')->with('success', 'Transaksi penjualan berhasil disimpan.');
    }

    /**
     * Menampilkan detail transaksi tertentu.
     */
    public function show($id)
    {
        $penjualan = Penjualan::with(['user'])->findOrFail($id);
        return view('page.penjualan.show', compact('penjualan'));
    }

    /**
     * Menampilkan form edit transaksi (jika diperlukan).
     */
    public function edit($id)
    {
        $penjualan = Penjualan::findOrFail($id);
        $obat = Obat::all();
        return view('page.penjualan.edit', compact('penjualan', 'obat'));
    }

    /**
     * Memperbarui data transaksi.
     */
    public function update(Request $request, $id)
    {
        // Tambahkan logika update data di sini
    }

    /**
     * Menghapus data transaksi.
     */
    public function destroy($id)
    {
        $penjualan = Penjualan::findOrFail($id);
        $penjualan->delete();

        return redirect()->route('penjualan.index')->with('success', 'Data penjualan berhasil dihapus.');
    }
}