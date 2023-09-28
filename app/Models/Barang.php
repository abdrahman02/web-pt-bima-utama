<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function pembelian_detail() {
        return $this->hasMany(PembelianDetail::class);
    }

    public function pemakaian_detail()
    {
        return $this->hasMany(PemakaianDetail::class);
    }

    public function proyek_detail()
    {
        return $this->hasMany(ProyekDetail::class);
    }
}
