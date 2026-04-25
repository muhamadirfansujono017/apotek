<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    use HasFactory;

    protected $table = 'detail_penjualan';

    protected $fillable = [
        'penjualan_id',
        'obat_id',
        'jumlah',
        'harga',
        'subtotal'
    ];

    /**
     * Relasi balik ke header Penjualan
     */
    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'penjualan_id');
    }

    /**
     * Relasi ke data Obat untuk mengambil nama_obat
     */
    public function obat()
    {
        // Pastikan foreign key adalah 'obat_id' sesuai database
        return $this->belongsTo(Obat::class, 'obat_id');
    }
}