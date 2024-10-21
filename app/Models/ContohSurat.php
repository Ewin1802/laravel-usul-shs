<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContohSurat extends Model
{
    use HasFactory;
    protected $fillable = [
        'judul',
        'file_name',
        'file_path',
        'user',
    ];
}
