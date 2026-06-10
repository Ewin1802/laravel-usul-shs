<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OpsiDasarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function kelompok(Request $request)
    {
        $data = \App\Models\Kelompok::when($request->id, function($query, $id){
            return $query->where('id', $id);
        })->get();

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function satuan(Request $request)
    {
        $data = \App\Models\Satuan::when($request->id, function($query, $id){
            return $query->where('id', $id);
        })->get();

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function belanja(Request $request)
    {
        $data = \App\Models\BelanjaApi::when($request->id, function($query, $id){
            return $query->where('id', $id);
        })->get();

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function dokumen(Request $request)
    {
        $data = \App\Models\Document::when($request->id, function($query, $id){
            return $query->where('id', $id);
        })->get();

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function skpd(Request $request)
    {
        $data = \App\Models\Skpd::when($request->id, function($query, $id){
            return $query->where('id', $id);
        })->get();

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }


}
