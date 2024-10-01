<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\SkpdImport;
use App\Models\Skpd;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class SkpdController extends Controller
{
    public function index(Request $request)
    {
        $skpd = DB::table('skpds')
            ->when($request->input('nama_skpd'), function ($query, $nama_skpd ) {
                return $query->where('nama_skpd', 'like', '%'.$nama_skpd.'%' );
            })
            ->orderBy('id', 'asc')
            ->paginate(10);
        return view('pages.skpd.index', compact ('skpd'), );
    }

    public function import(Request $request)
    {
        // Validasi file yang diupload
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        // Import file
        Excel::import(new SkpdImport, $request->file('file'));

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Data Skpd berhasil diimport');
    }

    public function edit($id)
    {
        $skpd = Skpd::findOrFail($id); // Ambil data skpd berdasarkan ID
        return view('pages.skpd.admin_edit', compact('skpd'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'bidang' => 'required',
            'nama_skpd' => 'required',
        ]);

        // Temukan data SKPD berdasarkan ID dan perbarui
        $skpd = Skpd::findOrFail($id);
        $skpd->bidang = $request->input('bidang');
        $skpd->nama_skpd = $request->input('nama_skpd');
        $skpd->save();

        return redirect()->route('skpd.index')->with('success', 'SKPD successfully updated');
    }

}
