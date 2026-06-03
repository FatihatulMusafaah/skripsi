<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DummyUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            [
                'name' => 'Administrator',
                'email' => 'admin@gmail.com',
                'role' => 'admin',
                'password' => Hash::make('admin123'),
                'jabatan' => 'Super Admin',
                'status' => 'aktif',
            ],
            [
                'name' => 'Karyawan Contoh',
                'email' => 'karyawan@gmail.com',
                'role' => 'karyawan',
                'password' => Hash::make('123456'),
                'jabatan' => 'Staff',
                'no_hp' => '08123456789',
                'alamat' => 'Jl. Contoh No. 123',
                'gaji_pokok' => 5000000,
                'status' => 'aktif',
            ],
            [
                'name' => 'Owner Bisnis',
                'email' => 'owner@gmail.com',
                'role' => 'owner',
                'password' => Hash::make('123456'),
                'jabatan' => 'Owner',
                'status' => 'aktif',
            ],
        ];

        foreach ($userData as $val) {
            User::updateOrCreate(
                ['email' => $val['email']],
                $val
            );
        }
    }
}
