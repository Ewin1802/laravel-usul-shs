<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\BelanjaApiImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Models\BelanjaApi;

class BelanjaApiController extends Controller
{
    public function index(Request $request)
    {

        // $users = \App\Models\User::paginate(10);
        $belanjas = DB::table('belanja_apis')
            ->when($request->input('belanja'), function ($query, $belanja ) {
                return $query->where('belanja', 'like', '%'.$belanja.'%' );
            })
            ->orderBy('id', 'asc')
            ->paginate(10);
        return view('pages.belanja.api_index', compact ('belanjas'), );
    }

    public function import(Request $request)
    {
        // Validasi file yang diupload
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        // Import file
        Excel::import(new BelanjaApiImport, $request->file('file'));

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Data Rek Belanja Api berhasil diimport');
    }

    public function edit($id)
    {
        $belanjas = BelanjaApi::findOrFail($id); // Ambil data skpd berdasarkan ID
        return view('pages.belanja.admin_edit_belanjaApi', compact('belanjas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'Rekening' => 'required',
            'Belanja' => 'required',
        ]);

        // Temukan data SKPD berdasarkan ID dan perbarui
        $bel = BelanjaApi::findOrFail($id);
        $bel->Rekening = $request->input('Rekening');
        $bel->Belanja = $request->input('Belanja');
        $bel->save();

        return redirect()->route('belanjaApi.index')->with('success', 'Data Belanja API successfully updated');
    }

    public function destroy($id)
    {
        $belanja = BelanjaApi::findOrFail($id);
        $belanja->delete();
        return redirect()->route('belanjaApi.index')->with('success', 'Item successfully deleted');
    }
}
