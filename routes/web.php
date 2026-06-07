<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    
    // Redirect /dashboard based on role
    Route::get('/dashboard', function () {
        if (Auth::user()->role == 'admin') return redirect('/admin/dashboard');
        if (Auth::user()->role == 'owner') return redirect('/owner/dashboard');
        if (Auth::user()->role == 'karyawan') return redirect('/pegawai/dashboard');
        return redirect('/');
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | ADMIN ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware(['userAkses:admin'])->prefix('admin')->group(function() {
        Route::get('/dashboard', function () {
            $today = \Carbon\Carbon::today();
            $thisMonth = \Carbon\Carbon::now()->month;
            $thisYear = \Carbon\Carbon::now()->year;

            $pegawai = User::where('role', 'karyawan')->latest()->get();
            $totalPegawai = User::where('role', 'karyawan')->count();

            // Stats Real-time
            $absensiHariIni = \App\Models\Absensi::whereDate('tanggal', $today)->count();
            
            $cutiHariIni = \App\Models\Cuti::where('status', 'disetujui')
                ->whereDate('tanggal_mulai', '<=', $today)
                ->whereDate('tanggal_selesai', '>=', $today)
                ->count();
            
            $kasbonHariIni = \App\Models\Kasbon::whereDate('created_at', $today)->count();
            
            $totalGaji = \App\Models\Penggajian::whereMonth('created_at', $thisMonth)
                ->whereYear('created_at', $thisYear)
                ->sum('total_gaji');

            // Notifikasi (Pending)
            $notifCuti = \App\Models\Cuti::where('status', 'pending')->count();
            $notifKasbon = \App\Models\Kasbon::where('status', 'pending')->count();

            return view('dashboard', compact(
                'pegawai',
                'totalPegawai',
                'absensiHariIni',
                'cutiHariIni',
                'kasbonHariIni',
                'totalGaji',
                'notifCuti',
                'notifKasbon'
            )); 
        })->name('admin.dashboard');

        Route::resource('pegawai', PegawaiController::class);
        Route::resource('absensi', AbsensiController::class);
        Route::get('/absensi/pulang/{id}', [AbsensiController::class, 'pulang'])->name('absensi.pulang');
        Route::resource('cuti', CutiController::class);
        Route::put('/cuti/{id}/setujui', [CutiController::class, 'setujui'])->name('cuti.setujui');
        Route::resource('penggajian', PenggajianController::class);
        Route::resource('kasbon', KasbonController::class);
        Route::put('/kasbon/{id}/setujui', [KasbonController::class, 'setujui'])->name('kasbon.setujui');
        Route::put('/kasbon/{id}/tolak', [KasbonController::class, 'tolak'])->name('kasbon.tolak');
        Route::resource('riwayat-kasbon', RiwayatKasbonController::class);
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    });

    /*
    |--------------------------------------------------------------------------
    | OWNER ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware(['userAkses:owner'])->prefix('owner')->group(function() {
        Route::get('/dashboard', function () {
            return view('owner.dashboard'); 
        })->name('owner.dashboard');
        
        // Owner Access: Laporan Berjenjang
        Route::prefix('laporan')->group(function() {
            Route::get('/pegawai', [LaporanController::class, 'pegawai'])->name('owner.laporan.pegawai');
            Route::get('/absensi', [LaporanController::class, 'absensi'])->name('owner.laporan.absensi');
            Route::get('/cuti', [LaporanController::class, 'cuti'])->name('owner.laporan.cuti');
            Route::get('/kasbon', [LaporanController::class, 'kasbon'])->name('owner.laporan.kasbon');
            Route::get('/penggajian', [LaporanController::class, 'penggajian'])->name('owner.laporan.penggajian');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | KARYAWAN ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware(['userAkses:karyawan'])->prefix('pegawai')->group(function() {
        Route::get('/dashboard', [App\Http\Controllers\KaryawanController::class, 'dashboard'])->name('karyawan.dashboard');
        
        // Absensi
        Route::get('/absensi', [App\Http\Controllers\KaryawanController::class, 'absensi'])->name('karyawan.absensi');
        Route::post('/absensi/masuk', [App\Http\Controllers\KaryawanController::class, 'absenMasuk'])->name('karyawan.absensi.masuk');
        Route::put('/absensi/pulang/{id}', [App\Http\Controllers\KaryawanController::class, 'absenPulang'])->name('karyawan.absensi.pulang');

        // Cuti
        Route::get('/cuti', [App\Http\Controllers\KaryawanController::class, 'cuti'])->name('karyawan.cuti');
        Route::post('/cuti', [App\Http\Controllers\KaryawanController::class, 'cutiStore'])->name('karyawan.cuti.store');

        // Kasbon
        Route::get('/kasbon', [App\Http\Controllers\KaryawanController::class, 'kasbon'])->name('karyawan.kasbon');
        Route::post('/kasbon', [App\Http\Controllers\KaryawanController::class, 'kasbonStore'])->name('karyawan.kasbon.store');
        Route::get('/riwayat-kasbon', [App\Http\Controllers\KaryawanController::class, 'riwayatKasbon'])->name('karyawan.riwayat_kasbon');
        Route::get('/riwayat-kasbon/{id}', [App\Http\Controllers\KaryawanController::class, 'riwayatKasbonDetail'])->name('karyawan.riwayat_kasbon.detail');

        // Slip Gaji
        Route::get('/slip-gaji', [App\Http\Controllers\KaryawanController::class, 'slipGaji'])->name('karyawan.slip_gaji');
        Route::get('/slip-gaji/{id}', [App\Http\Controllers\KaryawanController::class, 'slipGajiShow'])->name('karyawan.slip_gaji.show');

        // Laporan
        Route::get('/laporan', [App\Http\Controllers\KaryawanController::class, 'laporan'])->name('karyawan.laporan');
    });
    
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
});