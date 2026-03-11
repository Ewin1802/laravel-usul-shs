<?php

namespace App\Http\Controllers;

use App\Models\UsulanShs;
use App\Models\UsulanSbu;
use App\Models\UsulanAsb;

class DashboardController extends Controller
{

    public function index()
    {

        // jumlah usulan yang masih proses
        $totalShs = UsulanShs::where('ket','Disetujui')->count();
        $totalSbu = UsulanSbu::where('ket','Disetujui')->count();
        $totalAsb = UsulanAsb::where('ket','Disetujui')->count();


        // 5 SSH yang ditolak
        $shsDitolak = UsulanShs::where('ket','Ditolak')
            ->latest()
            ->limit(5)
            ->get();


        // 5 SBU yang ditolak
        $sbuDitolak = UsulanSbu::where('ket','Ditolak')
            ->latest()
            ->limit(5)
            ->get();


        // 5 ASB yang ditolak
        $asbDitolak = UsulanAsb::where('ket','Ditolak')
            ->latest()
            ->limit(5)
            ->get();


        return view('pages.dashboard', compact(
            'totalShs',
            'totalSbu',
            'totalAsb',
            'shsDitolak',
            'sbuDitolak',
            'asbDitolak'
        ));
    }
}
