<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Users;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
{
    $userData = [
        [
            'name'=>'kang admin',
            'email'=>'admin@gmail.com',
            'role'=>'admin',
            'password'=>bcrypt('123456'),
        ],
        [
            'name'=>'kang karyawan',
            'email'=>'karyawan@gmail.com',
            'role'=>'karyawan',
            'password'=>bcrypt('123456'),
        ],
        [
            'name'=>'kang owner',
            'email'=>'owner@gmail.com',
            'role'=>'owner',
            'password'=>bcrypt('123456'),
        ],
    ];

    foreach($userData as $key => $val){
        // Menggunakan updateOrCreate agar tidak duplikat
        User::updateOrCreate(
            ['email' => $val['email']], 
            $val
        );
    }
    }
}
