<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    // {
    //     $users = \App\Models\User::when($request->id, function($query, $id){
    //         return $query->where('id', $id);
    //     })->get();

    //     return response()->json([
    //         'status' => 'success',
    //         'data' => $users,
    //     ]);
    // }

    public function index(Request $request)
    {
        $users = \App\Models\User::when($request->id, function($query, $id){
                return $query->where('id', $id);
            })
            ->where('roles', '!=', 'ADMIN') // Tambahkan kondisi untuk mengecualikan ADMIN
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $users,
        ]);
    }
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $user
        ]);
    }

    public function adminUpdate(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'name'  => 'required',
            'roles' => 'required',
            'skpd'  => 'required'
        ]);

        $user->update([
            'name'  => $request->name,
            'roles' => $request->roles,
            'skpd'  => $request->skpd,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data user berhasil diperbarui',
            'data' => $user
        ]);
    }

    public function resetPassword($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        $user->password = Hash::make('11111111');
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Password berhasil direset menjadi 11111111'
        ]);
    }

    public function updateuser(Request $request)
    {
        // Mendapatkan pengguna yang terautentikasi
        $user = $request->user();

        $validatedData = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'skpd' => 'required',
            'roles' => 'required',
        ]);

        $nm_user = $validatedData['name'];
        $user = User::where('name', $nm_user)->first();
        if (!$user) {
            return response()->json(['message' => 'User Tidak Ditemukan'], 404);
        }

        // Memperbarui data user
        $user->update([
            'name' => $validatedData['name'],
            'phone' => $validatedData['phone'],
            'roles' => $validatedData['roles'],
            'skpd' => $validatedData['skpd'],
            'updated_at' => now(),
        ]);
        return response()->json([
            'message' => 'Berhasil',
            'user' => $user,
        ]);
    }
}
