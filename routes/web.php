<?php

use Illuminate\Support\Facades\Route;

// ── Admin Controllers (sudah ada) ────────────────────────────
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Admin\LayananController as AdminLayananController;
use App\Http\Controllers\KeluargaController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\WargaController;



// ── User Controllers ──────────────────────────────────────────
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\ProfilController;
use App\Http\Controllers\User\DataWargaController;
use App\Http\Controllers\User\LayananController;



// ── Admin Controllers (beranda — baru) ───────────────────────
use App\Http\Controllers\Admin\AparaturController;
use App\Http\Controllers\Admin\VideoProfilController;
use App\Http\Controllers\Admin\TickerController;
use App\Http\Controllers\Admin\StatistikController;
use App\Http\Controllers\Admin\SyaratDokumenController;
use App\Http\Controllers\Admin\KegiatanController;


// =============================================================
//  PUBLIK
// =============================================================
Route::redirect('/', '/user/beranda');

// =============================================================
//  AUTH ADMIN
// =============================================================
Route::get('/admin/login',  [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout',[AdminAuthController::class, 'logout'])->name('admin.logout');


// =============================================================
//  ADMIN AREA (dilindungi auth:admin)
// =============================================================
Route::middleware('auth:admin')->prefix('admin')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Redirect /admin → dashboard
    Route::get('/', fn() => redirect()->route('admin.dashboard'));

    // =====================
    // KELUARGA
    // =====================
   // Route::get('/keluarga', [KeluargaController::class, 'index'])->name('keluarga.index');
    //Route::post('/keluarga/store', [KeluargaController::class, 'store'])->name('keluarga.store');


    // ── Warga ─────────────────────────────────────────────────
    Route::get   ('/warga',          [WargaController::class, 'index'])  ->name('warga.index');
    Route::post  ('/warga/store',    [WargaController::class, 'store'])  ->name('warga.store');
    Route::get   ('/warga/{id}/edit',[WargaController::class, 'edit'])   ->name('warga.edit');
    Route::put   ('/warga/{id}',     [WargaController::class, 'update']) ->name('warga.update');
    Route::delete('/warga/{id}',     [WargaController::class, 'destroy'])->name('warga.destroy');

    // ── Import Excel ──────────────────────────────────────────
    Route::post('/warga/import', [ImportController::class, 'import'])->name('warga.import');

    // ekspor excel
    Route::get('/admin/warga/export', [WargaController::class, 'export'])->name('warga.export');

    // ── Layanan / Saran & Aduan (sudah ada) ───────────────────
    Route::get('/layanan',              [AdminLayananController::class, 'index'])   ->name('admin.layanan');
    Route::put('/layanan/{id}/diterima',[AdminLayananController::class, 'diterima'])->name('admin.layanan.diterima');

    // ── Aparatur ──────────────────────────────────────────────
    // Urutan HARUS sebelum resource agar /aparatur/urutan
    // tidak tertangkap sebagai {aparatur} parameter
    Route::post('/aparatur/urutan',            [AparaturController::class, 'urutan'])->name('admin.aparatur.urutan');
    Route::patch('/aparatur/{aparatur}/toggle',[AparaturController::class, 'toggle'])->name('admin.aparatur.toggle');
    Route::resource('aparatur', AparaturController::class)
         ->except(['show'])
         ->names([
             'index'   => 'admin.aparatur.index',
             'create'  => 'admin.aparatur.create',
             'store'   => 'admin.aparatur.store',
             'edit'    => 'admin.aparatur.edit',
             'update'  => 'admin.aparatur.update',
             'destroy' => 'admin.aparatur.destroy',
         ]);

    // ── Video Profil ──────────────────────────────────────────
    Route::get   ('/video',                   [VideoProfilController::class, 'index'])   ->name('admin.video.index');
    Route::post  ('/video',                   [VideoProfilController::class, 'store'])   ->name('admin.video.store');
    Route::delete('/video/{video}',           [VideoProfilController::class, 'destroy']) ->name('admin.video.destroy');
    Route::patch ('/video/{video}/aktifkan',  [VideoProfilController::class, 'aktifkan'])->name('admin.video.aktifkan');

    // ── Ticker (Teks Berjalan) ────────────────────────────────
    // Urutan HARUS sebelum put/{ticker}
    Route::post ('/ticker/urutan',            [TickerController::class, 'urutan'])->name('admin.ticker.urutan');
    Route::get  ('/ticker',                   [TickerController::class, 'index'])  ->name('admin.ticker.index');
    Route::post ('/ticker',                   [TickerController::class, 'store'])  ->name('admin.ticker.store');
    Route::put  ('/ticker/{ticker}',          [TickerController::class, 'update']) ->name('admin.ticker.update');
    Route::delete('/ticker/{ticker}',         [TickerController::class, 'destroy'])->name('admin.ticker.destroy');
    Route::patch('/ticker/{ticker}/toggle',   [TickerController::class, 'toggle']) ->name('admin.ticker.toggle');

    // ── Statistik + Info Kelurahan + Kode Pos ─────────────────
    // POST spesifik HARUS sebelum POST/GET umum
    Route::post('/statistik/info',            [StatistikController::class, 'updateInfo'])   ->name('admin.statistik.update-info');
    Route::post('/statistik/kodepos',         [StatistikController::class, 'updateKodepos'])->name('admin.statistik.update-kodepos');
    Route::get ('/statistik',                 [StatistikController::class, 'index'])        ->name('admin.statistik.index');
    Route::post('/statistik',                 [StatistikController::class, 'update'])       ->name('admin.statistik.update');
    Route::patch('/statistik/{key}',          [StatistikController::class, 'updateSatu'])   ->name('admin.statistik.update-satu');

    // ── Syarat Dokumen ────────────────────────────────────────
    // Urutan HARUS sebelum resource
    Route::post ('/syarat/urutan',            [SyaratDokumenController::class, 'urutan'])->name('admin.syarat.urutan');
    Route::patch('/syarat/{syarat}/toggle',   [SyaratDokumenController::class, 'toggle'])->name('admin.syarat.toggle');
    Route::resource('syarat', SyaratDokumenController::class)
         ->except(['show'])
         ->names([
             'index'   => 'admin.syarat.index',
             'create'  => 'admin.syarat.create',
             'store'   => 'admin.syarat.store',
             'edit'    => 'admin.syarat.edit',
             'update'  => 'admin.syarat.update',
             'destroy' => 'admin.syarat.destroy',
         ]);

    // ── Kegiatan ──────────────────────────────────────────────
    // Urutan & toggle HARUS sebelum resource
    Route::post ('/kegiatan/urutan',           [KegiatanController::class, 'urutan'])->name('admin.kegiatan.urutan');
    Route::patch('/kegiatan/{kegiatan}/toggle',[KegiatanController::class, 'toggle'])->name('admin.kegiatan.toggle');
    // create & edit tidak dipakai — semua via modal di index
    Route::resource('kegiatan', KegiatanController::class)
         ->except(['show', 'create', 'edit'])
         ->names([
             'index'   => 'admin.kegiatan.index',
             'store'   => 'admin.kegiatan.store',
             'update'  => 'admin.kegiatan.update',
             'destroy' => 'admin.kegiatan.destroy',
         ]);
         
}); // end middleware auth:admin


