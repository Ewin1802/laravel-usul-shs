<?php

namespace App\Http\Controllers;

use App\Models\UsulanShs;
use App\Models\UsulanSbu;
use App\Models\UsulanAsb;

class DashboardController extends Controller
{

    public function index()
    {

        // jumlah usulan yang masih diproses
        $totalShs = UsulanShs::where('ket','Proses Usul')->count();
        $totalSbu = UsulanSbu::where('ket','Proses Usul')->count();
        $totalAsb = UsulanAsb::where('ket','Proses Usul')->count();

        // data terbaru
        $latestShs = UsulanShs::latest()->limit(5)->get();
        $latestSbu = UsulanSbu::latest()->limit(5)->get();
        $latestAsb = UsulanAsb::latest()->limit(5)->get();

        return view('pages.dashboard',compact(
            'totalShs',
            'totalSbu',
            'totalAsb',
            'latestShs',
            'latestSbu',
            'latestAsb'
        ));

    }

}
