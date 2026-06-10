<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UsulanShs;
use App\Models\UsulanSbu;
use App\Models\UsulanAsb;
use App\Models\UsulanHspk;
use App\Models\Kelompok;
use App\Models\Satuan;
use App\Models\Belanja;
use App\Models\Document;

class CreateUsulanController extends Controller
{

    public function createshs(Request $request)
    {
        // Mendapatkan pengguna yang terautentikasi
        $user = $request->user();

        // Validasi input untuk field lain
        $validatedData = $request->validate([
            'Kode' => 'required|exists:kelompoks,Kode',
            'Spek' => 'required',
            'Satuan' => 'required|exists:satuans,satuan',
            'Harga' => 'required',
            'akun_belanja' => 'required|exists:belanjas,Belanja',
            'rekening_1' => 'required|exists:belanjas,Rekening',
            'rekening_2' => 'nullable|exists:belanjas,Rekening',
            'rekening_3' => 'nullable|exists:belanjas,Rekening',
            'rekening_4' => 'nullable|exists:belanjas,Rekening',
            'rekening_5' => 'nullable|exists:belanjas,Rekening',
            'rekening_6' => 'nullable|exists:belanjas,Rekening',
            'rekening_7' => 'nullable|exists:belanjas,Rekening',
            'rekening_8' => 'nullable|exists:belanjas,Rekening',
            'rekening_9' => 'nullable|exists:belanjas,Rekening',
            'rekening_10' => 'nullable|exists:belanjas,Rekening',
            'nilai_tkdn' => 'required',
            'Document' => 'required|exists:documents,judul',
        ]);

        // Cari data kelompok berdasarkan Kode
        $kelompok = Kelompok::where('Kode', $validatedData['Kode'])->first();
        // Cari data satuan berdasarkan satuan
        $satuan = Satuan::where('satuan', $validatedData['Satuan'])->first();
        $akunBelanja = Belanja::where('Belanja', $validatedData['akun_belanja'])->first();
        // Cari data belanja rekening_1 berdasarkan rekening
        $belanja1 = Belanja::where('Rekening', $validatedData['rekening_1'])->first();
        // Gunakan operator null coalescing (??) untuk rekening opsional
        $belanja2 = Belanja::where('Rekening', $validatedData['rekening_2'] ?? '')->first();
        $belanja3 = Belanja::where('Rekening', $validatedData['rekening_3'] ?? '')->first();
        $belanja4 = Belanja::where('Rekening', $validatedData['rekening_4'] ?? '')->first();
        $belanja5 = Belanja::where('Rekening', $validatedData['rekening_5'] ?? '')->first();
        $belanja6 = Belanja::where('Rekening', $validatedData['rekening_6'] ?? '')->first();
        $belanja7 = Belanja::where('Rekening', $validatedData['rekening_7'] ?? '')->first();
        $belanja8 = Belanja::where('Rekening', $validatedData['rekening_8'] ?? '')->first();
        $belanja9 = Belanja::where('Rekening', $validatedData['rekening_9'] ?? '')->first();
        $belanja10 = Belanja::where('Rekening', $validatedData['rekening_10'] ?? '')->first();
        // Cari data document berdasarkan judul
        $doc = Document::where('judul', $validatedData['Document'])->first();

        // Cek jika user kelompok, satuan, belanja atau dokumen tidak ditemukan
        if (!$user) {
            return response()->json(['message' => 'User tidak terautentikasi'], 401);
        }
        if (!$kelompok) {
            return response()->json(['message' => 'Kelompok tidak ditemukan'], 404);
        }

        if (!$satuan) {
            return response()->json(['message' => 'Satuan tidak ditemukan'], 404);
        }
        if (!$akunBelanja) {
            return response()->json(['message' => 'Akun Belanja tidak ditemukan'], 404);
        }
        if (!$belanja1) {
            return response()->json(['message' => 'Belanja tidak ditemukan'], 404);
        }

        if (!$doc) {
            return response()->json(['message' => 'Document tidak ditemukan'], 404);
        }

        // Buat data usulanshs
        $usulanshs = UsulanShs::create([
            'Kode' => $kelompok->Kode,  // Menggunakan Kode dari tabel kelompoks
            'Uraian' => $kelompok->Uraian,  // Menggunakan Uraian dari tabel kelompoks
            'Spek' => $validatedData['Spek'],
            'Satuan' => $satuan->satuan,
            'Harga' => $validatedData['Harga'],
            'akun_belanja' => $akunBelanja->Belanja,
            'rekening_1' => $belanja1->Rekening,
            'rekening_2' => $belanja2->Rekening ?? null, // Default null jika tidak diisi
            'rekening_3' => $belanja3->Rekening ?? null,
            'rekening_4' => $belanja4->Rekening ?? null,
            'rekening_5' => $belanja5->Rekening ?? null,
            'rekening_6' => $belanja6->Rekening ?? null,
            'rekening_7' => $belanja7->Rekening ?? null,
            'rekening_8' => $belanja8->Rekening ?? null,
            'rekening_9' => $belanja9->Rekening ?? null,
            'rekening_10' => $belanja10->Rekening ?? null,
            'Document' => $doc->judul,
            'nilai_tkdn' => $validatedData['nilai_tkdn'],
            'user' => $user->name,
            'skpd' => $user->skpd,
            'ket' => 'Proses Usul', // Keterangan awal
            'Kelompok' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'message' => 'Berhasil',
            'data' => $usulanshs,
        ]);
    }

