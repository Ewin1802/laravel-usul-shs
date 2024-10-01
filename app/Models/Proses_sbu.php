<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proses_sbu extends Model
{
    use HasFactory;
    protected $fillable = [
        'Kode',
        'Uraian',
        'Spek',
        'Satuan',
        'Harga',
        'akun_belanja',
        'rekening_1',
        'rekening_2',
        'rekening_3',
        'rekening_4',
        'rekening_5',
        'rekening_6',
        'rekening_7',
        'rekening_8',
        'rekening_9',
        'rekening_10',
        'Kelompok',
        'nilai_tkdn',
        'Document',
        'ket',
        'user',
        'alasan',
    ];
}
