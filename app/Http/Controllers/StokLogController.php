<?php

namespace App\Http\Controllers;

use App\Models\StokLog;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokLogController extends Controller
{
    public function index()
    {
        $logs = StokLog::with('obat')->latest()->paginate(20);
        return view('page.stok_log.index', compact('logs'));
    }

    public function create()
{
    $obat = Obat::all();
    return view('page.stok_log.create', compact('obat')); 
}

    public function store(Request $request)
    {
        $request->validate([
            'obat_id' => 'required|exists:obat,id',
            'tipe' => 'required|in:masuk,keluar',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string'
        ]);

        DB::beginTransaction();
        try {
            $obat = Obat::findOrFail($request->obat_id);

            // Update stok di tabel obat
            if ($request->tipe == 'masuk') {
                $obat->increment('stok', $request->jumlah);
            } else {
                if ($obat->stok < $request->jumlah) {
                    return back()->withErrors(['jumlah' => 'Stok tidak mencukupi untuk dikurangi.']);
                }
                $obat->decrement('stok', $request->jumlah);
            }

            // Simpan log
            StokLog::create([
                'obat_id' => $request->obat_id,
                'tipe' => $request->tipe,
                'jumlah' => $request->jumlah,
                'expired_at' => $obat->expired,
                'keterangan' => $request->keterangan ?? 'Penyesuaian stok manual'
            ]);

            DB::commit();
            return redirect()->route('stok_log.index')->with('success', 'Mutasi stok berhasil dicatat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal: ' . $e->getMessage()]);
        }
    }
}