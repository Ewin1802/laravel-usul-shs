<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Document;
use App\Models\ContohSurat;
use App\Models\User;
use App\Models\UsulanShs;
use App\Models\UsulanSbu;
use App\Models\UsulanAsb;
use App\Models\UsulanHspk;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{

    public function index(Request $request)
    {
        // // Ambil informasi user yang sedang login
        // $user = Auth::user();  // Ambil informasi user yang login
        // $skpd = $user->skpd;   // Ambil nilai 'skpd' dari user yang login (huruf kecil)

        // // Dapatkan filter dari request, default ke 'SKPD' jika tidak ada filter yang dipilih
        // // $filter = $request->input('filter', 'SKPD');
        // $filter = $request->input('filter', 'Semua');

        // // Query data berdasarkan filter yang dipilih
        // $docs = DB::table('documents')
        //     ->when($request->input('judul'), function ($query, $judul) {
        //         return $query->where('judul', 'like', '%' . $judul . '%');
        //     })
        //     ->when($filter == 'SKPD', function ($query) use ($skpd) {
        //         // Jika filter 'SKPD' dipilih, tampilkan data berdasarkan skpd user yang login
        //         return $query->where('skpd', $skpd);
        //     })
        //     // Jika filter 'Semua' dipilih, tidak ada filter berdasarkan skpd
        //     ->orderBy('created_at', 'desc')  // Urutkan berdasarkan tanggal input terbaru
        //     // ->orderBy('skpd', 'asc')         // Urutkan berdasarkan nama SKPD (huruf kecil)
        //     ->paginate(10);

        // $contohSurats = DB::table('contoh_surats')
        //     ->orderBy('id', 'desc')
        //     ->paginate(10); // Jika Anda ingin menggunakan pagination untuk contoh_surats juga

        // return view('pages.documents.index', compact('docs'));

        // Ambil informasi user yang sedang login
        $user = Auth::user();
        $skpd = $user->skpd;   // Ambil nilai 'skpd' dari user yang login

        // Ambil data documents hanya berdasarkan SKPD user login
        $docs = DB::table('documents')
            ->where('skpd', $skpd)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Jika contoh_surats tidak dipakai, bisa dihapus
        // Kalau masih dipakai, boleh tetap disertakan
        $contohSurats = DB::table('contoh_surats')
            ->orderBy('id', 'desc')
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

    public function createContohSurat()
    {
        return view('pages.documents.createContohSurat');
    }

    public function upload(Request $request)
    {
        // Validasi input termasuk pengecekan keunikan judul dan validasi tipe file
        $request->validate([
            'judul' => 'required|string|max:255|unique:contoh_surats,judul',
            'file' => 'required|mimes:pdf,doc,docx|max:2048', // Max 2 MB dan mendukung PDF serta Word
        ]);

        // Mendapatkan user yang sedang login
        $user = Auth::user();
        // Mendapatkan judul dari inputan
        $judul = $request->input('judul');

        // Proses upload file
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Mendapatkan ekstensi file untuk memastikan penamaan yang benar
            $extension = $file->getClientOriginalExtension();

            // Buat nama file unik berdasarkan user, tanggal pengajuan, dan judul
            $filename = $user->id . '_' . str_replace(' ', '_', $judul) . '.' . $extension;

            // Menyimpan file di dalam folder 'contohsurat' di disk public
            $path = $file->storeAs('contohsurat', $filename, 'public');

            // Cek apakah ada entri berdasarkan judul atau pengguna yang sedang login
            $document = ContohSurat::where('judul', $judul)->first();

            if ($document) {
                // Jika sudah ada, hapus file lama dari storage
                Storage::disk('public')->delete('contohsurat/' . $document->file_name);

                // Perbarui informasi dokumen dengan yang baru
                $document->judul = $judul;
                $document->file_name = $filename;

                // Membuat path file yang lengkap untuk diakses melalui URL
                $baseUrl = request()->getSchemeAndHttpHost();
                $document->file_path = $baseUrl . '/storage/' . $path;

                // Menyimpan informasi user yang mengupload
                $document->user = $user->name;
            } else {
                // Jika belum ada, buat entri baru di tabel
                $document = new ContohSurat();
                $document->judul = $judul;
                $document->file_name = $filename;

                // Membuat path file yang lengkap untuk diakses melalui URL
                $baseUrl = request()->getSchemeAndHttpHost();
                $document->file_path = $baseUrl . '/storage/' . $path;

                // Menyimpan informasi user yang mengupload
                $document->user = $user->name;
            }

            // Simpan atau update ke database
            $document->save();

            // Redirect ke halaman daftar dokumen dengan pesan sukses
            return redirect()->route('docs_admin')
                            ->with('success', 'File Contoh Surat berhasil diupload.');
        }

        // Jika file tidak berhasil diupload
        return back()->withErrors(['msg' => 'File tidak berhasil diupload']);
    }

    public function download()
    {
        // Ambil contoh surat terbaru (atau sesuaikan query jika Anda ingin mengambil file tertentu)
        $contohSurat = ContohSurat::latest()->first();

        // Cek apakah contoh surat ada dan file-nya masih ada di penyimpanan
        if ($contohSurat && Storage::disk('public')->exists('contohsurat/' . $contohSurat->file_name)) {
            // Menggunakan Storage::download untuk mengunduh file
            return Storage::disk('public')->download('contohsurat/' . $contohSurat->file_name, $contohSurat->file_name);
        }

        // Jika file tidak ditemukan, bisa mengembalikan pesan error atau redirect dengan pesan
        return redirect()->back()->with('error', 'File contoh surat tidak ditemukan.');
    }

    public function destroy($id)
    {
        $document = Document::findOrFail($id);

        // Cek apakah dokumen sudah digunakan di salah satu tabel usulan
        $judul = $document->judul;

        $usedInSHS   = UsulanShs::where('Document', $judul)->exists();
        $usedInSBUS  = UsulanSbu::where('Document', $judul)->exists();
        $usedInASBS  = UsulanAsb::where('Document', $judul)->exists();
        $usedInHSPKS = UsulanHspk::where('Document', $judul)->exists();

        $user = auth()->user();

        if ($usedInSHS || $usedInSBUS || $usedInASBS || $usedInHSPKS) {
            if ($user->role === 'ADMIN') {
                return redirect()->route('docs_admin')->with('error', 'Dokumen sudah digunakan dalam salah satu usulan dan tidak dapat dihapus.');
            } elseif ($user->role === 'SKPD') {
                return redirect()->route('documents.index')->with('error', 'Dokumen sudah digunakan dalam salah satu usulan dan tidak dapat dihapus.');
            }

            return redirect()->back()->with('error', 'Dokumen sudah digunakan dalam salah satu usulan. Silahkan hapus inputan yang berkaitan dengan surat ini.');
        }

        // Ambil path file relatif dari storage
        $relativePath = str_replace(request()->getSchemeAndHttpHost() . '/storage/', '', $document->file_path);

        // Hapus file dari storage jika ada
        if ($relativePath && Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }

        // Hapus entri dokumen dari database
        $document->delete();

        // Cek role user
        if ($user->role === 'ADMIN') {
            return redirect()->route('docs_admin')->with('success', 'Data Usulan berhasil dihapus.');
        } elseif ($user->role === 'SKPD') {
            return redirect()->route('documents.index')->with('success', 'Data Usulan berhasil dihapus.');
        }

        return redirect()->back()->with('success', 'Dokumen dan file terkait berhasil dihapus.');
    }




}


