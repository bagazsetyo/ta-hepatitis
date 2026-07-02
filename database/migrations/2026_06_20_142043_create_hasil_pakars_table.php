<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hasil_pakars', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('id_pasien')->unsigned();
            $table->foreign('id_pasien')->references('id')->on('pasiens')->onDelete('cascade');
            $table->integer('id_penyakit')->unsigned();
            $table->foreign('id_penyakit')->references('id')->on('penyakits')->onDelete('cascade');
            $table->integer('id_solusi')->unsigned();
            $table->foreign('id_solusi')->references('id')->on('solusis')->onDelete('cascade');
            $table->text('keterangan')->nullable();
            $table->text('nilai')->nullable();
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_pakars');
    }
};
