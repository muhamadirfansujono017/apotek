<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class Histori_TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data penjualan (Obat Keluar) beserta kasirnya
        // Menggunakan pjl_page agar pagination tidak bentrok dengan tabel sebelah
        $penjualan = Penjualan::with('user')
            ->latest()
            ->paginate(10, ['*'], 'pjl_page');

        // Ambil data pembelian (Obat Masuk) beserta suppliernya
        $pembelian = Pembelian::with('supplier')
            ->latest()
            ->paginate(10, ['*'], 'pbl_page');

        return view('page.histori_transaksi.index', compact('penjualan', 'pembelian'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Load data penjualan beserta detail item dan data obatnya
        $penjualan = Penjualan::with(['user', 'detailPenjualan.obat'])
            ->findOrFail($id);

        return view('page.histori_transaksi.show', compact('penjualan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
