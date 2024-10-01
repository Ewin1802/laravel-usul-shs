<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    use HasFactory;
    protected $fillable = [
        'no',
        'satuan',

    ];

    public function usulanShs()
    {
        return $this->hasMany(UsulanSHS::class);
    }

}
