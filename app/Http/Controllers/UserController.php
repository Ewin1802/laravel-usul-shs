<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Models\Skpd;
use App\Models\UsulanAsb;
use App\Models\UsulanSbu;
use App\Models\UsulanShs;
use App\Models\UsulanHspk;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = DB::table('users')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where(function ($query) use ($name) {
                    $query->where('name', 'like', '%' . $name . '%')
                        ->orWhere('skpd', 'like', '%' . $name . '%'); // Tambahkan pencarian di kolom "skpd" juga
                });
            })
            ->where('skpd', '!=', 'AllSKPD')  // Mengecualikan user yang memiliki skpd "AllSKPD"
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('pages.users.index', compact('users'));
    }


    public function create()
    {
        $skpd = \App\Models\Skpd::all();  // Ambil data SKPD dari tabel skpd
        return view('pages.users.create', compact('skpd'));
    }

    public function store(StoreUserRequest $request)
    {
        // Ambil semua input dan hash password
        $data = $request->all();
        $data['password'] = Hash::make($request->password);

        // Simpan user ke database
        \App\Models\User::create($data);

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('user.index')->with('success', 'User successfully created');
    }


    public function edit($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $skpd = Skpd::all();         // Ambil data kelompok untuk dropdown
        // $skpd = Skpd::where('nama_skpd', $user->skpd)->first();
        return view('pages.users.edit', compact('user', 'skpd'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        // Validasi input dan dapatkan data yang sudah divalidasi
        $data = $request->validated();

        // Periksa apakah password diisi, jika ya, update password
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        } else {
            // Jika password kosong, jangan update field password
            unset($data['password']);
        }

        // Update data user
        $user->update($data);

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('user.index')->with('success', 'User successfully updated');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user.index')->with('success', 'User successfully deleted');
    }


    public function showData()
    {
        // Menghitung jumlah user dengan roles 'PTPS'
        $totalSkpd = User::where('roles', 'SKPD')->count();
        $totalUser = User::where('roles', 'USER')->count();
        $totalUsulbaruShs = UsulanShs::where('ket', 'Proses Usul')->count();
        $totalUsulbaruSbu = UsulanSbu::where('ket', 'Proses Usul')->count();
        $totalUsulbaruAsb = UsulanAsb::where('ket', 'Proses Usul')->count();
        $totalUsulbaruHspk = UsulanHspk::where('ket', 'Proses Usul')->count();

        return view('pages.dashboard', compact('totalSkpd', 'totalUser', 'totalUsulbaruShs', 'totalUsulbaruSbu', 'totalUsulbaruAsb','totalUsulbaruHspk'));
    }
}
