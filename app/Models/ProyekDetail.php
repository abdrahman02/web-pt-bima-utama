<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyekDetail extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function proyek()
    {
        return $this->belongsTo(Proyek::class);
    }
}
