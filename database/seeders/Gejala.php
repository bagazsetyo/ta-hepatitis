<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class Gejala extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('gejalas')->insert([
            ['kode' => 'G01', 'gejala' => 'Demam tinggi mendadak','nilai' => '1'],
            ['kode' => 'G02', 'gejala' => 'Mual, muntah, dan nafsu makan menurun drastis','nilai' => '1'],
            ['kode' => 'G03', 'gejala' => 'Mata dan kulit berwarna kuning (Ikterus)','nilai' => '1'],
            ['kode' => 'G04', 'gejala' => 'Urine berwarna pekat gelap seperti air teh','nilai' => '1'],
            ['kode' => 'G05', 'gejala' => 'Feses (tinja) berwarna pucat / keabu-abuan','nilai' => '1'],
            ['kode' => 'G06', 'gejala' => 'Rasa lelah kronis dan lemas luar biasa','nilai' => '1'],
            ['kode' => 'G07', 'gejala' => 'Nyeri di perut bagian kanan atas','nilai' => '1'],
            ['kode' => 'G08', 'gejala' => 'Nyeri sendi dan pegal otot hebat','nilai' => '1'],
        ]);
    }
}
