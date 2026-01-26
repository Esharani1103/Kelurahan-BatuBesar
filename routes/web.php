<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\WargaController;

Route::get('/', function () {
    return 'laravel jalan';
});

Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
Route::get('/admin/warga', [WargaController::class, 'index'])->name('warga.index');
Route::post('/admin/warga/import', [WargaController::class, 'import'])->name('warga.import');
Route::post('/admin/warga/store', [WargaController::class, 'store'])->name('warga.store');
Route::put('/admin/warga/update/{id}', [WargaController::class, 'update'])->name('warga.update');
Route::delete('/admin/warga/delete/{id}', [WargaController::class, 'destroy'])->name('warga.destroy');
        

Route::middleware('auth:admin')->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
   
});
