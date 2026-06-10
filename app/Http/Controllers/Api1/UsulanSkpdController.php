<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UsulanShs;
use App\Models\Proses_shs;
use App\Models\UsulanSbu;
use App\Models\Proses_sbu;
use App\Models\UsulanAsb;
use App\Models\Proses_asb;
use App\Models\UsulanHspk;
use App\Models\Proses_hspk;


class UsulanSkpdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function data_shs(Request $request)
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Ambil data UsulanShs dengan filter
        $data = \App\Models\UsulanShs::when($request->id, function ($query, $id) {
                return $query->where('id', $id);
            })
            ->when($user->skpd !== 'KABAN' && $user->skpd !== 'AllSKPD', function ($query) use ($user) {
                // Memfilter berdasarkan nama pengguna yang login jika skpd bukan KABAN atau AllSKPD
                return $query->where('user', $user->name);
            })
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function data_sbu(Request $request)
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Ambil data UsulanShs
        $data = \App\Models\UsulanSbu::when($request->id, function($query, $id) {
                return $query->where('id', $id);
            })
            ->when($user->skpd !== 'KABAN' && $user->skpd !== 'AllSKPD', function ($query) use ($user) {
                // Memfilter berdasarkan nama pengguna yang login jika skpd bukan KABAN atau AllSKPD
                return $query->where('user', $user->name);
            })
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function data_asb(Request $request)
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Ambil data UsulanShs
        $data = \App\Models\UsulanAsb::when($request->id, function($query, $id) {
                return $query->where('id', $id);
            })
            ->when($user->skpd !== 'KABAN' && $user->skpd !== 'AllSKPD', function ($query) use ($user) {
                // Memfilter berdasarkan nama pengguna yang login jika skpd bukan KABAN atau AllSKPD
                return $query->where('user', $user->name);
            })
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function data_hspk(Request $request)
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Ambil data UsulanShs
        $data = \App\Models\UsulanHspk::when($request->id, function($query, $id) {
                return $query->where('id', $id);
            })
            ->when($user->skpd !== 'KABAN' && $user->skpd !== 'AllSKPD', function ($query) use ($user) {
                // Memfilter berdasarkan nama pengguna yang login jika skpd bukan KABAN atau AllSKPD
                return $query->where('user', $user->name);
            })
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function verifiedShs(Request $request, $id)
    {
        // Mendapatkan pengguna yang terautentikasi
        $user = $request->user();

        // Cari data UsulanShs berdasarkan ID
        $usulanShs = UsulanShs::find($id);

        if (!$usulanShs) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        // Update kolom 'admin' dengan nama pengguna yang login
        $usulanShs->admin = $user->name;
        $usulanShs->ket = 'Verified';

        // Mengecek apakah user memberikan alasan baru
        $alasanUser = $request->input('alasan', null);

        // Jika user memberikan alasan baru, gunakan alasan tersebut
        // Jika tidak, gunakan nilai awal dari $usulanShs->alasan
        if (!is_null($alasanUser) && $alasanUser !== '') {
            $usulanShs->alasan = $alasanUser;
        } else {
            // Jika tidak ada alasan baru dari user, tetap pakai alasan yang ada (jika null, tetap null)
            $usulanShs->alasan = $usulanShs->alasan;
        }

        $usulanShs->updated_at = now(); // update timestamp

        // Simpan perubahan ke database
        $usulanShs->save();

        // Mengirimkan respon sukses
        return response()->json([
            'message' => 'Data Usulan berhasil diverifikasi',
            'data' => $usulanShs,
        ]);
    }

    public function approveShs(Request $request, $id)
    {
        // Mendapatkan pengguna yang terautentikasi
        $user = $request->user();

        // Cari data UsulanShs berdasarkan ID
        $usulanShs = UsulanShs::find($id);

        // Cek apakah data UsulanShs ditemukan
        if (!$usulanShs) {
            return response()->json(['message' => 'Data UsulanShs tidak ditemukan'], 404);
        }

        // Cek apakah ada item di Proses_shs dengan uraian, spek, satuan, dan harga yang sama
        $existingProsesShs = Proses_shs::where('Uraian', $usulanShs->Uraian)
            ->where('Spek', $usulanShs->Spek)
            ->where('Satuan', $usulanShs->Satuan)
            ->where('Harga', $usulanShs->Harga)
            ->first();

        // Jika sudah ada, kembalikan respon bahwa data sudah ada
        if ($existingProsesShs) {
            return response()->json([
                'message' => 'Item dengan uraian, spek, satuan, dan harga yang sama sudah ada di Proses_shs'
            ], 400);
        }

        // Update kolom 'disetujui' dengan nama pengguna yang login
        $usulanShs->disetujui = $user->name;
        $usulanShs->ket = 'Disetujui';
        $usulanShs->updated_at = now(); // update timestamp

        // Simpan perubahan ke database
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
        $prosesShs->admin = $usulanShs->admin;
        $prosesShs->disetujui = $usulanShs->disetujui;
        $prosesShs->Kelompok = $usulanShs->Kelompok;
        $prosesShs->nilai_tkdn = $usulanShs->nilai_tkdn;
        $prosesShs->ket = $usulanShs->ket;

        // Simpan data ke tabel Proses_shs
        $prosesShs->save();

        // Mengirimkan respon sukses
        return response()->json([
            'message' => 'Data berhasil diupdate dan dipindahkan ke tabel Proses_shs',
            'data' => $prosesShs,
        ]);
    }

    public function tolakShs(Request $request, $id)
    {
        // Mendapatkan pengguna yang terautentikasi
        $user = $request->user();

        // Cari data UsulanShs berdasarkan ID
        $usulanShs = UsulanShs::find($id);

        if (!$usulanShs) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        // Update kolom 'disetujui' dengan nama pengguna yang login
        $usulanShs->disetujui = $user->name;
        $usulanShs->ket = 'Ditolak';

        // Mengecek apakah user memberikan alasan baru
        $alasanUser = $request->input('alasan', null);

        // Jika user memberikan alasan baru, gunakan alasan tersebut
        // Jika tidak, gunakan nilai awal dari $usulanShs->alasan
        if (!is_null($alasanUser) && $alasanUser !== '') {
            $usulanShs->alasan = $alasanUser;
        } else {
            // Jika tidak ada alasan baru dari user, tetap pakai alasan yang ada (jika null, tetap null)
            $usulanShs->alasan = $usulanShs->alasan;
        }

        $usulanShs->updated_at = now(); // update timestamp

        // Simpan perubahan ke database
        $usulanShs->save();

        // Mengirimkan respon sukses
        return response()->json([
            'message' => 'Data Usulan ditolak',
            'data' => $usulanShs,
        ]);
    }

    public function verifiedSbu(Request $request, $id)
    {
        // Mendapatkan pengguna yang terautentikasi
        $user = $request->user();

        // Cari data usulanSbu berdasarkan ID
        $usulanSbu = UsulanSbu::find($id);

        if (!$usulanSbu) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        // Update kolom 'admin' dengan nama pengguna yang login
        $usulanSbu->admin = $user->name;
        $usulanSbu->ket = 'Verified';

        // Mengecek apakah user memberikan alasan baru
        $alasanUser = $request->input('alasan', null);

        // Jika user memberikan alasan baru, gunakan alasan tersebut
        // Jika tidak, gunakan nilai awal dari $usulanSbu->alasan
        if (!is_null($alasanUser) && $alasanUser !== '') {
            $usulanSbu->alasan = $alasanUser;
        } else {
            // Jika tidak ada alasan baru dari user, tetap pakai alasan yang ada (jika null, tetap null)
            $usulanSbu->alasan = $usulanSbu->alasan;
        }

        $usulanSbu->updated_at = now(); // update timestamp

        // Simpan perubahan ke database
        $usulanSbu->save();

        // Mengirimkan respon sukses
        return response()->json([
            'message' => 'Data Usulan berhasil diverifikasi',
            'data' => $usulanSbu,
        ]);
    }

    public function approveSbu(Request $request, $id)
    {
        // Mendapatkan pengguna yang terautentikasi
        $user = $request->user();

        // Cari data usulanSbu berdasarkan ID
        $usulanSbu = UsulanSbu::find($id);

        // Cek apakah data usulanSbu ditemukan
        if (!$usulanSbu) {
            return response()->json(['message' => 'Data usulanSbu tidak ditemukan'], 404);
        }

        // Cek apakah ada item di Proses_sbu dengan uraian, spek, satuan, dan harga yang sama
        $existingProsesSbu = Proses_sbu::where('Uraian', $usulanSbu->Uraian)
            ->where('Spek', $usulanSbu->Spek)
            ->where('Satuan', $usulanSbu->Satuan)
            ->where('Harga', $usulanSbu->Harga)
            ->first();

        // Jika sudah ada, kembalikan respon bahwa data sudah ada
        if ($existingProsesSbu) {
            return response()->json([
                'message' => 'Item dengan uraian, spek, satuan, dan harga yang sama sudah ada di Proses_sbu'
            ], 400);
        }

        // Update kolom 'disetujui' dengan nama pengguna yang login
        $usulanSbu->disetujui = $user->name;
        $usulanSbu->ket = 'Disetujui';
        $usulanSbu->updated_at = now(); // update timestamp

        // Simpan perubahan ke database
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
        $prosesSbu->admin = $usulanSbu->admin;
        $prosesSbu->disetujui = $usulanSbu->disetujui;
        $prosesSbu->Kelompok = $usulanSbu->Kelompok;
        $prosesSbu->nilai_tkdn = $usulanSbu->nilai_tkdn;
        $prosesSbu->ket = $usulanSbu->ket;

        // Simpan data ke tabel Proses_shs
        $prosesSbu->save();

        // Mengirimkan respon sukses
        return response()->json([
            'message' => 'Data berhasil diupdate dan dipindahkan ke tabel Proses_sbu',
            'data' => $prosesSbu,
        ]);
    }

    public function tolakSbu(Request $request, $id)
    {
        // Mendapatkan pengguna yang terautentikasi
        $user = $request->user();

        // Cari data usulanSbu berdasarkan ID
        $usulanSbu = UsulanSbu::find($id);

        if (!$usulanSbu) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        // Update kolom 'disetujui' dengan nama pengguna yang login
        $usulanSbu->disetujui = $user->name;
        $usulanSbu->ket = 'Ditolak';

        // Mengecek apakah user memberikan alasan baru
        $alasanUser = $request->input('alasan', null);

        // Jika user memberikan alasan baru, gunakan alasan tersebut
        // Jika tidak, gunakan nilai awal dari $usulanSbu->alasan
        if (!is_null($alasanUser) && $alasanUser !== '') {
            $usulanSbu->alasan = $alasanUser;
        } else {
            // Jika tidak ada alasan baru dari user, tetap pakai alasan yang ada (jika null, tetap null)
            $usulanSbu->alasan = $usulanSbu->alasan;
        }

        $usulanSbu->updated_at = now(); // update timestamp

        // Simpan perubahan ke database
        $usulanSbu->save();

        // Mengirimkan respon sukses
        return response()->json([
            'message' => 'Data Usulan ditolak',
            'data' => $usulanSbu,
        ]);
    }

    public function verifiedAsb(Request $request, $id)
    {
        // Mendapatkan pengguna yang terautentikasi
        $user = $request->user();

        // Cari data UsulanAsb berdasarkan ID
        $usulanAsb = UsulanAsb::find($id);

        if (!$usulanAsb) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        // Update kolom 'disetujui' dengan nama pengguna yang login
        $usulanAsb->admin = $user->name;
        $usulanAsb->ket = 'Verified';

        // Mengecek apakah user memberikan alasan baru
        $alasanUser = $request->input('alasan', null);

        // Jika user memberikan alasan baru, gunakan alasan tersebut
        // Jika tidak, gunakan nilai awal dari $usulanAsb->alasan
        if (!is_null($alasanUser) && $alasanUser !== '') {
            $usulanAsb->alasan = $alasanUser;
        } else {
            // Jika tidak ada alasan baru dari user, tetap pakai alasan yang ada (jika null, tetap null)
            $usulanAsb->alasan = $usulanAsb->alasan;
        }

        $usulanAsb->updated_at = now(); // update timestamp

        // Simpan perubahan ke database
        $usulanAsb->save();

        // Mengirimkan respon sukses
        return response()->json([
            'message' => 'Data Usulan berhasil diverifikasi',
            'data' => $usulanAsb,
        ]);
    }

    public function approveAsb(Request $request, $id)
    {
        // Mendapatkan pengguna yang terautentikasi
        $user = $request->user();

        // Cari data usulanAsb berdasarkan ID
        $usulanAsb = UsulanAsb::find($id);

        // Cek apakah data usulanAsb ditemukan
        if (!$usulanAsb) {
            return response()->json(['message' => 'Data usulanAsb tidak ditemukan'], 404);
        }

        // Cek apakah ada item di Proses_asb dengan uraian, spek, satuan, dan harga yang sama
        $existingProsesAsb = Proses_asb::where('Uraian', $usulanAsb->Uraian)
            ->where('Spek', $usulanAsb->Spek)
            ->where('Satuan', $usulanAsb->Satuan)
            ->where('Harga', $usulanAsb->Harga)
            ->first();

        // Jika sudah ada, kembalikan respon bahwa data sudah ada
        if ($existingProsesAsb) {
            return response()->json([
                'message' => 'Item dengan uraian, spek, satuan, dan harga yang sama sudah ada di Proses_Asb'
            ], 400);
        }

        // Update kolom 'disetujui' dengan nama pengguna yang login
        $usulanAsb->disetujui = $user->name;
        $usulanAsb->ket = 'Disetujui';
        $usulanAsb->updated_at = now(); // update timestamp

        // Simpan perubahan ke database
        $usulanAsb->save();

        // Pindahkan data ke tabel prosesAsb
        $prosesAsb = new Proses_asb();
        $prosesAsb->Kode = $usulanAsb->Kode;
        $prosesAsb->Uraian = $usulanAsb->Uraian;
        $prosesAsb->Spek = $usulanAsb->Spek;
        $prosesAsb->Satuan = $usulanAsb->Satuan;
        $prosesAsb->Harga = $usulanAsb->Harga;
        $prosesAsb->akun_belanja = $usulanAsb->akun_belanja;
        $prosesAsb->rekening_1 = $usulanAsb->rekening_1;
        $prosesAsb->Document = $usulanAsb->Document;
        $prosesAsb->user = $usulanAsb->user;
        $prosesAsb->skpd = $usulanAsb->skpd;
        $prosesAsb->admin = $usulanAsb->admin;
        $prosesAsb->disetujui = $usulanAsb->disetujui;
        $prosesAsb->Kelompok = $usulanAsb->Kelompok;
        $prosesAsb->nilai_tkdn = $usulanAsb->nilai_tkdn;
        $prosesAsb->ket = $usulanAsb->ket;

        // Simpan data ke tabel Proses_shs
        $prosesAsb->save();

        // Mengirimkan respon sukses
        return response()->json([
            'message' => 'Data berhasil diupdate dan dipindahkan ke tabel Proses_sbu',
            'data' => $prosesAsb,
        ]);
    }

    public function tolakAsb(Request $request, $id)
    {
        // Mendapatkan pengguna yang terautentikasi
        $user = $request->user();

        // Cari data UsulanAsb berdasarkan ID
        $usulanAsb = UsulanAsb::find($id);

        if (!$usulanAsb) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        // Update kolom 'disetujui' dengan nama pengguna yang login
        $usulanAsb->disetujui = $user->name;
        $usulanAsb->ket = 'Ditolak';

        // Mengecek apakah user memberikan alasan baru
        $alasanUser = $request->input('alasan', null);

        // Jika user memberikan alasan baru, gunakan alasan tersebut
        // Jika tidak, gunakan nilai awal dari $usulanAsb->alasan
        if (!is_null($alasanUser) && $alasanUser !== '') {
            $usulanAsb->alasan = $alasanUser;
        } else {
            // Jika tidak ada alasan baru dari user, tetap pakai alasan yang ada (jika null, tetap null)
            $usulanAsb->alasan = $usulanAsb->alasan;
        }

        $usulanAsb->updated_at = now(); // update timestamp

        // Simpan perubahan ke database
        $usulanAsb->save();

        // Mengirimkan respon sukses
        return response()->json([
            'message' => 'Data Usulan ditolak',
            'data' => $usulanAsb,
        ]);
    }

    public function verifiedHspk(Request $request, $id)
    {
        // Mendapatkan pengguna yang terautentikasi
        $user = $request->user();

        // Cari data UsulanHspk berdasarkan ID
        $usulanHspk = UsulanHspk::find($id);

        if (!$usulanHspk) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        // Update kolom 'admin' dengan nama pengguna yang login
        $usulanHspk->admin = $user->name;
        $usulanHspk->ket = 'Verified';

        // Mengecek apakah user memberikan alasan baru
        $alasanUser = $request->input('alasan', null);

        // Jika user memberikan alasan baru, gunakan alasan tersebut
        // Jika tidak, gunakan nilai awal dari $usulanHspk->alasan
        if (!is_null($alasanUser) && $alasanUser !== '') {
            $usulanHspk->alasan = $alasanUser;
        } else {
            // Jika tidak ada alasan baru dari user, tetap pakai alasan yang ada (jika null, tetap null)
            $usulanHspk->alasan = $usulanHspk->alasan;
        }

        $usulanHspk->updated_at = now(); // update timestamp

        // Simpan perubahan ke database
        $usulanHspk->save();

        // Mengirimkan respon sukses
        return response()->json([
            'message' => 'Data Usulan berhasil diverifikasi',
            'data' => $usulanHspk,
        ]);
    }

    public function approveHspk(Request $request, $id)
    {
        // Mendapatkan pengguna yang terautentikasi
        $user = $request->user();

        // Cari data UsulanHspk berdasarkan ID
        $usulanHspk = UsulanHspk::find($id);

        // Cek apakah data UsulanHspk ditemukan
        if (!$usulanHspk) {
            return response()->json(['message' => 'Data Usulan Hspk tidak ditemukan'], 404);
        }

        // Cek apakah ada item di Proses_hspk dengan uraian, spek, satuan, dan harga yang sama
        $existingProsesHspk = Proses_hspk::where('Uraian', $usulanHspk->Uraian)
            ->where('Spek', $usulanHspk->Spek)
            ->where('Satuan', $usulanHspk->Satuan)
            ->where('Harga', $usulanHspk->Harga)
            ->first();

        // Jika sudah ada, kembalikan respon bahwa data sudah ada
        if ($existingProsesHspk) {
            return response()->json([
                'message' => 'Item dengan uraian, spek, satuan, dan harga yang sama sudah ada di Proses_shs'
            ], 400);
        }

        // Update kolom 'disetujui' dengan nama pengguna yang login
        $usulanHspk->disetujui = $user->name;
        $usulanHspk->ket = 'Disetujui';
        $usulanHspk->updated_at = now(); // update timestamp

        // Simpan perubahan ke database
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
        $prosesHspk->user = $usulanHspk->user;
        $prosesHspk->skpd = $usulanHspk->skpd;
        $prosesHspk->admin = $usulanHspk->admin;
        $prosesHspk->disetujui = $usulanHspk->disetujui;
        $prosesHspk->Kelompok = $usulanHspk->Kelompok;
        $prosesHspk->nilai_tkdn = $usulanHspk->nilai_tkdn;
        $prosesHspk->ket = $usulanHspk->ket;

        // Simpan data ke tabel Proses_shs
        $prosesHspk->save();

        // Mengirimkan respon sukses
        return response()->json([
            'message' => 'Data berhasil diupdate dan dipindahkan ke tabel proses Hspk',
            'data' => $prosesHspk,
        ]);
    }

    public function tolakHspk(Request $request, $id)
    {
        // Mendapatkan pengguna yang terautentikasi
        $user = $request->user();

        // Cari data UsulanHspk berdasarkan ID
        $usulanHspk = UsulanHspk::find($id);

        if (!$usulanHspk) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        // Update kolom 'disetujui' dengan nama pengguna yang login
        $usulanHspk->disetujui = $user->name;
        $usulanHspk->ket = 'Ditolak';

        // Mengecek apakah user memberikan alasan baru
        $alasanUser = $request->input('alasan', null);

        // Jika user memberikan alasan baru, gunakan alasan tersebut
        // Jika tidak, gunakan nilai awal dari $usulanHspk->alasan
        if (!is_null($alasanUser) && $alasanUser !== '') {
            $usulanHspk->alasan = $alasanUser;
        } else {
            // Jika tidak ada alasan baru dari user, tetap pakai alasan yang ada (jika null, tetap null)
            $usulanHspk->alasan = $usulanHspk->alasan;
        }

        $usulanHspk->updated_at = now(); // update timestamp

        // Simpan perubahan ke database
        $usulanHspk->save();

        // Mengirimkan respon sukses
        return response()->json([
            'message' => 'Data Usulan ditolak',
            'data' => $usulanHspk,
        ]);
    }
}
