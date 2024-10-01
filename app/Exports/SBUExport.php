<?php

namespace App\Exports;

use App\Models\Proses_sbu;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SBUExport implements FromArray, WithHeadings
{
    // /**
    // * @return \Illuminate\Support\Collection
    // */
    public function array(): array
    {
        $data = Proses_sbu::all(); // Mengambil semua data

        $exportData = [];

        foreach ($data as $item) {
            $exportData[] = [
                'Kode' => $item->Kode,
                'Uraian' => $item->Uraian,
                'Spek' => $item->Spek,
                'Satuan' => $item->Satuan,
                'Harga' => $item->Harga,
                'rekening_1' => $item->rekening_1,
                'rekening_2' => $item->rekening_2,
                'rekening_3' => $item->rekening_3,
                'rekening_4' => $item->rekening_4,
                'rekening_5' => $item->rekening_5,
                'rekening_6' => $item->rekening_6,
                'rekening_7' => $item->rekening_7,
                'rekening_8' => $item->rekening_8,
                'rekening_9' => $item->rekening_9,
                'rekening_10' => $item->rekening_10,
                'Kelompok' => $item->Kelompok,
                'nilai_tkdn' => $item->nilai_tkdn,
            ];
        }
        return $exportData;
    }

    public function headings(): array
    {
        return [
            'Kode',
            'Uraian',
            'Spek',
            'Satuan',
            'Harga',
            'Rekening 1' ,
            'Rekening 2',
            'Rekening 3',
            'Rekening 4',
            'Rekening 5',
            'Rekening 6',
            'Rekening 7',
            'Rekening 8',
            'Rekening 9',
            'Rekening 10',
            'Kelompok',
            'Nilai TKDN',
        ];
    }
}
