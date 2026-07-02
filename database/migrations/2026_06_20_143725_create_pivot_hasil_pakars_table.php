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
        Schema::create('pivot_hasil_pakars', function (Blueprint $table) {
            $table->id();
            $table->integer('id_hasil')->unsigned();
            $table->foreign('id_hasil')->references('id')->on('hasil_pakars')->onDelete('cascade');
            $table->integer('id_gejala')->unsigned();
            $table->foreign('id_gejala')->references('id')->on('gejalas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pivot_hasil_pakars');
    }
};
