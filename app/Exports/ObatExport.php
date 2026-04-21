<?php

namespace App\Exports;

use App\Models\Obat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ObatExport implements FromCollection, WithHeadings
{
    /**
    * Mengambil semua data obat untuk Excel
    */
    public function collection()
    {
        return Obat::select('kode_obat', 'nama_obat', 'kategori', 'satuan', 'harga_beli', 'harga_jual', 'stok', 'tanggal_kadaluarsa')->get();
    }

    /**
    * Menambahkan judul kolom di baris pertama Excel
    */
    public function headings(): array
    {
        return [
            'Kode Obat',
            'Nama Obat',
            'Kategori',
            'Satuan',
            'Harga Beli',
            'Harga Jual',
            'Stok',
            'Tanggal Kadaluarsa',
        ];
    }
}