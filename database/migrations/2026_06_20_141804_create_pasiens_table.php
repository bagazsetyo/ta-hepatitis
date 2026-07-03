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
        Schema::create('pasiens', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('id_user')->unsigned();
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->string('nama_lengkap');
            $table->string('nik');
            $table->string('jenis_kelamin');
            $table->string('handphone');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('alamat_ktp');
            $table->string('alamat_domisili')->nullable();
            $table->string('agama');
            $table->string('pekerjaan');
            $table->string('status_pernikahan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasiens');
    }
};
