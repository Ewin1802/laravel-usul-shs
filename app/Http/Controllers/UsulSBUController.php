<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelompok;
use App\Models\Satuan;
use App\Models\Belanja;
use App\Models\Document;
use App\Models\UsulanSbu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Proses_sbu;
use App\Http\Requests\UpdateUsulanRequest;

class UsulSBUController extends Controller
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
        $sbu = DB::table('usulan_sbus')
            ->when($request->input('spek'), function ($query, $spek) {
                return $query->where('spek', 'like', '%' . $spek . '%');
            })
            ->when($filter == 'SKPD', function ($query) use ($skpd) {
                // Jika filter 'SKPD' dipilih, tampilkan data berdasarkan skpd user yang login
                return $query->where('skpd', $skpd);
            })
            // Jika filter 'Semua' dipilih, tidak ada filter berdasarkan skpd
            ->orderBy('created_at', 'desc')  // Urutkan berdasarkan tanggal input terbaru
            // ->orderBy('skpd', 'asc')         // Urutkan berdasarkan nama SKPD (huruf kecil)
            ->paginate(10);

        return view('pages.usulanSBU.index', compact('sbu'));
    }

    public function create()
    {
        // Ambil SKPD dari pengguna yang sedang login
        $userSkpd = Auth::user()->skpd;

        // Ambil dokumen yang hanya sesuai dengan SKPD pengguna yang login dan urutkan secara descending
        $documents = Document::where('skpd', $userSkpd)
        ->orderBy('created_at', 'desc') // Mengurutkan berdasarkan kolom 'created_at' secara descending
        ->get();

        // Ambil data lainnya jika diperlukan
        $kelompoks = Kelompok::all();
        $satuans = Satuan::all();
        $belanjas = Belanja::all();

        return view('pages.usulanSBU.create', compact('documents', 'kelompoks', 'satuans', 'belanjas'));
    }

    public function store(Request $request)
    {
        // Debug untuk melihat semua input yang diterima
        // dd($request->all());

        // Ambil data dari tabel lain menggunakan model
        $kelompok = Kelompok::where('Uraian', $request->input('Uraian'))->first();
        $satuan = Satuan::where('satuan', $request->input('Satuan'))->first();
        $doc = Document::where('judul', trim($request->input('Document')))->first();
        $rekening_1 = Belanja::where('Rekening', $request->input('rekening_1'))->first();

        // Debugging untuk memastikan dokumen ditemukan
        // dd($doc);

        if (!$doc) {
            return redirect()->back()->withErrors(['Document' => 'Dokumen tidak ditemukan.'])->withInput();
        }

        // Buat instance baru dari model usulanSbu
        $usulanSbu = new UsulanSbu();
        $usulanSbu->Kode = $request->input('Kode');
        $usulanSbu->Uraian = $kelompok ? $kelompok->Uraian : null;

        $usulanSbu->Spek = $request->input('Spek');
        $usulanSbu->Satuan = $satuan ? $satuan->satuan : null;

        // Bersihkan format pemisah ribuan dari input harga
        $cleanedHarga = str_replace('.', '', $request->input('Harga'));
        $usulanSbu->Harga = $cleanedHarga;

        $usulanSbu->akun_belanja = $request->input('akun_belanja');
        $usulanSbu->rekening_1 = $rekening_1 ? $rekening_1->Rekening : null;
        $usulanSbu->Kelompok = 4;
        $usulanSbu->nilai_tkdn = $request->input('nilai_tkdn');
        $usulanSbu->Document = $doc ? $doc->judul : null;
        $usulanSbu->ket = 'Proses Usul';
        $usulanSbu->user = Auth::user()->name;
        $usulanSbu->skpd = Auth::user()->skpd;

        // Simpan data ke database
        $usulanSbu->save();

        // Redirect ke route 'shs.index' dengan pesan sukses
        return redirect()->route('sbu.index')->with('success', 'Data Berhasil dikirim');
    }

    public function admin_sbu(Request $request)
    {
        $admin_sbu = DB::table('usulan_sbus')
            ->when($request->input('spek'), function ($query, $spek ) {
                return $query->where('spek', 'like', '%'.$spek.'%' );
            })
            ->when($request->input('filter'), function ($query, $filter) {
                if ($filter == 'Usul Baru') {
                    return $query->where('ket', 'Proses Usul');
                } elseif ($filter == 'Disetujui') {
                    return $query->where('ket', 'Disetujui');
                } elseif ($filter == 'Ditolak') {
                    return $query->where('ket', 'Ditolak');
                }
            })
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('pages.usulanSBU.admin_index', compact ('admin_sbu'), );
    }

    public function admin_export_sbu(Request $request)
    {
        $export_sbu = DB::table('proses_sbus')
            ->when($request->input('spek'), function ($query, $spek ) {
                return $query->where('spek', 'like', '%'.$spek.'%' );
            })
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('pages.usulanSBU.admin_export_sbu', compact ('export_sbu'), );
    }

    public function proses($id)
    {
        // Cari data berdasarkan ID di tabel UsulanShs
        $usulanSbu = UsulanSbu::findOrFail($id);

        // Ubah nilai 'ket' dari 'Proses Usul' menjadi 'Import SIPD'
        $usulanSbu->ket = 'Disetujui';
        $usulanSbu->save();

        // Pindahkan data ke tabel Proses_sbu
        $prosesSbu = new Proses_sbu();
        $prosesSbu->Kode = $usulanSbu->Kode;
        $prosesSbu->Uraian = $usulanSbu->Uraian;
        $prosesSbu->Spek = $usulanSbu->Spek;
        $prosesSbu->Satuan = $usulanSbu->Satuan;
        $prosesSbu->Harga = $usulanSbu->Harga;
        $prosesSbu->akun_belanja = $usulanSbu->akun_belanja;
        $prosesSbu->rekening_1 = $usulanSbu->rekening_1;
        $prosesSbu->Document = $usulanSbu->Document;
        $prosesSbu->user = $usulanSbu->user;
        $prosesSbu->skpd = $usulanSbu->skpd;
        $prosesSbu->Kelompok = $usulanSbu->Kelompok;
        $prosesSbu->nilai_tkdn = $usulanSbu->nilai_tkdn;
        $prosesSbu->ket = $usulanSbu->ket;
        $prosesSbu->save();

        // Kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Data berhasil diproses dan segera Disetujui.');
    }

    public function verified(Request $request, $id)
    {
        // Cari data berdasarkan ID di tabel usulanSbu
        $usulanSbu = UsulanSbu::findOrFail($id);

        // Ubah nilai 'ket' dari 'Proses Usul' menjadi 'Verified'
        $usulanSbu->ket = 'Verified';
        $usulanSbu->alasan = $request->alasan ?? null;
        $usulanSbu->admin = Auth::user()->name;
        $usulanSbu->save();

        // Kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Data berhasil diverifikasi.');
    }

    public function tolak(Request $request, $id)
    {
        $s = UsulanSbu::findOrFail($id);
        $s->ket = 'Ditolak';
        $s->alasan = $request->alasan ?? null;
        $s->admin = Auth::user()->name;
        $s->save();

        return redirect()->route('sbu.admin_sbu')->with('success', 'Data berhasil ditolak.');
    }

    public function destroy($id)
    {
        $shs = UsulanSbu::findOrFail($id);
        $shs->delete();
        return redirect()->route('sbu.admin_sbu')->with('success', 'Item successfully deleted');
    }

    public function edit($id)
    {
        $usulan = UsulanSbu::findOrFail($id);

        // Ambil SKPD dari usulanSHS
        $usulanSkpd = $usulan->skpd;

        // Ambil dokumen yang sesuai dengan SKPD dari usulan yang sedang diedit
        $documents = Document::where('skpd', $usulanSkpd) // Dokumen yang memiliki SKPD yang sama dengan usulan
            ->orderBy('created_at', 'desc') // Mengurutkan secara descending berdasarkan 'created_at'
            ->get();

        $kelompoks = Kelompok::all();         // Ambil data kelompok untuk dropdown
        $satuans = Satuan::all();             // Ambil data satuan untuk dropdown
        $belanjas = Belanja::all();           // Ambil data belanja untuk dropdown
        return view('pages.usulanSBU.admin_edit', compact('usulan', 'kelompoks', 'satuans', 'belanjas', 'documents'));
    }

    public function update(UpdateUsulanRequest $request, UsulanSbu $usulan)
    {
        // Ambil data yang tervalidasi dari request
        // dd($usulan->user);
        // dd($usulan);
        $data = $request->validated();

        // Pastikan harga yang dikirim ke server tidak memiliki pemisah ribuan
        $data['Harga'] = preg_replace('/\./', '', $data['Harga']); // Hapus titik pemisah ribuan

        // Gunakan nilai dari database jika field tertentu tidak diisi
        $data['user'] = $data['user'] ?? $usulan->user;
        $data['skpd'] = $data['skpd'] ?? $usulan->skpd;
        $data['ket'] = $data['ket'] ?? $usulan->ket;
        $data['alasan'] = $data['alasan'] ?? $usulan->alasan;
        $data['Kelompok'] = $data['Kelompok'] ?? $usulan->Kelompok;
        $data['akun_belanja'] = $data['akun_belanja'] ?? $usulan->akun_belanja;

        // Update model dengan data baru atau data lama
        $usulan->fill($data);
        // dd($usulan->getAttributes());
        $usulan->save();

        return redirect()->route('sbu.admin_sbu')->with('success', 'SBU successfully updated');
    }

    public function edituser($id)
    {
        $userSkpd = Auth::user()->skpd;  // Ambil SKPD pengguna yang login

        // Ambil data usulan yang sesuai dengan ID
        $usulan = UsulanSbu::find($id);

        // Cek apakah usulan ditemukan dan apakah SKPD cocok
        if (!$usulan || $usulan->skpd != $userSkpd) {
            // Jika data tidak ditemukan atau SKPD berbeda, arahkan kembali dengan pesan error
            return redirect()->route('sbu.index')->with('error', 'Anda tidak diizinkan untuk mengedit data dari SKPD lain. Sini, mo Kuti !');
        }

        // Ambil dokumen yang sesuai dengan SKPD pengguna yang login
        $documents = Document::where('skpd', $userSkpd)
            ->orderBy('created_at', 'desc')
            ->get();

        // Ambil data untuk dropdown
        $kelompoks = Kelompok::all();
        $satuans = Satuan::all();
        $belanjas = Belanja::all();

        return view('pages.usulanSBU.edit', compact('usulan', 'kelompoks', 'satuans', 'belanjas', 'documents'));
    }

    public function updateuser(UpdateUsulanRequest $request, $id)
    {
        $userSkpd = Auth::user()->skpd;  // Ambil SKPD pengguna yang login

        // Ambil data usulan yang sesuai dengan ID dan SKPD pengguna yang login
        $usulan = UsulanSbu::where('id', $id)->where('skpd', $userSkpd)->firstOrFail();

        // Ambil data yang tervalidasi dari request
        $data = $request->validated();

        // Pastikan harga yang dikirim ke server tidak memiliki pemisah ribuan
        $data['Harga'] = preg_replace('/\./', '', $data['Harga']); // Hapus titik pemisah ribuan

        // Gunakan nilai dari database jika field tertentu tidak diisi
        $data['user'] = $data['user'] ?? $usulan->user;
        $data['skpd'] = $data['skpd'] ?? $usulan->skpd;
        $data['ket'] = $data['ket'] ?? $usulan->ket;
        $data['alasan'] = $data['alasan'] ?? $usulan->alasan;
        $data['Kelompok'] = $data['Kelompok'] ?? $usulan->Kelompok;
        $data['akun_belanja'] = $data['akun_belanja'] ?? $usulan->akun_belanja;

        // Update model dengan data baru atau data lama
        $usulan->fill($data);
        $usulan->save();

        return redirect()->route('sbu.index')->with('success', 'SBU successfully updated');
    }
}
