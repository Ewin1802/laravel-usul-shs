<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsulanShs;
use App\Http\Requests\UpdateUsulanRequest;
use App\Models\Kelompok;
use App\Models\Satuan;
use App\Models\Belanja;
use App\Models\Document;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Proses_shs;

class UsulSHSController extends Controller
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
        $shs = DB::table('usulan_shs')
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

        return view('pages.usulanSHS.index', compact('shs'));
    }

    public function admin_shs(Request $request)
    {
        $admin_shs = DB::table('usulan_shs')
            // Filter berdasarkan 'spek'
            ->when($request->input('spek'), function ($query, $spek) {
                return $query->where('spek', 'like', '%' . $spek . '%');
            })
            // Filter berdasarkan 'ket' (status)
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

        return view('pages.usulanSHS.admin_index', compact('admin_shs'));
    }

    public function admin_export_shs(Request $request)
    {
        $export_shs = DB::table('proses_shs')
            ->when($request->input('spek'), function ($query, $spek ) {
                return $query->where('spek', 'like', '%'.$spek.'%' );
            })
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('pages.usulanSHS.admin_export_shs', compact ('export_shs'), );
    }

    public function verified(Request $request, $id)
    {
        // Cari data berdasarkan ID di tabel UsulanShs
        $usulanShs = UsulanShs::findOrFail($id);

        // Ubah nilai 'ket' dari 'Proses Usul' menjadi 'Verified'
        $usulanShs->ket = 'Verified';
        $usulanShs->alasan = $request->alasan ?? null;
        $usulanShs->admin = Auth::user()->name;
        $usulanShs->save();

        // Kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Data berhasil diverifikasi.');
    }

    public function tolak(Request $request, $id)
    {
        $s = UsulanShs::findOrFail($id);
        $s->ket = 'Ditolak';
        $s->alasan = $request->alasan ?? null;
        $s->admin = Auth::user()->name;
        $s->save();

        return redirect()->route('shs.admin_shs')->with('success', 'Data berhasil ditolak.');
    }

    public function proses($id)
    {
        // Cari data berdasarkan ID di tabel UsulanShs
        $usulanShs = UsulanShs::findOrFail($id);

        // Ubah nilai 'ket' dari 'Proses Usul' menjadi 'Import SIPD'
        $usulanShs->ket = 'Disetujui';
        $usulanShs->save();

        // Pindahkan data ke tabel Proses_shs
        $prosesShs = new Proses_shs();
        $prosesShs->Kode = $usulanShs->Kode;
        $prosesShs->Uraian = $usulanShs->Uraian;
        $prosesShs->Spek = $usulanShs->Spek;
        $prosesShs->Satuan = $usulanShs->Satuan;
        $prosesShs->Harga = $usulanShs->Harga;
        $prosesShs->akun_belanja = $usulanShs->akun_belanja;
        $prosesShs->rekening_1 = $usulanShs->rekening_1;
        $prosesShs->Document = $usulanShs->Document;
        $prosesShs->user = $usulanShs->user;
        $prosesShs->skpd = $usulanShs->skpd;
        $prosesShs->Kelompok = $usulanShs->Kelompok;
        $prosesShs->nilai_tkdn = $usulanShs->nilai_tkdn;
        $prosesShs->ket = $usulanShs->ket;
        $prosesShs->save();

        // Kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Data berhasil diproses dan segera Disetujui.');
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

         return view('pages.usulanSHS.create', compact('documents', 'kelompoks', 'satuans', 'belanjas'));
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

        // Buat instance baru dari model UsulanShs
        $usulanShs = new UsulanShs();
        $usulanShs->Kode = $request->input('Kode');
        $usulanShs->Uraian = $kelompok ? $kelompok->Uraian : null;

        $usulanShs->Spek = $request->input('Spek');
        $usulanShs->Satuan = $satuan ? $satuan->satuan : null;

        // Bersihkan format pemisah ribuan dari input harga
        $cleanedHarga = str_replace('.', '', $request->input('Harga'));
        $usulanShs->Harga = $cleanedHarga;

        $usulanShs->akun_belanja = $request->input('akun_belanja');
        $usulanShs->rekening_1 = $rekening_1 ? $rekening_1->Rekening : null;
        $usulanShs->Kelompok = 1;
        $usulanShs->nilai_tkdn = $request->input('nilai_tkdn');
        $usulanShs->Document = $doc ? $doc->judul : null;
        $usulanShs->ket = 'Proses Usul';
        $usulanShs->user = Auth::user()->name;
        $usulanShs->skpd = Auth::user()->skpd;

        // Simpan data ke database
        $usulanShs->save();

        // Redirect ke route 'shs.index' dengan pesan sukses
        return redirect()->route('shs.index')->with('success', 'Data Berhasil dikirim');
    }

    public function destroy($id)
    {
        $shs = UsulanShs::findOrFail($id);
        $shs->delete();
        return redirect()->route('shs.admin_shs')->with('success', 'Item successfully deleted');
    }

    public function edit($id)
    {
        // Ambil data usulan berdasarkan ID
        $usulan = UsulanShs::findOrFail($id);

        // Ambil SKPD dari usulanSHS
        $usulanSkpd = $usulan->skpd;

        // Ambil dokumen yang sesuai dengan SKPD dari usulan yang sedang diedit
        $documents = Document::where('skpd', $usulanSkpd) // Dokumen yang memiliki SKPD yang sama dengan usulan
            ->orderBy('created_at', 'desc') // Mengurutkan secara descending berdasarkan 'created_at'
            ->get();

        // Ambil data kelompok, satuan, belanja untuk dropdown
        $kelompoks = Kelompok::all();
        $satuans = Satuan::all();
        $belanjas = Belanja::all();

        // Return ke view dengan data yang telah diambil
        return view('pages.usulanSHS.admin_edit', compact('usulan', 'kelompoks', 'satuans', 'belanjas', 'documents'));
    }

    public function update(UpdateUsulanRequest $request, UsulanShs $usulan)
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

        return redirect()->route('shs.admin_shs')->with('success', 'SSH successfully updated');
    }

    public function edituser($id)
    {
        $userSkpd = Auth::user()->skpd;  // Ambil SKPD pengguna yang login

        // Ambil data usulan yang sesuai dengan ID
        $usulan = UsulanShs::find($id);

        // Cek apakah usulan ditemukan dan apakah SKPD cocok
        if (!$usulan || $usulan->skpd != $userSkpd) {
            // Jika data tidak ditemukan atau SKPD berbeda, arahkan kembali dengan pesan error
            return redirect()->route('shs.index')->with('error', 'Anda tidak diizinkan untuk mengedit data dari SKPD lain. Sini, mo Kuti !');
        }

        // Ambil dokumen yang sesuai dengan SKPD pengguna yang login
        $documents = Document::where('skpd', $userSkpd)
            ->orderBy('created_at', 'desc')
            ->get();

        // Ambil data untuk dropdown
        $kelompoks = Kelompok::all();
        $satuans = Satuan::all();
        $belanjas = Belanja::all();

        return view('pages.usulanSHS.edit', compact('usulan', 'kelompoks', 'satuans', 'belanjas', 'documents'));
    }

    public function updateuser(UpdateUsulanRequest $request, $id)
    {
        $userSkpd = Auth::user()->skpd;  // Ambil SKPD pengguna yang login

        // Ambil data usulan yang sesuai dengan ID dan SKPD pengguna yang login
        $usulan = UsulanShs::where('id', $id)->where('skpd', $userSkpd)->firstOrFail();

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

        return redirect()->route('shs.index')->with('success', 'SSH successfully updated');
    }

    // public function showData()
    // {
    //     $totalUsulbaruShs = UsulanShs::where('ket', 'Proses Usul')->count();
    //     $totalUsulbaruSbu = UsulanSbu::where('ket', 'Proses Usul')->count();
    //     $totalUsulbaruAsb = UsulanAsb::where('ket', 'Proses Usul')->count();
    //     $totalUsulbaruHspk = UsulanHspk::where('ket', 'Proses Usul')->count();

    //     return view('pages.dashboard', compact('totalUsulbaruShs', 'totalUsulbaruSbu', 'totalUsulbaruAsb', 'totalUsulbaruHspk'));
    // }


}
