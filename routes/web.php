<?php

use Illuminate\Support\Facades\Route;

use App\Models\Pegawai;

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
use App\Models\RiwayatKasbon;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['guest'])->group(function (){
    Route::get('/',[SesiController::class,'index'])->name('login');
    Route::post('/',[SesiController::class,'login']);
});

Route::get('/login',[AdminController::class,'index']);


    route::get('/Admin',[AdminController::class, 'index']);
    route::get('/Admin/Admin',[AdminController::class, 'Admin'])->middleware('userAkses:Admin');
    
   
    


/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {

    $pegawai = Pegawai::latest()->get();

    $totalPegawai = Pegawai::count();

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

Route::get(
    '/absensi/pulang/{id}',
    [AbsensiController::class, 'pulang']
)->name('absensi.pulang');

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


Route::get('/riwayat-kasbon', [RiwayatKasbonController::class, 'index'])
    ->name('riwayat-kasbon.index');

/*
|--------------------------------------------------------------------------
| LAPORAN
|--------------------------------------------------------------------------
*/

Route::get('/laporan', [LaporanController::class, 'index'])
    ->name('laporan.index');
    
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

route::get('/Admin/karyawan',[AdminController::class, 'karyawan'])->middleware('userAkses:karyawan');
Route::middleware(['auth'])->group(function(){ });
Route::get('/dashboardkaryawan', function () {

    $pegawai = Pegawai::latest()->get();

    $totalPegawai = Pegawai::count();

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



 route::get('/Admin/owner',[AdminController::class, 'owner'])->middleware('userAkses:owner');
Route::middleware(['auth'])->group(function(){});

Route::get('/dashboardkaryawan', function () {

    $pegawai = Pegawai::latest()->get();

    $totalPegawai = Pegawai::count();

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