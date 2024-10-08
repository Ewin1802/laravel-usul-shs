<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use Carbon\Carbon;

class CetakPdfController extends Controller
{
    public function shsgeneratePDF(Request $request)
    {
        // Ambil tahun yang dipilih dari permintaan
        $year = $request->input('year');

        // Ambil data dari tabel berdasarkan tahun (filter by created_at)
        $shscetaks = DB::table('usulan_shs')
                    ->whereYear('created_at', $year)
                    ->get();

        // Gabungkan data untuk dikirim ke view
        $mergedData = [
            'shscetaks' => $shscetaks,
            'year' => $year
        ];

        // Load view 'pages.cetak.index' dengan data yang benar
        $pdf = PDF::loadView('pages.cetak.ssh_index', $mergedData);

        // Stream PDF dengan nama file yang sesuai
        return $pdf->stream('rekap_usulan_'.$year.'.pdf');
    }

    public function sbugeneratePDF(Request $request)
    {
        // Ambil tahun yang dipilih dari permintaan
        $year = $request->input('year');

        // Ambil data dari tabel berdasarkan tahun (filter by created_at)
        $sbucetaks = DB::table('usulan_sbus')
                    ->whereYear('created_at', $year)
                    ->get();

        // Gabungkan data untuk dikirim ke view
        $mergedData = [
            'sbucetaks' => $sbucetaks,
            'year' => $year
        ];

        // Load view 'pages.cetak.index' dengan data yang benar
        $pdf = PDF::loadView('pages.cetak.sbu_index', $mergedData);

        // Stream PDF dengan nama file yang sesuai
        return $pdf->stream('rekap_usulan_'.$year.'.pdf');
    }

    public function asbgeneratePDF(Request $request)
    {
        // Ambil tahun yang dipilih dari permintaan
        $year = $request->input('year');

        // Ambil data dari tabel berdasarkan tahun (filter by created_at)
        $asbcetaks = DB::table('usulan_asbs')
                    ->whereYear('created_at', $year)
                    ->get();

        // Gabungkan data untuk dikirim ke view
        $mergedData = [
            'asbcetaks' => $asbcetaks,
            'year' => $year
        ];

        // Load view 'pages.cetak.index' dengan data yang benar
        $pdf = PDF::loadView('pages.cetak.asb_index', $mergedData);

        // Stream PDF dengan nama file yang sesuai
        return $pdf->stream('rekap_usulan_'.$year.'.pdf');
    }

    public function hspkgeneratePDF(Request $request)
    {
        // Ambil tahun yang dipilih dari permintaan
        $year = $request->input('year');

        // Ambil data dari tabel berdasarkan tahun (filter by created_at)
        $hspkcetaks = DB::table('usulan_hspks')
                    ->whereYear('created_at', $year)
                    ->get();

        // Gabungkan data untuk dikirim ke view
        $mergedData = [
            'hspkcetaks' => $hspkcetaks,
            'year' => $year
        ];

        // Load view 'pages.cetak.index' dengan data yang benar
        $pdf = PDF::loadView('pages.cetak.hspk_index', $mergedData);

        // Stream PDF dengan nama file yang sesuai
        return $pdf->stream('rekap_usulan_'.$year.'.pdf');
    }
}
