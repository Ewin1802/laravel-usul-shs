<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelompok extends Model
{
    use HasFactory;
    protected $fillable = [
        'Kode',
        'Uraian',
    ];
    public function usulanShs()
    {
        return $this->hasMany(UsulanSHS::class);
    }
}