    public function createsbu(Request $request)
    {
        // Mendapatkan pengguna yang terautentikasi
        $user = $request->user();

        // Validasi input untuk field lain
        $validatedData = $request->validate([
            'Kode' => 'required|exists:kelompoks,Kode',
            'Spek' => 'required',
            'Satuan' => 'required|exists:satuans,satuan',
            'Harga' => 'required',
            'akun_belanja' => 'required|exists:belanjas,Belanja',
            'rekening_1' => 'required|exists:belanjas,Rekening',
            'rekening_2' => 'nullable|exists:belanjas,Rekening',
            'rekening_3' => 'nullable|exists:belanjas,Rekening',
            'rekening_4' => 'nullable|exists:belanjas,Rekening',
            'rekening_5' => 'nullable|exists:belanjas,Rekening',
            'rekening_6' => 'nullable|exists:belanjas,Rekening',
            'rekening_7' => 'nullable|exists:belanjas,Rekening',
            'rekening_8' => 'nullable|exists:belanjas,Rekening',
            'rekening_9' => 'nullable|exists:belanjas,Rekening',
            'rekening_10' => 'nullable|exists:belanjas,Rekening',
            'nilai_tkdn' => 'required',
            'Document' => 'required|exists:documents,judul',
        ]);

        // Cari data kelompok berdasarkan Kode
        $kelompok = Kelompok::where('Kode', $validatedData['Kode'])->first();
        // Cari data satuan berdasarkan satuan
        $satuan = Satuan::where('satuan', $validatedData['Satuan'])->first();
        $akunBelanja = Belanja::where('Belanja', $validatedData['akun_belanja'])->first();
        // Cari data belanja rekening_1 berdasarkan rekening
        $belanja1 = Belanja::where('Rekening', $validatedData['rekening_1'])->first();
        // Gunakan operator null coalescing (??) untuk rekening opsional
        $belanja2 = Belanja::where('Rekening', $validatedData['rekening_2'] ?? '')->first();
        $belanja3 = Belanja::where('Rekening', $validatedData['rekening_3'] ?? '')->first();
        $belanja4 = Belanja::where('Rekening', $validatedData['rekening_4'] ?? '')->first();
        $belanja5 = Belanja::where('Rekening', $validatedData['rekening_5'] ?? '')->first();
        $belanja6 = Belanja::where('Rekening', $validatedData['rekening_6'] ?? '')->first();
        $belanja7 = Belanja::where('Rekening', $validatedData['rekening_7'] ?? '')->first();
        $belanja8 = Belanja::where('Rekening', $validatedData['rekening_8'] ?? '')->first();
        $belanja9 = Belanja::where('Rekening', $validatedData['rekening_9'] ?? '')->first();
        $belanja10 = Belanja::where('Rekening', $validatedData['rekening_10'] ?? '')->first();
        // Cari data document berdasarkan judul
        $doc = Document::where('judul', $validatedData['Document'])->first();

        // Cek jika user kelompok, satuan, belanja atau dokumen tidak ditemukan
        if (!$user) {
            return response()->json(['message' => 'User tidak terautentikasi'], 401);
        }
        if (!$kelompok) {
            return response()->json(['message' => 'Kelompok tidak ditemukan'], 404);
        }

        if (!$satuan) {
            return response()->json(['message' => 'Satuan tidak ditemukan'], 404);
        }
        if (!$akunBelanja) {
            return response()->json(['message' => 'Akun Belanja tidak ditemukan'], 404);
        }

        if (!$belanja1) {
            return response()->json(['message' => 'Belanja tidak ditemukan'], 404);
        }

        if (!$doc) {
            return response()->json(['message' => 'Document tidak ditemukan'], 404);
        }

        // Buat data usulanshs
        $usulanshs = UsulanSbu::create([
            'Kode' => $kelompok->Kode,  // Menggunakan Kode dari tabel kelompoks
            'Uraian' => $kelompok->Uraian,  // Menggunakan Uraian dari tabel kelompoks
            'Spek' => $validatedData['Spek'],
            'Satuan' => $satuan->satuan,
            'Harga' => $validatedData['Harga'],
            'akun_belanja' => $akunBelanja->Belanja,
            'rekening_1' => $belanja1->Rekening,
            'rekening_2' => $belanja2->Rekening ?? null, // Default null jika tidak diisi
            'rekening_3' => $belanja3->Rekening ?? null,
            'rekening_4' => $belanja4->Rekening ?? null,
            'rekening_5' => $belanja5->Rekening ?? null,
            'rekening_6' => $belanja6->Rekening ?? null,
            'rekening_7' => $belanja7->Rekening ?? null,
            'rekening_8' => $belanja8->Rekening ?? null,
            'rekening_9' => $belanja9->Rekening ?? null,
            'rekening_10' => $belanja10->Rekening ?? null,
            'Document' => $doc->judul,
            'nilai_tkdn' => $validatedData['nilai_tkdn'],
            'user' => $user->name,
            'skpd' => $user->skpd,
            'ket' => 'Proses Usul', // Keterangan awal
            'Kelompok' => '4',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'message' => 'Berhasil',
            'data' => $usulanshs,
        ]);
    }

