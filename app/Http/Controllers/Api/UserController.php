<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

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
