<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Imports\KelompokImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Models\Kelompok;

class KelompokController extends Controller
{
    public function index(Request $request)
    {

        // $users = \App\Models\User::paginate(10);
        $kelompoks = DB::table('kelompoks')
            ->when($request->input('uraian'), function ($query, $uraian ) {
                return $query->where('uraian', 'like', '%'.$uraian.'%' );
            })
            ->orderBy('id', 'asc')
            ->paginate(10);
        return view('pages.kelompok.index', compact ('kelompoks'), );
    }

    public function import(Request $request)
    {
        // Validasi file yang diupload
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        // Import file
        Excel::import(new KelompokImport, $request->file('file'));

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Data Kelompok berhasil diimport');
    }

    public function edit($id)
    {
        $kel = Kelompok::findOrFail($id); // Ambil data skpd berdasarkan ID
        return view('pages.kelompok.admin_edit', compact('kel'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'Kode' => 'required',
            'Uraian' => 'required',
        ]);

        // Temukan data SKPD berdasarkan ID dan perbarui
        $kel = Kelompok::findOrFail($id);
        $kel->Kode = $request->input('Kode');
        $kel->Uraian = $request->input('Uraian');
        $kel->save();

        return redirect()->route('kelompok.index')->with('success', 'Data Kelompok successfully updated');
    }
}
