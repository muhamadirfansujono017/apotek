<?php

namespace App\Exports;

use App\Models\DetailPenjualan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ObatKeluarExport implements FromCollection, WithHeadings
{
    /**
    * Mengambil data detail penjualan untuk laporan Excel
    */
    public function collection()
    {
        // Menggunakan Eager Loading (with) agar query lebih cepat dan efisien
        return DetailPenjualan::with(['penjualan.user', 'obat'])->get()->map(function ($item) {
            return [
                'nama_obat' => $item->obat->nama_obat ?? '-',
                'jumlah'    => $item->jumlah,
                'harga'     => $item->harga,
                'subtotal'  => $item->subtotal,
                'tanggal'   => $item->penjualan->tanggal ?? '-',
                'kasir'     => $item->penjualan->user->name ?? '-',
            ];
        });
    }

    /**
    * Judul kolom yang akan muncul di baris pertama Excel
    */
    public function headings(): array
    {
        return [
            'Nama Obat',
            'Jumlah Terjual',
            'Harga Satuan',
            'Total Harga',
            'Tanggal Transaksi',
            'Nama Kasir',
        ];
    }
}