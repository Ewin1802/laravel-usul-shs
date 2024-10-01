<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'EwinLantapa (Admin)',
            'email' => 'ewin@fic10.com',
            'password' => Hash::make('11111111'),
            'roles' => 'ADMIN',
            'phone' => '081340985993',
            'skpd' => 'AllSKPD',
        ]);

        \App\Models\User::create([
            'name' => 'User (BADAN PENGELOLA KEUANGAN)',
            'email' => 'ewin@fic11.com',
            'password' => Hash::make('11111111'),
            'roles' => 'SKPD',
            'phone' => '081340985993',
            'skpd' => 'BADAN PENGELOLAAN KEUANGAN DAN PENDAPATAN DAERAH',
        ]);

        \App\Models\User::create([
            'name' => 'User (BAPELITBANGDA)',
            'email' => 'ewin@fic12.com',
            'password' => Hash::make('11111111'),
            'roles' => 'SKPD',
            'phone' => '081340985993',
            'skpd' => 'BADAN PERENCANAAN PEMBANGUNANAN PENELITIAN DAN PENGEMBANGAN DAERAH',
        ]);

        \App\Models\User::create([
            'name' => 'User (RSUD PRATAMA)',
            'email' => 'ewin@fic13.com',
            'password' => Hash::make('11111111'),
            'roles' => 'SKPD',
            'phone' => '081340985993',
            'skpd' => 'DINAS PENDIDIKAN DAN KEBUDAYAAN',
        ]);

        \App\Models\User::create([
            'name' => 'Pimpinan BPKPD',
            'email' => 'ewin@fic14.com',
            'password' => Hash::make('11111111'),
            'roles' => 'KABAN',
            'phone' => '081340985993',
            'skpd' => 'KABAN',
        ]);

    }
}
