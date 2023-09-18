<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function pembelian()
    {
        return $this->hasMany(Pembelian::class);
    }

    public function pemakaian()
    {
        return $this->hasMany(Pemakaian::class);
    }

    public function proyek()
    {
        return $this->hasMany(Proyek::class);
    }
}
