<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;


class Penyakit extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('penyakits')->insert([
            ['kode' => 'P01', 'penyakit' => 'Hepatitis A'],
            ['kode' => 'P02', 'penyakit' => 'Hepatitis B'],
            ['kode' => 'P03', 'penyakit' => 'Hepatitis C'],
            ['kode' => 'P04', 'penyakit' => 'Hepatitis D'],
        ]);
    }
}