// =============================================================
//  USER AREA
// =============================================================
Route::prefix('user')->name('user.')->group(function () {

    // Beranda
    Route::get('/beranda', [UserController::class, 'beranda'])->name('beranda');

    // Kegiatan & Laporan RT (dari UserController)
    Route::get('/kegiatan',   [UserController::class, 'kegiatan']) ->name('kegiatan');
    Route::get('/laporan-rt', [UserController::class, 'laporanRt'])->name('laporan-rt');

    // ── Profil & sub-halaman (ProfilController) ───────────────
    Route::get('/profil',                      [ProfilController::class, 'profil'])  ->name('profil');
    Route::get('/profil/selayang-pandang',     [ProfilController::class, 'selayang'])->name('profil.selayang');
    Route::get('/profil/visi-misi',            [ProfilController::class, 'visi'])    ->name('profil.visi');
    Route::get('/profil/struktur-organisasi',  [ProfilController::class, 'struktur'])->name('profil.struktur');
    Route::get('/profil/peta-kelurahan',       [ProfilController::class, 'peta'])    ->name('profil.peta');

    // ── Data Warga (DataWargaController) ─────────────────────
    Route::get('/data-warga',            [DataWargaController::class, 'dataWarga'])  ->name('data-warga');
    Route::get('/data-warga/jumlah',     [DataWargaController::class, 'jumlah'])     ->name('data-warga.jumlah');
    Route::get('/data-warga/umur',       [DataWargaController::class, 'umur'])       ->name('data-warga.umur');
    Route::get('/data-warga/agama',      [DataWargaController::class, 'agama'])      ->name('data-warga.agama');
    Route::get('/data-warga/pendidikan', [DataWargaController::class, 'pendidikan']) ->name('data-warga.pendidikan');
    Route::get('/data-warga/pekerjaan',  [DataWargaController::class, 'pekerjaan'])  ->name('data-warga.pekerjaan');

    // ── Layanan / Saran & Aduan (LayananController) ───────────
    Route::get ('/layanan', [LayananController::class, 'index'])->name('layanan');
    Route::post('/layanan', [LayananController::class, 'store'])->name('layanan.store');

}); // end prefix user