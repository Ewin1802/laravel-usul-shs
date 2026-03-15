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
use Illuminate\Support\Facades\DB;

class UsulanSkpdController extends Controller
{
    /**
     * Mapping model
     */
    private function modelMap()
    {
        return [
            'shs' => [
                'usulan' => UsulanShs::class,
                'proses' => Proses_shs::class,
            ],
            'sbu' => [
                'usulan' => UsulanSbu::class,
                'proses' => Proses_sbu::class,
            ],
            'asb' => [
                'usulan' => UsulanAsb::class,
                'proses' => Proses_asb::class,
            ],
            'hspk' => [
                'usulan' => UsulanHspk::class,
                'proses' => Proses_hspk::class,
            ],
        ];
    }

    /**
     * Get Data Generic
     */
    private function getData($model, Request $request)
    {
        $user = Auth::user();

        // ambil nama tabel model
        $instance = new $model;
        $table = $instance->getTable();

        $query = $model::query()
            ->leftJoin('documents', function ($join) use ($table) {

                $join->whereRaw(
                    "documents.file_name LIKE CONCAT('%', $table.Document, '%')"
                );
            })
            ->select(
                $table . '.*',
                'documents.file_path as document_url'
            );

        // filter id jika ada
        if ($request->id) {
            $query->where($table . '.id', $request->id);
        }

        // filter user jika bukan kaban
        if ($user->skpd !== 'KABAN' && $user->skpd !== 'AllSKPD') {
            $query->where($table . '.user', $user->name);
        }

        return $query->get();
    }

    /**
     * ======================
     * DATA
     * ======================
     */

    public function data_shs(Request $request)
    {
        $data = $this->getData(UsulanShs::class, $request);

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function data_sbu(Request $request)
    {
        $data = $this->getData(UsulanSbu::class, $request);

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function data_asb(Request $request)
    {
        $data = $this->getData(UsulanAsb::class, $request);

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function data_hspk(Request $request)
    {
        $data = $this->getData(UsulanHspk::class, $request);

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    /**
     * ======================
     * VERIFIED
     * ======================
     */

    public function verified(Request $request, $type, $id)
    {
        $request->validate([
            'alasan' => 'required|string'
        ]);

        $models = $this->modelMap();

        if (!isset($models[$type])) {
            return response()->json(['message' => 'Type tidak valid'], 400);
        }

        $usulanModel = $models[$type]['usulan'];

        $data = $usulanModel::find($id);

        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        if ($data->ket !== 'Proses Usul') {
            return response()->json([
                'message' => 'Data sudah diproses sebelumnya'
            ], 400);
        }

        $user = $request->user();

        $data->admin = $user->name;
        $data->ket = 'Verified';
        $data->alasan = $request->alasan;

        $data->save();

        return response()->json([
            'message' => 'Data berhasil diverifikasi',
            'data' => $data
        ]);
    }

    /**
     * ======================
     * APPROVE
     * ======================
     */

    public function approve(Request $request, $type, $id)
    {
        $models = $this->modelMap();

        if (!isset($models[$type])) {
            return response()->json(['message' => 'Type tidak valid'], 400);
        }

        $usulanModel = $models[$type]['usulan'];
        $prosesModel = $models[$type]['proses'];

        $data = $usulanModel::find($id);

        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        if ($data->ket !== 'Verified') {
            return response()->json([
                'message' => 'Usulan belum diverifikasi'
            ], 400);
        }

        $exist = $prosesModel::where('Uraian', $data->Uraian)
            ->where('Spek', $data->Spek)
            ->where('Satuan', $data->Satuan)
            ->where('Harga', $data->Harga)
            ->first();

        if ($exist) {
            return response()->json([
                'message' => 'Item sudah ada di tabel proses'
            ], 400);
        }

        DB::beginTransaction();

        try {

            $user = $request->user();

            $data->disetujui = $user->name;
            $data->ket = 'Disetujui';
            $data->save();

            $proses = new $prosesModel();

            $proses->Kode = $data->Kode;
            $proses->Uraian = $data->Uraian;
            $proses->Spek = $data->Spek;
            $proses->Satuan = $data->Satuan;
            $proses->Harga = $data->Harga;
            $proses->akun_belanja = $data->akun_belanja;
            $proses->rekening_1 = $data->rekening_1;
            $proses->Document = $data->Document;
            $proses->user = $data->user;
            $proses->skpd = $data->skpd;
            $proses->admin = $data->admin;
            $proses->disetujui = $data->disetujui;
            $proses->Kelompok = $data->Kelompok;
            $proses->nilai_tkdn = $data->nilai_tkdn;
            $proses->ket = $data->ket;

            $proses->save();

            DB::commit();

            return response()->json([
                'message' => 'Data berhasil disetujui dan dipindahkan',
                'data' => $proses
            ]);
        } catch (\Exception $e) {

            DB::rollback();

            return response()->json([
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * ======================
     * REJECT
     * ======================
     */

    public function reject(Request $request, $type, $id)
    {
        $models = $this->modelMap();

        if (!isset($models[$type])) {
            return response()->json(['message' => 'Type tidak valid'], 400);
        }

        $usulanModel = $models[$type]['usulan'];

        $data = $usulanModel::find($id);

        if (!$data) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $user = $request->user();

        $data->disetujui = $user->name;
        $data->ket = 'Ditolak';

        if ($request->alasan) {
            $data->alasan = $request->alasan;
        }

        $data->save();

        return response()->json([
            'message' => 'Usulan ditolak',
            'data' => $data
        ]);
    }

    public function statistik(Request $request, $type, $tahun)
    {
        $models = $this->modelMap();

        if (!isset($models[$type])) {
            return response()->json([
                'message' => 'Type tidak valid'
            ], 400);
        }

        $model = $models[$type]['usulan'];

        $user = Auth::user();

        $query = $model::query();

        // Filter user jika bukan kaban
        if ($user->skpd !== 'KABAN' && $user->skpd !== 'AllSKPD') {
            $query->where('user', $user->name);
        }

        $data = $query
            ->selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->whereYear('created_at', $tahun)
            ->groupByRaw('MONTH(created_at)')
            ->pluck('total', 'bulan');

        // Default 12 bulan
        $result = [];

        for ($i = 1; $i <= 12; $i++) {
            $result[] = $data[$i] ?? 0;
        }

        return response()->json([
            'status' => 'success',
            'type' => $type,
            'tahun' => $tahun,
            'data' => $result
        ]);
    }
}
