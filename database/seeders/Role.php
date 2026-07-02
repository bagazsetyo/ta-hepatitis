<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class Role extends Seeder
{
    /**
     * Run the database seeds.
     */
      public function run(): void
      {
        DB::table('roles')->insert([
          ['nama'               => 'admin'],
          ['nama'               => 'dokter'],
          ['nama'               => 'pasien'],
        ]);
      }
}