    public function createasb(Request $request)
    {
        // Mendapatkan pengguna yang terautentikasi
        $user = $request->user();

        // Validasi input untuk field lain
        $validatedData = $request->validate([
            'Kode' => 'required|exists:kelompoks,Kode',
            'Spek' => 'required',
            'Satuan' => 'required|exists:satuans,satuan',
            'Harga' => 'required',
            'akun_belanja' => 'required|exists:belanjas,Belanja',
            'rekening_1' => 'required|exists:belanjas,Rekening',
            'rekening_2' => 'nullable|exists:belanjas,Rekening',
            'rekening_3' => 'nullable|exists:belanjas,Rekening',
            'rekening_4' => 'nullable|exists:belanjas,Rekening',
            'rekening_5' => 'nullable|exists:belanjas,Rekening',
            'rekening_6' => 'nullable|exists:belanjas,Rekening',
            'rekening_7' => 'nullable|exists:belanjas,Rekening',
            'rekening_8' => 'nullable|exists:belanjas,Rekening',
            'rekening_9' => 'nullable|exists:belanjas,Rekening',
            'rekening_10' => 'nullable|exists:belanjas,Rekening',
            'nilai_tkdn' => 'required',
            'Document' => 'required|exists:documents,judul',
        ]);

        // Cari data kelompok berdasarkan Kode
        $kelompok = Kelompok::where('Kode', $validatedData['Kode'])->first();
        // Cari data satuan berdasarkan satuan
        $satuan = Satuan::where('satuan', $validatedData['Satuan'])->first();
        $akunBelanja = Belanja::where('Belanja', $validatedData['akun_belanja'])->first();
        // Cari data belanja rekening_1 berdasarkan rekening
        $belanja1 = Belanja::where('Rekening', $validatedData['rekening_1'])->first();
        // Gunakan operator null coalescing (??) untuk rekening opsional
        $belanja2 = Belanja::where('Rekening', $validatedData['rekening_2'] ?? '')->first();
        $belanja3 = Belanja::where('Rekening', $validatedData['rekening_3'] ?? '')->first();
        $belanja4 = Belanja::where('Rekening', $validatedData['rekening_4'] ?? '')->first();
        $belanja5 = Belanja::where('Rekening', $validatedData['rekening_5'] ?? '')->first();
        $belanja6 = Belanja::where('Rekening', $validatedData['rekening_6'] ?? '')->first();
        $belanja7 = Belanja::where('Rekening', $validatedData['rekening_7'] ?? '')->first();
        $belanja8 = Belanja::where('Rekening', $validatedData['rekening_8'] ?? '')->first();
        $belanja9 = Belanja::where('Rekening', $validatedData['rekening_9'] ?? '')->first();
        $belanja10 = Belanja::where('Rekening', $validatedData['rekening_10'] ?? '')->first();
        // Cari data document berdasarkan judul
        $doc = Document::where('judul', $validatedData['Document'])->first();

        // Cek jika user kelompok, satuan, belanja atau dokumen tidak ditemukan
        if (!$user) {
            return response()->json(['message' => 'User tidak terautentikasi'], 401);
        }
        if (!$kelompok) {
            return response()->json(['message' => 'Kelompok tidak ditemukan'], 404);
        }

        if (!$satuan) {
            return response()->json(['message' => 'Satuan tidak ditemukan'], 404);
        }
        if (!$akunBelanja) {
            return response()->json(['message' => 'Akun Belanja tidak ditemukan'], 404);
        }

        if (!$belanja1) {
            return response()->json(['message' => 'Belanja tidak ditemukan'], 404);
        }

        if (!$doc) {
            return response()->json(['message' => 'Document tidak ditemukan'], 404);
        }

        // Buat data usulanshs
        $usulanshs = UsulanAsb::create([
            'Kode' => $kelompok->Kode,  // Menggunakan Kode dari tabel kelompoks
            'Uraian' => $kelompok->Uraian,  // Menggunakan Uraian dari tabel kelompoks
            'Spek' => $validatedData['Spek'],
            'Satuan' => $satuan->satuan,
            'Harga' => $validatedData['Harga'],
            'akun_belanja' => $akunBelanja->Belanja,
            'rekening_1' => $belanja1->Rekening,
            'rekening_2' => $belanja2->Rekening ?? null, // Default null jika tidak diisi
            'rekening_3' => $belanja3->Rekening ?? null,
            'rekening_4' => $belanja4->Rekening ?? null,
            'rekening_5' => $belanja5->Rekening ?? null,
            'rekening_6' => $belanja6->Rekening ?? null,
            'rekening_7' => $belanja7->Rekening ?? null,
            'rekening_8' => $belanja8->Rekening ?? null,
            'rekening_9' => $belanja9->Rekening ?? null,
            'rekening_10' => $belanja10->Rekening ?? null,
            'Document' => $doc->judul,
            'nilai_tkdn' => $validatedData['nilai_tkdn'],
            'user' => $user->name,
            'skpd' => $user->skpd,
            'ket' => 'Proses Usul', // Keterangan awal
            'Kelompok' => '3',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'message' => 'Berhasil',
            'data' => $usulanshs,
        ]);
    }

