<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\KeluargaController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\ProfilController;
use App\Http\Controllers\User\DataWargaController;

Route::get('/', function () {
    return 'laravel jalan';
});




// =====================
// AUTH ADMIN
// =====================
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');


// =====================
// ADMIN AREA (LOGIN)
// =====================
Route::middleware('auth:admin')->prefix('admin')->group(function () {

    // DASHBOARD
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');


    // =====================
    // KELUARGA
    // =====================
   // Route::get('/keluarga', [KeluargaController::class, 'index'])->name('keluarga.index');
    //Route::post('/keluarga/store', [KeluargaController::class, 'store'])->name('keluarga.store');


    // =====================
    // WARGA
    // =====================
    Route::get('/warga', [WargaController::class, 'index'])->name('warga.index');
    Route::post('/warga/store', [WargaController::class, 'store'])->name('warga.store');
    Route::get('/warga/{id}/edit', [WargaController::class, 'edit'])->name('warga.edit');
    Route::put('/warga/{id}', [WargaController::class, 'update'])->name('warga.update');
    Route::delete('/warga/{id}', [WargaController::class, 'destroy'])->name('warga.destroy');




    // =====================
    // IMPORT EXCEL
    // =====================
    Route::post('/warga/import', [ImportController::class, 'import'])->name('warga.import');

});

/*user*/
 
Route::prefix('user')->group(function () {
    Route::get('/beranda', [UserController::class, 'beranda'])->name('user.beranda');

    Route::get('/profil', [ProfilController::class, 'profil'])->name('user.profil');
    Route::get('/profil/selayang-pandang', [ProfilController::class, 'selayang'])->name('user.profil.selayang');
    Route::get('/profil/visi-misi', [ProfilController::class, 'visi'])->name('user.profil.visi');
    Route::get('/profil/struktur-organisasi', [ProfilController::class, 'struktur'])->name('user.profil.struktur');
    Route::get('/profil/peta-kelurahan', [ProfilController::class, 'peta'])->name('user.profil.peta');

    Route::get('/data-warga', [DataWargaController::class, 'dataWarga'])->name('user.data-warga');
    Route::get('/data-warga/jumlah', [DataWargaController::class, 'jumlah'])->name('user.data-warga.jumlah');
    Route::get('/data-warga/umur', [DataWargaController::class, 'umur'])->name('user.data-warga.umur');
    Route::get('/data-warga/agama', [DataWargaController::class, 'agama'])->name('user.data-warga.agama');
    Route::get('/data-warga/pendidikan', [DataWargaController::class, 'pendidikan'])->name('user.data-warga.pendidikan');
    Route::get('/data-warga/pekerjaan', [DataWargaController::class, 'pekerjaan'])->name('user.data-warga.pekerjaan');

    Route::get('/kegiatan', [UserController::class, 'kegiatan'])->name('user.kegiatan');
    Route::get('/laporan-rt', [UserController::class, 'laporanRt'])->name('user.laporan-rt');
    Route::get('/layanan', [UserController::class, 'layanan'])->name('user.layanan');
});