<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelompok;
use App\Models\Satuan;
use App\Models\Belanja;
use App\Models\Document;
use App\Models\UsulanHspk;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Proses_hspk;
use App\Http\Requests\UpdateUsulanRequest;

class UsulHSPKController extends Controller
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
        $hspk = DB::table('usulan_hspks')
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

        return view('pages.usulanHSPK.index', compact('hspk'));
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

        return view('pages.usulanHSPK.create', compact('documents', 'kelompoks', 'satuans', 'belanjas'));
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

        // Buat instance baru dari model usulanHspk
        $usulanHspk = new UsulanHspk();
        $usulanHspk->Kode = $request->input('Kode');
        $usulanHspk->Uraian = $kelompok ? $kelompok->Uraian : null;

        $usulanHspk->Spek = $request->input('Spek');
        $usulanHspk->Satuan = $satuan ? $satuan->satuan : null;

        // Bersihkan format pemisah ribuan dari input harga
        $cleanedHarga = str_replace('.', '', $request->input('Harga'));
        $usulanHspk->Harga = $cleanedHarga;

        $usulanHspk->akun_belanja = $request->input('akun_belanja');
        $usulanHspk->rekening_1 = $rekening_1 ? $rekening_1->Rekening : null;
        $usulanHspk->Kelompok = 3;
        $usulanHspk->nilai_tkdn = $request->input('nilai_tkdn');
        $usulanHspk->Document = $doc ? $doc->judul : null;
        $usulanHspk->ket = 'Proses Usul';
        $usulanHspk->user = Auth::user()->name;
        $usulanHspk->skpd = Auth::user()->skpd;

        // Simpan data ke database
        $usulanHspk->save();

        // Redirect ke route 'shs.index' dengan pesan sukses
        return redirect()->route('hspk.index')->with('success', 'Data Berhasil dikirim');
    }

    public function admin_hspk(Request $request)
    {
        $admin_hspk = DB::table('usulan_hspks')
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
        return view('pages.usulanHSPK.admin_index', compact ('admin_hspk'), );
    }

    public function admin_export_hspk(Request $request)
    {
        $export_hspk = DB::table('proses_hspks')
            ->when($request->input('spek'), function ($query, $spek ) {
                return $query->where('spek', 'like', '%'.$spek.'%' );
            })
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('pages.usulanHSPK.admin_export_hspk', compact ('export_hspk'), );
    }

    public function proses($id)
    {
        // Cari data berdasarkan ID di tabel UsulanShs
        $usulanHspk = UsulanHspk::findOrFail($id);

        // Ubah nilai 'ket' dari 'Proses Usul' menjadi 'Disetujui'
        $usulanHspk->ket = 'Disetujui';
        $usulanHspk->save();

        // Pindahkan data ke tabel Proses_hspk
        $prosesHspk = new Proses_hspk();
        $prosesHspk->Kode = $usulanHspk->Kode;
        $prosesHspk->Uraian = $usulanHspk->Uraian;
        $prosesHspk->Spek = $usulanHspk->Spek;
        $prosesHspk->Satuan = $usulanHspk->Satuan;
        $prosesHspk->Harga = $usulanHspk->Harga;
        $prosesHspk->akun_belanja = $usulanHspk->akun_belanja;
        $prosesHspk->rekening_1 = $usulanHspk->rekening_1;
        $prosesHspk->Document = $usulanHspk->Document;
        $prosesHspk->Kelompok = $usulanHspk->Kelompok;
        $prosesHspk->nilai_tkdn = $usulanHspk->nilai_tkdn;
        $prosesHspk->ket = $usulanHspk->ket;
        $prosesHspk->user = $usulanHspk->user;
        $prosesHspk->skpd = $usulanHspk->skpd;
        $prosesHspk->save();

        // Kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Data berhasil diproses dan segera Disetujui.');
    }

    public function verified(Request $request, $id)
    {
        // Cari data berdasarkan ID di tabel usulanSbu
        $usulanHspk = UsulanHspk::findOrFail($id);

        // Ubah nilai 'ket' dari 'Proses Usul' menjadi 'Verified'
        $usulanHspk->ket = 'Verified';
        $usulanHspk->alasan = $request->alasan ?? null;
        $usulanHspk->admin = Auth::user()->name;
        $usulanHspk->save();

        // Kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Data berhasil diverifikasi.');
    }

    public function tolak(Request $request, $id)
    {
        $s = UsulanHspk::findOrFail($id);
        $s->ket = 'Ditolak';
        $s->alasan = $request->alasan ?? null;
        $s->admin = Auth::user()->name;
        $s->save();

        return redirect()->route('hspk.admin_hspk')->with('success', 'Data berhasil ditolak.');
    }

    public function destroy($id)
    {
        $hspk = UsulanHspk::findOrFail($id);
        $hspk->delete();
        return redirect()->route('hspk.admin_hspk')->with('success', 'Item successfully deleted');
    }

    public function edit($id)
    {
        // Ambil data usulan berdasarkan ID
        $usulan = UsulanHspk::findOrFail($id); // Ambil data usulan berdasarkan ID

        // Ambil SKPD dari usulanSHS
        $usulanSkpd = $usulan->skpd;

        // Ambil dokumen yang sesuai dengan SKPD dari usulan yang sedang diedit
        $documents = Document::where('skpd', $usulanSkpd) // Dokumen yang memiliki SKPD yang sama dengan usulan
            ->orderBy('created_at', 'desc') // Mengurutkan secara descending berdasarkan 'created_at'
            ->get();

        $kelompoks = Kelompok::all();         // Ambil data kelompok untuk dropdown
        $satuans = Satuan::all();             // Ambil data satuan untuk dropdown
        $belanjas = Belanja::all();           // Ambil data belanja untuk dropdown
        return view('pages.usulanHSPK.admin_edit', compact('usulan', 'kelompoks', 'satuans', 'belanjas', 'documents'));
    }

    public function update(UpdateUsulanRequest $request, UsulanHspk $usulan)
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

        return redirect()->route('hspk.admin_hspk')->with('success', 'hspk successfully updated');
    }

    public function edituser($id)
    {
        $userSkpd = Auth::user()->skpd;  // Ambil SKPD pengguna yang login

        // Ambil data usulan yang sesuai dengan ID
        $usulan = UsulanHspk::find($id);

        // Cek apakah usulan ditemukan dan apakah SKPD cocok
        if (!$usulan || $usulan->skpd != $userSkpd) {
            // Jika data tidak ditemukan atau SKPD berbeda, arahkan kembali dengan pesan error
            return redirect()->route('hspk.index')->with('error', 'Anda tidak diizinkan untuk mengedit data dari SKPD lain. Sini, mo Kuti !');
        }

        // Ambil dokumen yang sesuai dengan SKPD pengguna yang login
        $documents = Document::where('skpd', $userSkpd)
            ->orderBy('created_at', 'desc')
            ->get();

        // Ambil data untuk dropdown
        $kelompoks = Kelompok::all();
        $satuans = Satuan::all();
        $belanjas = Belanja::all();

        return view('pages.usulanHSPK.edit', compact('usulan', 'kelompoks', 'satuans', 'belanjas', 'documents'));
    }

    public function updateuser(UpdateUsulanRequest $request, $id)
    {
        $userSkpd = Auth::user()->skpd;  // Ambil SKPD pengguna yang login

        // Ambil data usulan yang sesuai dengan ID dan SKPD pengguna yang login
        $usulan = UsulanHspk::where('id', $id)->where('skpd', $userSkpd)->firstOrFail();

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

        return redirect()->route('hspk.index')->with('success', 'HSPK successfully updated');
    }
}
