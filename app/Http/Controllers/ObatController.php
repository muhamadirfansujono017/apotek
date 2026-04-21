<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index()
    {
        $obat = Obat::latest()->paginate(10);

        // Logika kode obat otomatis OBT-001
        $latestObat = Obat::orderBy('id', 'desc')->first();
        if (!$latestObat) {
            $latestKodeObat = 'OBT-001';
        } else {
            $lastNumber = (int) substr($latestObat->kode_obat, 4);
            $latestKodeObat = 'OBT-' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        }

        return view('page.obat.index', compact('obat', 'latestKodeObat'));
    }

    // FUNGSI INI YANG TADI HILANG:
    public function create()
    {
        // Kita butuh variabel ini agar input otomatis muncul di form create
        $latestObat = Obat::orderBy('id', 'desc')->first();
        if (!$latestObat) {
            $latestKodeObat = 'OBT-001';
        } else {
            $lastNumber = (int) substr($latestObat->kode_obat, 4);
            $latestKodeObat = 'OBT-' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        }

        return view('page.obat.create', compact('latestKodeObat'));
    }

    public function show($id)
    {
        $obat = Obat::findOrFail($id);
        return view('page.obat.show', compact('obat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_obat'  => 'required|unique:obat,kode_obat',
            'nama_obat'  => 'required',
            'kategori'   => 'required',
            'satuan'     => 'required',
            'stok'       => 'required|numeric',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'expired'    => 'required|date',
        ]);

        Obat::create($request->all());

        return redirect()->route('obat.index')->with('success', 'Data obat berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $obat = Obat::findOrFail($id);
        return view('page.obat.edit', compact('obat'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_obat'  => 'required',
            'kategori'   => 'required',
            'satuan'     => 'required',
            'stok'       => 'required|numeric',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'expired'    => 'required|date',
        ]);

        $obat = Obat::findOrFail($id);
        $obat->update($request->all());

        return redirect()->route('obat.index')->with('success', 'Data obat berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $obat = Obat::findOrFail($id);
        $obat->delete();
        return redirect()->route('obat.index')->with('success', 'Data obat berhasil dihapus!');
    }
}
