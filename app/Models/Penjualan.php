<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';
    
    // Menggunakan guarded kosong agar semua kolom bisa diisi (praktis untuk Tugas Akhir)
    protected $guarded = [];

    protected $fillable = [
        'no_faktur',
        'user_id',
        'tanggal',
        'total_harga',
        'bayar',
        'kembalian',
    ];

    /**
     * Relasi ke DetailPenjualan (PENTING: Agar item obat muncul di struk)
     */
    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'penjualan_id');
    }

    /**
     * Relasi ke User (Untuk menampilkan nama Kasir/Admin)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}