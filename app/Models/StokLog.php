<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokLog extends Model
{
    protected $table = 'stok_log';
    protected $guarded = [];

    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }
}
