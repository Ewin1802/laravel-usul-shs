<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $fillable = [
        'judul',
        'skpd',
        'file_name',
        'file_path',
        'user',
        'tgl_pengajuan',
    ];

    public function usulanShs()
    {
        return $this->hasMany(UsulanSHS::class);
    }
}
