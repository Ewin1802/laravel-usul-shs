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


    }
}
