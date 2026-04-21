<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';

    protected $fillable = [
        'user_id', 
        'tanggal',
        'total',
        'bayar',
        'kembalian',
    ];

    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'penjualan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}