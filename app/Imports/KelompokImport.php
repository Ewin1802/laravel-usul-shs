<?php

namespace App\Imports;

use App\Models\Kelompok;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KelompokImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Setelah implementasi WithHeadingRow, row seharusnya memiliki kunci seperti 'kode', 'uraian'
        return new Kelompok([
            'Kode' => $row['kode'],   // Pastikan penggunaan huruf kecil jika header di Excel adalah 'kode'
            'Uraian' => $row['uraian'],
        ]);
    }

    /**
     * Menentukan bahwa header ada di baris pertama
     */
    public function headingRow(): int
    {
        return 1;
    }
}

