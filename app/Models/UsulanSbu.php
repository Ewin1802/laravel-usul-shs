<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsulanSbu extends Model
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
        'alasan',
        'user',
        'skpd'
    ];

    public function satuan()
    {
        return $this->belongsTo(Satuan::class);
    }
    public function kelompok()
    {
        return $this->belongsTo(Kelompok::class);
    }
    public function belanja()
    {
        return $this->belongsTo(Belanja::class);
    }

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
