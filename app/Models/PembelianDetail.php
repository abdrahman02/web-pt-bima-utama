<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function barang() {
        return $this->belongsTo(Barang::class);
    }

    public function pembelian() {
        return $this->belongsTo(Pembelian::class);
    }
}
