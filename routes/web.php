<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\GejalaController;
use App\Http\Controllers\PenyakitController;
use App\Http\Controllers\SolusiController;
use App\Http\Controllers\HasilPakarController;


Auth::routes();
Route::group([
    'middleware' => ['auth']],
    function () {
                Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
                Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

                Route::get('pasien',[PasienController::class,'index'])->name('index');
                Route::post('store/pasien',[PasienController::class,'store'])->name('store');
                Route::post('update/{id}pasien',[PasienController::class,'update'])->name('update');


                Route::get('gejala',[GejalaController::class,'index'])->name('index');
                Route::post('store/gejala',[GejalaController::class,'store'])->name('store');
                Route::post('update/{id}gejala',[GejalaController::class,'update'])->name('update');

                Route::get('penyakit',[PenyakitController::class,'index'])->name('index');
                Route::post('store/penyakit',[PenyakitController::class,'store'])->name('store');
                Route::post('update/{id}penyakit',[PenyakitController::class,'update'])->name('update');
                Route::get('detail/{id}penyakit',[PenyakitController::class,'show'])->name('show');
                Route::post('store/gejala/penyakit',[PenyakitController::class,'storeGejalaPenyakit'])->name('store gejala penyakit');




                Route::get('solusi',[SolusiController::class,'index'])->name('index');
                Route::post('store/solusi',[SolusiController::class,'store'])->name('store');
                Route::post('update/{id}solusi',[SolusiController::class,'update'])->name('update');


                Route::get('laporan',[HasilPakarController::class,'indexLaporan'])->name('index');

});