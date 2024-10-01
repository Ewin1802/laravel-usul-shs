<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DocumentController extends Controller
{

    public function index(Request $request)
    {
        // Ambil informasi user yang sedang login
        $user = Auth::user();  // Ambil informasi user yang login
        $skpd = $user->skpd;   // Ambil nilai 'skpd' dari user yang login (huruf kecil)

        // Dapatkan filter dari request, default ke 'SKPD' jika tidak ada filter yang dipilih
        // $filter = $request->input('filter', 'SKPD');
        $filter = $request->input('filter', 'Semua');

        // Query data berdasarkan filter yang dipilih
        $docs = DB::table('documents')
            ->when($request->input('judul'), function ($query, $judul) {
                return $query->where('judul', 'like', '%' . $judul . '%');
            })
            ->when($filter == 'SKPD', function ($query) use ($skpd) {
                // Jika filter 'SKPD' dipilih, tampilkan data berdasarkan skpd user yang login
                return $query->where('skpd', $skpd);
            })
            // Jika filter 'Semua' dipilih, tidak ada filter berdasarkan skpd
            ->orderBy('created_at', 'desc')  // Urutkan berdasarkan tanggal input terbaru
            // ->orderBy('skpd', 'asc')         // Urutkan berdasarkan nama SKPD (huruf kecil)
            ->paginate(10);

        return view('pages.documents.index', compact('docs'));
    }

    public function admin_index(Request $request)
    {

        // $users = \App\Models\User::paginate(10);
        $docs = DB::table('documents')
            ->when($request->input('judul'), function ($query, $judul ) {
                return $query->where('judul', 'like', '%'.$judul.'%' );
            })
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('pages.documents.admin_index', compact ('docs'), );
    }

    public function create()
    {
        return view('pages.documents.create');
    }

    // public function store(Request $request)
    // {
    //     // Validasi input termasuk pengecekan keunikan judul dan validasi tanggal
    //     $request->validate([
    //         'judul' => 'required|string|max:255|unique:documents,judul',
    //         'tgl_pengajuan' => 'required|date', // Validasi untuk tgl_pengajuan
    //         'pdf_file' => 'required|mimes:pdf|max:2048',
    //     ]);

    //     // Mendapatkan user yang sedang login
    //     $user = Auth::user();

    //     // Mendapatkan SKPD dari user yang login
    //     $skpd = $user->skpd;

    //     $judul = $request->input('judul');
    //     // Mendapatkan tanggal pengajuan dari request

    //     $tglPengajuan = $request->input('tgl_pengajuan');

    //     // Format tanggal pengajuan menjadi YYYYMMDD
    //     $formattedDate = date('Ymd', strtotime($tglPengajuan));

    //     // Proses upload file
    //     if ($request->hasFile('pdf_file')) {
    //         $file = $request->file('pdf_file');

    //         // Menghasilkan timestamp dalam format YYYYMMDD_HHMMSS
    //         // $timestamp = date('Ymd_Hi');

    //         // Menghasilkan nama file dengan menambahkan nama SKPD dan timestamp
    //         // $filename = $timestamp.'_'.$skpd.'_'.str_replace(' ', '_', $file->getClientOriginalName());
    //         $filename = $skpd . '_' . $formattedDate . '_' . $judul . '.pdf';

    //         // Menyimpan file dengan nama yang telah diubah
    //         $path = $file->storeAs('documents', $filename, 'public');

    //         // Simpan informasi ke database
    //         $document = new Document();
    //         $document->judul = $request->input('judul');
    //         $document->skpd = $skpd; // Menyimpan SKPD dari user yang login
    //         $document->tgl_pengajuan = $tglPengajuan; // Menyimpan tanggal pengajuan yang diinput secara manual
    //         $document->isValid = 'tidak';
    //         $document->file_name = $filename;

    //         // Membuat path file yang lengkap
    //         $baseUrl = request()->getSchemeAndHttpHost();
    //         $document->file_path = $baseUrl . '/storage/' . $path;
    //         $document->user = $user->name; // Menyimpan nama user yang login

    //         $document->save();

    //         return redirect()->route('documents.index')
    //                         ->with('success', 'PDF berhasil diupload.');
    //     }

    //     return back()->withErrors(['msg' => 'File tidak berhasil diupload']);
    // }

    public function store(Request $request)
    {
        // Validasi input termasuk pengecekan keunikan judul dan validasi tanggal
        $request->validate([
            'judul' => 'required|string|max:255|unique:documents,judul',
            'tgl_pengajuan' => 'required|date',
            'pdf_file' => 'required|mimes:pdf|max:2048', // Max 2 MB
        ]);

        // Mendapatkan user yang sedang login
        $user = Auth::user();

        // Mendapatkan SKPD dari user yang login
        $skpd = $user->skpd;

        // Format tanggal pengajuan menjadi YYYYMMDD
        $tglPengajuan = $request->input('tgl_pengajuan');
        $formattedDate = date('Ymd', strtotime($tglPengajuan));

        // Mendapatkan judul dari inputan
        $judul = $request->input('judul');

        // Proses upload file
        if ($request->hasFile('pdf_file')) {
            $file = $request->file('pdf_file');

            // Buat nama file unik berdasarkan skpd, tanggal pengajuan, dan judul
            $filename = $skpd . '_' . $formattedDate . '_' . str_replace(' ', '_', $judul) . '.pdf';

            // Menyimpan file di dalam folder 'documents' di disk public
            $path = $file->storeAs('documents', $filename, 'public');

            // Simpan informasi dokumen ke database
            $document = new Document();
            $document->judul = $judul;
            $document->skpd = $skpd;
            $document->tgl_pengajuan = $tglPengajuan;
            $document->isValid = 'tidak'; // Status default
            $document->file_name = $filename;

            // Membuat path file yang lengkap untuk diakses melalui URL
            $baseUrl = request()->getSchemeAndHttpHost();
            $document->file_path = $baseUrl . '/storage/' . $path;

            // Menyimpan informasi user yang mengupload
            $document->user = $user->name;

            // Simpan ke database
            $document->save();

            // Redirect ke halaman daftar dokumen dengan pesan sukses
            return redirect()->route('documents.index')
                            ->with('success', 'PDF berhasil diupload.');
        }

        // Jika file tidak berhasil diupload
        return back()->withErrors(['msg' => 'File tidak berhasil diupload']);
    }


}


