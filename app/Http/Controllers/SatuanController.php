<?php

namespace App\Http\Controllers;

use App\Imports\SatuansImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Models\Satuan;

class SatuanController extends Controller
{
    public function import(Request $request)
    {
        // Validasi file yang diupload
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        // Import file
        Excel::import(new SatuansImport, $request->file('file'));

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Data Satuan berhasil diimport');
    }

    public function index(Request $request)
    {

        // $users = \App\Models\User::paginate(10);
        $satuans = DB::table('satuans')
            ->when($request->input('satuan'), function ($query, $satuan ) {
                return $query->where('satuan', 'like', '%'.$satuan.'%' );
            })
            ->orderBy('id', 'asc')
            ->paginate(10);
        return view('pages.satuan.index', compact ('satuans'), );
    }

    public function edit($id)
    {
        $satuan = Satuan::findOrFail($id); // Ambil data skpd berdasarkan ID
        return view('pages.satuan.admin_edit', compact('satuan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'satuan' => 'required',
        ]);

        // Temukan data satuan berdasarkan ID dan perbarui
        $satuan = Satuan::findOrFail($id);
        $satuan->satuan = $request->input('satuan');
        $satuan->save();

        return redirect()->route('satuan.index')->with('success', 'Satuan successfully updated');
    }
}
