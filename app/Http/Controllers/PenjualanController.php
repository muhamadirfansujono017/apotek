<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Obat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualan = Penjualan::with('user')->orderBy('created_at', 'desc')->get();
        return view('page.penjualan.index', compact('penjualan'));
    }

    public function create()
    {
        $obat = Obat::where('stok', '>', 0)->get();
        $no_faktur = 'PJ-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -4));
        return view('page.penjualan.create', compact('obat', 'no_faktur'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_faktur'   => 'required',
            'tanggal'     => 'required|date',
            'obat_id'     => 'required|array|min:1',
            'jumlah'      => 'required|array|min:1',
            'total_akhir' => 'required|numeric',
            'bayar'       => 'required|numeric|min:' . $request->total_akhir,
        ]);

        try {
            DB::beginTransaction();

            $penjualan = new Penjualan();
            $penjualan->no_faktur   = $request->no_faktur;
            $penjualan->tanggal     = $request->tanggal;
            $penjualan->total_harga = $request->total_akhir;
            $penjualan->bayar       = $request->bayar;
            // Gunakan 'kembalian' sesuai database
            $penjualan->kembalian   = $request->bayar - $request->total_akhir;
            $penjualan->user_id     = Auth::id();
            $penjualan->save();

            foreach ($request->obat_id as $key => $id_obat) {
                $qty = $request->jumlah[$key];
                $obat = Obat::findOrFail($id_obat);

                if ($obat->stok < $qty) {
                    throw new \Exception("Stok obat {$obat->nama_obat} tidak mencukupi!");
                }

                $detail = new DetailPenjualan();
                $detail->penjualan_id = $penjualan->id;
                $detail->obat_id      = $id_obat;
                $detail->jumlah       = $qty;
                // PERBAIKAN: Ganti 'harga_satuan' menjadi 'harga' sesuai DB kamu
                $detail->harga        = $obat->harga_jual;
                $detail->subtotal     = $qty * $obat->harga_jual;
                $detail->save();

                $obat->stok -= $qty;
                $obat->save();
            }

            DB::commit();
            return redirect('/penjualan')->with('success', 'Transaksi Berhasil Disimpan!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal Simpan: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        // PENTING: with(['detailPenjualan.obat']) agar item muncul otomatis
        $penjualan = Penjualan::with(['detailPenjualan.obat', 'user'])->findOrFail($id);
        return view('page.penjualan.show', compact('penjualan'));
    }

    public function edit($id)
    {
        $penjualan = Penjualan::with(['detailPenjualan.obat', 'user'])->findOrFail($id);
        $obat = \App\Models\Obat::all();
        return view('page.penjualan.edit', compact('penjualan', 'obat'));
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $penjualan = Penjualan::with('detailPenjualan')->findOrFail($id);

            // Kembalikan stok obat sebelum transaksi dihapus
            foreach ($penjualan->detailPenjualan as $detail) {
                $obat = Obat::find($detail->obat_id);
                if ($obat) {
                    $obat->stok += $detail->jumlah;
                    $obat->save();
                }
            }

            $penjualan->delete();
            DB::commit();

            return redirect('/penjualan')->with('success', 'Transaksi dihapus & stok dikembalikan!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal hapus: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'bayar'   => 'required|numeric|min:0',
        ]);

        try {
            $penjualan = Penjualan::findOrFail($id);

            if ($request->bayar < $penjualan->total_harga) {
                return back()->with('error', 'Jumlah bayar tidak boleh kurang dari Total Harga');
            }

            $penjualan->update([
                'tanggal'   => $request->tanggal,
                'bayar'     => $request->bayar,
                // PERBAIKAN: Gunakan 'kembalian' (pakai 'n') sesuai DB kamu
                'kembalian' => $request->bayar - $penjualan->total_harga,
            ]);

            return redirect()->route('penjualan.index')->with('success', 'Transaksi berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal Update: ' . $e->getMessage());
        }
    }
}