    public function createhspk(Request $request)
    {
        // Mendapatkan pengguna yang terautentikasi
        $user = $request->user();

        // Validasi input untuk field lain
        $validatedData = $request->validate([
            'Kode' => 'required|exists:kelompoks,Kode',
            'Spek' => 'required',
            'Satuan' => 'required|exists:satuans,satuan',
            'Harga' => 'required',
            'akun_belanja' => 'required|exists:belanjas,Belanja',
            'rekening_1' => 'required|exists:belanjas,Rekening',
            'rekening_2' => 'nullable|exists:belanjas,Rekening',
            'rekening_3' => 'nullable|exists:belanjas,Rekening',
            'rekening_4' => 'nullable|exists:belanjas,Rekening',
            'rekening_5' => 'nullable|exists:belanjas,Rekening',
            'rekening_6' => 'nullable|exists:belanjas,Rekening',
            'rekening_7' => 'nullable|exists:belanjas,Rekening',
            'rekening_8' => 'nullable|exists:belanjas,Rekening',
            'rekening_9' => 'nullable|exists:belanjas,Rekening',
            'rekening_10' => 'nullable|exists:belanjas,Rekening',
            'nilai_tkdn' => 'required',
            'Document' => 'required|exists:documents,judul',
        ]);

        // Cari data kelompok berdasarkan Kode
        $kelompok = Kelompok::where('Kode', $validatedData['Kode'])->first();
        // Cari data satuan berdasarkan satuan
        $satuan = Satuan::where('satuan', $validatedData['Satuan'])->first();
        $akunBelanja = Belanja::where('Belanja', $validatedData['akun_belanja'])->first();
        // Cari data belanja rekening_1 berdasarkan rekening
        $belanja1 = Belanja::where('Rekening', $validatedData['rekening_1'])->first();
        // Gunakan operator null coalescing (??) untuk rekening opsional
        $belanja2 = Belanja::where('Rekening', $validatedData['rekening_2'] ?? '')->first();
        $belanja3 = Belanja::where('Rekening', $validatedData['rekening_3'] ?? '')->first();
        $belanja4 = Belanja::where('Rekening', $validatedData['rekening_4'] ?? '')->first();
        $belanja5 = Belanja::where('Rekening', $validatedData['rekening_5'] ?? '')->first();
        $belanja6 = Belanja::where('Rekening', $validatedData['rekening_6'] ?? '')->first();
        $belanja7 = Belanja::where('Rekening', $validatedData['rekening_7'] ?? '')->first();
        $belanja8 = Belanja::where('Rekening', $validatedData['rekening_8'] ?? '')->first();
        $belanja9 = Belanja::where('Rekening', $validatedData['rekening_9'] ?? '')->first();
        $belanja10 = Belanja::where('Rekening', $validatedData['rekening_10'] ?? '')->first();
        // Cari data document berdasarkan judul
        $doc = Document::where('judul', $validatedData['Document'])->first();

        // Cek jika user kelompok, satuan, belanja atau dokumen tidak ditemukan
        if (!$user) {
            return response()->json(['message' => 'User tidak terautentikasi'], 401);
        }
        if (!$kelompok) {
            return response()->json(['message' => 'Kelompok tidak ditemukan'], 404);
        }

        if (!$satuan) {
            return response()->json(['message' => 'Satuan tidak ditemukan'], 404);
        }
        if (!$akunBelanja) {
            return response()->json(['message' => 'Akun Belanja tidak ditemukan'], 404);
        }

        if (!$belanja1) {
            return response()->json(['message' => 'Belanja tidak ditemukan'], 404);
        }

        if (!$doc) {
            return response()->json(['message' => 'Document tidak ditemukan'], 404);
        }

        // Buat data usulanhspk
        $usulanhspk = UsulanHspk::create([
            'Kode' => $kelompok->Kode,  // Menggunakan Kode dari tabel kelompoks
            'Uraian' => $kelompok->Uraian,  // Menggunakan Uraian dari tabel kelompoks
            'Spek' => $validatedData['Spek'],
            'Satuan' => $satuan->satuan,
            'Harga' => $validatedData['Harga'],
            'akun_belanja' => $akunBelanja->Belanja,
            'rekening_1' => $belanja1->Rekening,
            'rekening_2' => $belanja2->Rekening ?? null, // Default null jika tidak diisi
            'rekening_3' => $belanja3->Rekening ?? null,
            'rekening_4' => $belanja4->Rekening ?? null,
            'rekening_5' => $belanja5->Rekening ?? null,
            'rekening_6' => $belanja6->Rekening ?? null,
            'rekening_7' => $belanja7->Rekening ?? null,
            'rekening_8' => $belanja8->Rekening ?? null,
            'rekening_9' => $belanja9->Rekening ?? null,
            'rekening_10' => $belanja10->Rekening ?? null,
            'Document' => $doc->judul,
            'nilai_tkdn' => $validatedData['nilai_tkdn'],
            'user' => $user->name,
            'skpd' => $user->skpd,
            'ket' => 'Proses Usul', // Keterangan awal
            'Kelompok' => '2',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'message' => 'Berhasil',
            'data' => $usulanhspk,
        ]);
    }

}
