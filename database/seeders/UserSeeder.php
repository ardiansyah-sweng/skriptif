<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name'       => 'Admin',
                'email'      => 'admin@webmail.uad.ac.id',
                'password'   => Hash::make('admin123'),
                'role'       => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Dosen Pembimbing',
                'email'      => 'dosen@webmail.uad.ac.id',
                'password'   => Hash::make('dosen123'),
                'role'       => 'dosen',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
