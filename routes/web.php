<?php

use Illuminate\Support\Facades\Route;

use App\Models\User;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\PenggajianController;
use App\Http\Controllers\KasbonController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RiwayatKasbonController;
use App\Http\Controllers\SesiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['guest'])->group(function (){
    Route::get('/',[SesiController::class,'index'])->name('login');
    Route::post('/',[SesiController::class,'login']);
});

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function() {
    Route::get('/dashboard', function () {
        $pegawai = User::where('role', 'karyawan')->latest()->get();
        $totalPegawai = User::where('role', 'karyawan')->count();

        // Tambahkan variabel kosong/default ini agar view tidak error
        $absensiHariIni = 0; 
        $cutiHariIni = 0;
        $totalKasbon = 0;
        $totalGaji = 0;

        return view('dashboard', compact(
            'pegawai',
            'totalPegawai',
            'absensiHariIni',
            'cutiHariIni',
            'totalKasbon',
            'totalGaji'
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
    Route::get('/absensi/pulang/{id}', [AbsensiController::class, 'pulang'])->name('absensi.pulang');

    /*
    |--------------------------------------------------------------------------
    | CUTI
    |--------------------------------------------------------------------------
    |
    */
    Route::resource('cuti', CutiController::class);
    Route::put('/cuti/{id}/setujui', [CutiController::class, 'setujui'])->name('cuti.setujui');

    /*
    |--------------------------------------------------------------------------
    | PENGGAJIAN
    |--------------------------------------------------------------------------
    |
    */
    Route::resource('penggajian', PenggajianController::class);

    /*
    |--------------------------------------------------------------------------
    | KASBON
    |--------------------------------------------------------------------------
    */
    Route::resource('kasbon', KasbonController::class);
    Route::resource('riwayat-kasbon', RiwayatKasbonController::class);

    /*
    |--------------------------------------------------------------------------
    | LAPORAN
    |--------------------------------------------------------------------------
    */
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
});

// Admin-only routes (if any specific ones are needed later)
Route::middleware(['auth', 'userAkses:admin'])->group(function() {
    // Put admin-only routes here
});

// Owner-only routes
Route::middleware(['auth', 'userAkses:owner'])->group(function() {
    // Put owner-only routes here
});

// Karyawan-only routes
Route::middleware(['auth', 'userAkses:karyawan'])->group(function() {
    // Put karyawan-only routes here
});