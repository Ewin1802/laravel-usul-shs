<?php

namespace App\Imports;

use App\Models\Belanja;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BelanjaImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row);
        return new Belanja([
            'Rekening' => $row['rekening'],
            'Belanja' => $row['belanja'],
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
