<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BelanjaApi extends Model
{
    use HasFactory;
    protected $fillable = [
        'Rekening',
        'Belanja',
    ];

    public function usulanShs()
    {
        return $this->hasMany(UsulanSHS::class);
    }
}
