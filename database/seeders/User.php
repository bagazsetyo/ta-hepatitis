<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
class User extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      DB::table('users')->insert([
                  [ 'nama' => 'Admin',
                  'username' => 'admin',
                  'email' => 'admin@sipakar.com',
                  'password' => bcrypt('123'),
                  'id_role' => 1,
                  'status' => 1,
                  'created_at' => \Carbon\Carbon::now(),
                  'updated_at' => \Carbon\Carbon::now()
                ],
                [ 'nama' => 'Dokter',
                  'username' => 'dokter',
                  'email' => 'dokter@sipakar.com',
                  'password' => bcrypt('123'),
                  'id_role' => 2,
                  'status' => 1,
                  'created_at' => \Carbon\Carbon::now(),
                  'updated_at' => \Carbon\Carbon::now()
                ],
                [ 'nama' => 'Pasien',
                  'username' => 'pasien',
                  'email' => 'pasien@sipakar.com',
                  'password' => bcrypt('123'),
                  'id_role' => 3,
                  'status' => 1,
                  'created_at' => \Carbon\Carbon::now(),
                  'updated_at' => \Carbon\Carbon::now()
                ],
            ]);
    }
}
