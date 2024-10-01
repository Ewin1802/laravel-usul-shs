<?php

namespace App\Imports;

use App\Models\BelanjaApi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BelanjaApiImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new BelanjaApi([
            'Rekening' => $row['rekening'],
            'Belanja' => $row['belanja'],
        ]);
    }

    public function headingRow(): int
    {
        return 1;
    }
}
