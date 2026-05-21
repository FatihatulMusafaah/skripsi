<?php

use Illuminate\Support\Facades\Route;

use App\Models\Pegawai;

use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\PenggajianController;
use App\Http\Controllers\KasbonController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\SesiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/',[SesiController::class,'index']);
Route::post('/',[SesiController::class,'login']);


/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {

    $pegawai = Pegawai::latest()->get();

    $totalPegawai = Pegawai::count();

    return view('dashboard', compact(
        'pegawai',
        'totalPegawai'
    ));

})->name('dashboard');


/*
|--------------------------------------------------------------------------
| CRUD PEGAWAI
|--------------------------------------------------------------------------
*/

Route::resource('pegawai', PegawaiController::class);


/*
|--------------------------------------------------------------------------
| ABSENSI
|--------------------------------------------------------------------------
*/

Route::resource('absensi', AbsensiController::class);

Route::post('/absensi/masuk', [AbsensiController::class, 'masuk']);

Route::get('/absensi/pulang/{id}', [AbsensiController::class, 'pulang']);


/*
|--------------------------------------------------------------------------
| CUTI
|--------------------------------------------------------------------------
*/

Route::resource('cuti', CutiController::class);


/*
|--------------------------------------------------------------------------
| PENGGAJIAN
|--------------------------------------------------------------------------
*/

Route::resource('penggajian', PenggajianController::class);
Route::get('/penggajian', [PenggajianController::class, 'index']);
Route::post('/penggajian/store', [PenggajianController::class, 'store']);


/*
|--------------------------------------------------------------------------
| KASBON
|--------------------------------------------------------------------------
*/

Route::resource('kasbon', KasbonController::class);


/*
|--------------------------------------------------------------------------
| LAPORAN
|--------------------------------------------------------------------------
*/

Route::get('/laporan', [LaporanController::class, 'index'])
    ->name('laporan.index');