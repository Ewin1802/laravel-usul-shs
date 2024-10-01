<?php

namespace App\Imports;

use App\Models\Satuan;
use Maatwebsite\Excel\Concerns\ToModel;

class SatuansImport implements ToModel
{
    public function model(array $row)
    {
        return new Satuan([
            // Sesuaikan dengan kolom di tabel satuans
            'no' => $row[0], // Misalnya kolom pertama di Excel adalah 'nama'
            'satuan' => $row[1], // Misalnya kolom kedua di Excel adalah 'kode'
        ]);
    }
}

