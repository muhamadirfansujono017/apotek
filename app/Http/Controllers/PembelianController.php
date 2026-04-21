<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Supplier;
use App\Models\Pembelian;
use App\Models\DetailPembelian;
use App\Models\StokLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    public function index()
    {
        // Menggunakan paginate agar loading tetap cepat meski data banyak
        $pembelian = Pembelian::with('supplier')->latest()->paginate(10);
        return view('page.pembelian.index', compact('pembelian'));
    }

    public function create()
    {
        $supplier = Supplier::all();
        $obat = Obat::all();
        return view('page.pembelian.create', compact('supplier', 'obat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required',
            'tanggal'     => 'required|date',
            'obat_id'     => 'required|array',
            'harga_beli'  => 'required|array',
            'jumlah'      => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            $pembelian = Pembelian::create([
                'supplier_id' => $request->supplier_id,
                'tanggal'     => $request->tanggal,
                'total'       => 0, 
            ]);

            $totalKeseluruhan = 0;

            foreach ($request->obat_id as $key => $id) {
                $hargaSatuan = $request->harga_beli[$key];
                $qty = $request->jumlah[$key];
                $subtotal = $hargaSatuan * $qty;

                DetailPembelian::create([
                    'pembelian_id' => $pembelian->id,
                    'obat_id'      => $id,
                    'jumlah'       => $qty,
                    'harga'        => $hargaSatuan,
                    'subtotal'     => $subtotal
                ]);

                $obat = Obat::find($id);
                if ($obat) {
                    $obat->increment('stok', $qty);
                    
                    StokLog::create([
                        'obat_id'    => $id,
                        'tipe'       => 'masuk',
                        'jumlah'     => $qty,
                        // 'expired_at' => $obat->expired,
                        'keterangan' => 'Pembelian Stok (TRX-' . $pembelian->id . ')',
                    ]);
                }
                $totalKeseluruhan += $subtotal;
            }

            $pembelian->update(['total' => $totalKeseluruhan]);

            DB::commit();
            return redirect()->route('pembelian.index')->with('success', 'Transaksi Pembelian Berhasil Disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal simpan: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $pembelian = Pembelian::with(['supplier', 'detail.obat'])->findOrFail($id);
        return view('page.pembelian.show', compact('pembelian'));
    }

    public function edit($id)
    {
        $pembelian = Pembelian::with('detail')->findOrFail($id);
        $supplier = Supplier::all();
        $obat = Obat::all();
        return view('page.pembelian.edit', compact('pembelian', 'supplier', 'obat'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'supplier_id' => 'required',
            'tanggal'     => 'required|date',
            'obat_id'     => 'required|array',
            'harga_beli'  => 'required|array',
            'jumlah'      => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            $pembelian = Pembelian::with('detail')->findOrFail($id);

            // 1. Balikkan stok lama tanpa membuat log "Keluar" (agar tidak rancu di riwayat)
            // Cukup beri keterangan di log baru nanti bahwa ini adalah hasil update
            foreach ($pembelian->detail as $oldDetail) {
                $oldObat = Obat::find($oldDetail->obat_id);
                if ($oldObat) {
                    $oldObat->decrement('stok', $oldDetail->jumlah);
                }
            }

            // Hapus detail lama
            $pembelian->detail()->delete();

            $totalBaru = 0;

            // 2. Simpan detail baru & catat satu log "Masuk" yang sudah diperbarui
            foreach ($request->obat_id as $key => $obat_id) {
                $h = $request->harga_beli[$key];
                $q = $request->jumlah[$key];
                $sub = $h * $q;

                DetailPembelian::create([
                    'pembelian_id' => $pembelian->id,
                    'obat_id'      => $obat_id,
                    'jumlah'       => $q,
                    'harga'        => $h,
                    'subtotal'     => $sub
                ]);

                $obat = Obat::find($obat_id);
                if ($obat) {
                    $obat->increment('stok', $q);
                    
                    StokLog::create([
                        'obat_id'    => $obat_id,
                        'tipe'       => 'masuk',
                        'jumlah'     => $q,
                        // 'expired_at' => $obat->expired,
                        'keterangan' => 'Koreksi/Update Pembelian (TRX-' . $pembelian->id . ')',
                    ]);
                }
                $totalBaru += $sub;
            }

            $pembelian->update([
                'supplier_id' => $request->supplier_id,
                'tanggal'     => $request->tanggal,
                'total'       => $totalBaru, 
            ]);

            DB::commit();
            return redirect()->route('pembelian.index')->with('success', 'Data pembelian berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal update: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $pembelian = Pembelian::with('detail')->findOrFail($id);
            
            foreach ($pembelian->detail as $item) {
                $obat = Obat::find($item->obat_id);
                if ($obat) { 
                    $obat->decrement('stok', $item->jumlah); 
                    
                    StokLog::create([
                        'obat_id'    => $item->obat_id,
                        'tipe'       => 'keluar',
                        'jumlah'     => $item->jumlah,
                        // 'expired_at' => $obat->expired,
                        'keterangan' => 'Pembatalan/Hapus Transaksi (TRX-' . $id . ')',
                    ]);
                }
            }
            
            // Hapus detail secara manual jika tidak ada on cascade delete di database
            $pembelian->detail()->delete();
            $pembelian->delete();

            DB::commit();
            return redirect()->route('pembelian.index')->with('success', 'Transaksi berhasil dihapus dan stok dikembalikan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus transaksi.');
        }
    }
}