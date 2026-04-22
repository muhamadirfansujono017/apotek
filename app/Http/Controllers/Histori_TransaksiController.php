<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Histori_TransaksiController extends Controller
{
    public function index()
    {
        $penjualan = Penjualan::with('user')
            ->latest()
            ->paginate(10, ['*'], 'pjl_page');

        $pembelian = Pembelian::with('supplier')
            ->latest()
            ->paginate(10, ['*'], 'pbl_page');

        return view('page.histori_transaksi.index', compact('penjualan', 'pembelian'));
    }

    public function show($id)
    {
        $penjualan = Penjualan::with(['user', 'detailPenjualan.obat'])
            ->findOrFail($id);

        return view('page.histori_transaksi.show', compact('penjualan'));
    }

    // Tambahkan di dalam class PenjualanController

    public function edit($id)
    {
        // Mengambil data penjualan beserta detail dan obatnya
        $penjualan = \App\Models\Penjualan::with('detailPenjualan.obat')->findOrFail($id);
        $obat = \App\Models\Obat::all();

        return view('page.histori_transaksi.edit', compact('penjualan', 'obat'));
    }
public function update(Request $request, $id)
{
    // 1. Validasi input dengan pesan kustom (biar lebih pro saat sidang)
    $request->validate([
        'tanggal' => 'required|date',
        'total' => 'required|numeric|min:0',
    ], [
        'tanggal.required' => 'Tanggal transaksi tidak boleh kosong.',
        'total.numeric' => 'Nominal total harus berupa angka.',
    ]);

    try {
        // 2. Cari data penjualan
        $penjualan = \App\Models\Penjualan::findOrFail($id);

        // 3. Update data
        // Gunakan $request->only untuk keamanan agar tidak semua data input masuk ke database
        $penjualan->update($request->only(['tanggal', 'total']));

        // 4. Redirect ke route yang benar
        // Jika di web.php kamu menggunakan Route::resource('histori_transaksi', ...), 
        // pastikan namanya 'histori_transaksi.index'
        return redirect()->route('histori_transaksi.index')
            ->with('success', 'Transaksi #PJL-' . $id . ' berhasil diperbarui!');

    } catch (\Exception $e) {
        // Jika ada error (misal database down), balik ke halaman sebelumnya
        return redirect()->back()
            ->with('error', 'Gagal memperbarui transaksi: ' . $e->getMessage());
    }
}

    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $penjualan = Penjualan::with('detailPenjualan')->findOrFail($id);

            // LOGIKA PENTING: Sebelum transaksi dihapus, kembalikan stok obatnya!
            foreach ($penjualan->detailPenjualan as $detail) {
                $obat = Obat::find($detail->obat_id);
                if ($obat) {
                    $obat->increment('stok', $detail->jumlah); // Tambah balik stoknya
                }
            }

            // Hapus detail dulu baru headernya (karena foreign key)
            $penjualan->detailPenjualan()->delete();
            $penjualan->delete();

            DB::commit();
            return redirect()->back()->with('success', 'Transaksi dihapus dan stok dikembalikan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }
}
