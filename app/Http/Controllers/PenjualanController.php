<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualan = Penjualan::with(['user', 'detailPenjualan.obat'])->latest()->paginate(10);
        return view('page.penjualan.index', compact('penjualan'));
    }

    public function create()
    {
        $obat = Obat::where('stok', '>', 0)->get();
        return view('page.penjualan.create', compact('obat'));
    }

    public function store(Request $request)
    {
        // Validasi input dari form kamu
        $request->validate([
            'tanggal' => 'required|date',
            'obat_id' => 'required|array',
            'jumlah'  => 'required|array',
            'bayar'   => 'required|numeric',
        ]);

        return DB::transaction(function () use ($request) {
            // 1. Simpan ke tabel PENJUALAN (Sesuai Struktur Foto Kamu)
            $penjualan = Penjualan::create([
                'user_id'   => Auth::id(),
                'tanggal'   => $request->tanggal,
                'total'     => 0, // Akan diupdate setelah hitung detail
                'bayar'     => $request->bayar,
                'kembalian' => 0, 
            ]);

            $grandTotal = 0;

            // 2. Simpan ke tabel DETAIL_PENJUALAN
            foreach ($request->obat_id as $key => $id) {
                $obat = Obat::findOrFail($id);
                $qty = $request->jumlah[$key];
                $subtotal = $obat->harga_jual * $qty;

                // IRFAN: Pastikan nama kolom di bawah ini SAMA dengan di phpMyAdmin kamu!
                // Jika di phpMyAdmin namanya 'harga', ganti 'harga_satuan' jadi 'harga'
                DetailPenjualan::create([
                    'penjualan_id' => $penjualan->id,
                    'obat_id'      => $id,
                    'jumlah'       => $qty,
                    'harga_satuan' => $obat->harga_jual, 
                    'subtotal'     => $subtotal,
                ]);

                // Potong stok
                $obat->decrement('stok', $qty);
                $grandTotal += $subtotal;
            }

            // 3. Update Total dan Kembalian di tabel PENJUALAN
            $penjualan->update([
                'total'     => $grandTotal,
                'kembalian' => $request->bayar - $grandTotal
            ]);

            return redirect()->route('transaksi.index')->with('success', 'Transaksi Berhasil!');
        });
    }

    public function show($id)
    {
        $penjualan = Penjualan::with(['user', 'detailPenjualan.obat'])->findOrFail($id);
        return view('page.transaksi.show', compact('penjualan'));
    }
}