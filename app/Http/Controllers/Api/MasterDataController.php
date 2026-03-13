<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelompok;
use App\Models\Satuan;
use App\Models\Belanja;
use App\Models\Document;
use App\Models\User;

class MasterDataController extends Controller
{
    public function kelompok()
    {
        return Kelompok::all();
    }
    public function satuan()
    {
        return Satuan::all();
    }
    public function belanja()
    {
        return Belanja::all();
    }
    public function skpd()
    {
        return User::select('skpd')->distinct()->get();
    }
    public function uploadDocument(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'file' => 'required|mimes:pdf|max:5000'
        ]);

        $file = $request->file('file');

        $filename = time() . '_' . $file->getClientOriginalName();

        $path = $file->storeAs('documents', $filename, 'public');

        $doc = Document::create([
            'judul' => $request->judul,
            'skpd' => $request->skpd,
            'tgl_pengajuan' => now(),
            'file_name' => $filename,
            'file_path' => $path,
            'user' => $request->user()->name,
            'isValid' => 'Proses'
        ]);

        return response()->json([
            'message' => 'Upload berhasil',
            'data' => $doc
        ]);
    }
    public function documents()
    {
        return Document::latest()->get();
    }
}
