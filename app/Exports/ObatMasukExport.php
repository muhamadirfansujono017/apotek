<?php

namespace App\Exports;

use App\Models\DetailPembelian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ObatMasukExport implements FromCollection, WithHeadings
{
    /**
    * Mengambil data detail pembelian untuk laporan Excel
    */
    public function collection()
    {
        // Eager loading relasi pembelian, supplier, dan obat
        return DetailPembelian::with(['pembelian.supplier', 'obat'])->get()->map(function ($item) {
            return [
                'nama_obat' => $item->obat->nama_obat ?? '-',
                'jumlah'    => $item->jumlah,
                'harga'     => $item->harga,
                'subtotal'  => $item->subtotal,
                'tanggal'   => $item->pembelian->tanggal ?? '-', 
                'supplier'  => $item->pembelian->supplier->nama_supplier ?? '-',
            ];
        });
    }

    /**
    * Judul kolom di baris pertama file Excel
    */
    public function headings(): array
    {
        return [
            'Nama Obat',
            'Jumlah Masuk',
            'Harga Beli',
            'Subtotal',
            'Tanggal Masuk',
            'Supplier',
        ];
    }
}