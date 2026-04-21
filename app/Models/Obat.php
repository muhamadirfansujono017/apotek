<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    protected $table = 'obat';

    protected $fillable = [
        'kode_obat',
        'nama_obat',
        'kategori',
        'satuan',
        'harga_jual',
        'harga_beli',
        'stok',
        'harga',
        'expired'
    ];
    // Tambahkan relasi ini di App\Models\Obat.php
    public function logs()
    {
        return $this->hasMany(StokLog::class, 'obat_id');
    }
}
