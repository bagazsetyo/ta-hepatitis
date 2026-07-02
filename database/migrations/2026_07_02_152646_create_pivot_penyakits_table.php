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
        Schema::create('pivot_penyakits', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('id_penyakit')->unsigned();
            $table->foreign('id_penyakit')->references('id')->on('penyakits')->onDelete('cascade');
            $table->integer('id_gejala')->unsigned();
            $table->foreign('id_gejala')->references('id')->on('gejalas')->onDelete('cascade');
            $table->string('nilai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pivot_penyakits');
    }
};
