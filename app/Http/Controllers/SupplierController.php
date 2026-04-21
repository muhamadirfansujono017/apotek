<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $supplier = Supplier::latest()->paginate(10);
        return view('page.supplier.index', compact('supplier'));
    }

    public function create()
    {
        return view('page.supplier.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required|max:255',
            'no_telp'       => 'required|numeric',
            'alamat'        => 'required',
        ]);

        Supplier::create($request->all());

        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil didaftarkan!');
    }

    // --- PERBAIKAN DI SINI ---
    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('page.supplier.edit', compact('supplier')); // Pastikan ke file .edit
    }

    // --- PERBAIKAN DI SINI ---
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_supplier' => 'required|max:255',
            'no_telp'       => 'required|numeric',
            'alamat'        => 'required',
        ]);

        $supplier = Supplier::findOrFail($id);
        $supplier->update($request->all());

        return redirect()->route('supplier.index')->with('success', 'Data supplier berhasil diperbarui!');
    }

    // --- TAMBAHKAN FUNGSI HAPUS ---
    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil dihapus!');
    }
}