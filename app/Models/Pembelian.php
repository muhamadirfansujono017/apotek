<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'pembelian';

    protected $fillable = [
        'supplier_id',
        'tanggal',
        'total'
    ];

    /**
     * Relasi ke Supplier
     * Pembelian ini dilakukan kepada satu supplier tertentu
     */
    public function supplier()
    {
        // Menentukan foreign key 'supplier_id' secara eksplisit
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    /**
     * Relasi ke Detail Pembelian
     * Satu nota pembelian bisa berisi banyak item obat
     */
    public function detail()
    {
        // Menentukan foreign key 'pembelian_id' secara eksplisit
        return $this->hasMany(DetailPembelian::class, 'pembelian_id');
    }
}