<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemakaian extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function pemakaian_detail() {
        return $this->hasMany(PemakaianDetail::class);
    }
}
