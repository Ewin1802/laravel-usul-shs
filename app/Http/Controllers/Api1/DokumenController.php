<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Document;

class DokumenController extends Controller
{

    // public function list_surat(Request $request)
    // {
    //     // Ambil user yang sedang login
    //     $user = Auth::user();

    //     // Ambil data UsulanShs dengan filter
    //     $data = \App\Models\Document::when($request->id, function ($query, $id) {
    //             return $query->where('id', $id);
    //         })
    //         ->when($user->skpd !== 'AllSKPD', function ($query) use ($user) {
    //             // Memfilter berdasarkan nama pengguna yang login
    //             return $query->where('user', $user->name);
    //         })
    //         ->get();

    //     return response()->json([
    //         'status' => 'success',
    //         'data' => $data,
    //     ]);
    // }
    public function list_surat(Request $request)
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Ambil data Document dengan filter
        $data = \App\Models\Document::when($request->id, function ($query, $id) {
                return $query->where('id', $id);
            })
            ->when(!in_array($user->skpd, ['AllSKPD', 'KABAN']), function ($query) use ($user) {
                // Memfilter berdasarkan nama pengguna yang login jika skpd bukan AllSKPD atau KABAN
                return $query->where('user', $user->name);
            })
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }


    public function docstore(Request $request)
    {
        // Validasi input termasuk pengecekan keunikan judul dan validasi tanggal
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255|unique:documents,judul',
            'tgl_pengajuan' => 'required|date', // Validasi untuk tgl_pengajuan
            'pdf_file' => 'required|mimes:pdf|max:2048',
        ]);

        // Mendapatkan user yang sedang login
        $user = Auth::user();

        // Mendapatkan SKPD dari user yang login
        $skpd = $user->skpd;

        $judul = $request->input('judul');
        $tglPengajuan = $request->input('tgl_pengajuan');

        // Format tanggal pengajuan menjadi YYYYMMDD
        $formattedDate = date('Ymd', strtotime($tglPengajuan));

        // Proses upload file
        if ($request->hasFile('pdf_file')) {
            $file = $request->file('pdf_file');
            $filename = $skpd . '_' . $formattedDate . '_' . $judul . '.pdf';

            // Menyimpan file dengan nama yang telah diubah
            $path = $file->storeAs('documents', $filename, 'public');

            // Simpan informasi ke database
            $document = new Document();
            $document->judul = $request->input('judul');
            $document->skpd = $skpd;
            $document->tgl_pengajuan = $tglPengajuan;
            $document->file_name = $filename;

            // Membuat path file yang lengkap
            $baseUrl = request()->getSchemeAndHttpHost();
            $document->file_path = $baseUrl . '/storage/' . $path;
            $document->user = $user->name; // Menyimpan nama user yang login
            $document->isValid = 'tidak';
            $document->save();

            // Mengembalikan response JSON jika berhasil
            return response()->json([
                'message' => 'PDF berhasil diupload.',
                'document' => $document
            ], 201); // 201 = Created
        }

        // Mengembalikan response JSON jika gagal
        return response()->json([
            'message' => 'File tidak berhasil diupload.'
        ], 400); // 400 = Bad Request
    }

}
