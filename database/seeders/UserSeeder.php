<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nik'           => '1234567890',
            'nama'          => 'admin',
            'jenis_kelamin' => 'L',
            'username'      => 'admin',
            'password'      => 'password', // Password akan otomatis di-hash oleh Model
            'no_hp'         => '08123456789',
            'email'         => 'admin@erp.com',
            'role'          => 'admin'
        ]);
    }
}
