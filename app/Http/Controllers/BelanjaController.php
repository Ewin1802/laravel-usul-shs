<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\BelanjaImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class BelanjaController extends Controller
{
    public function index(Request $request)
    {

        // $users = \App\Models\User::paginate(10);
        $belanjas = DB::table('belanjas')
            ->when($request->input('belanja'), function ($query, $belanja ) {
                return $query->where('belanja', 'like', '%'.$belanja.'%' );
            })
            ->orderBy('id', 'asc')
            ->paginate(10);
        return view('pages.belanja.index', compact ('belanjas'), );
    }

    public function import(Request $request)
    {
        // Validasi file yang diupload
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        // Import file
        Excel::import(new BelanjaImport, $request->file('file'));

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Data Rek Belanja berhasil diimport');
    }
}
