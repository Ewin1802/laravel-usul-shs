<?php

namespace App\Imports;

use App\Models\Skpd;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SkpdImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Skpd([
            'bidang' => $row['bidang'],   // Pastikan penggunaan huruf kecil jika header di Excel adalah 'kode'
            'nama_skpd' => $row['nama_skpd'],
        ]);
    }
    public function headingRow(): int
    {
        return 1;
    }
}
