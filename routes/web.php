<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Histori_TransaksiController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StokLogController; 
use App\Http\Controllers\LaporanObatController;
use App\Http\Controllers\LaporanObatMasukController;
use App\Http\Controllers\LaporanObatKeluarController;
use Illuminate\Support\Facades\Route;

// Halaman Utama
Route::get('/', function () {
    return view('welcome');
});

// Dashboard Utama
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Grup Rute yang Membutuhkan Login
Route::middleware('auth')->group(function () {
    
    // Master Data
    Route::resource('obat', ObatController::class);
    Route::resource('supplier', SupplierController::class);
    Route::resource('user', UserController::class);

    // Transaksi (Proses Input)
    Route::resource('pembelian', PembelianController::class);
    Route::resource('penjualan', PenjualanController::class);

    // Fitur Histori Transaksi (Tampilan Tab & Detail Struk)
    Route::get('/histori-transaksi', [Histori_TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/histori-transaksi/{id}', [Histori_TransaksiController::class, 'show'])->name('transaksi.show');
    Route::resource('histori_transaksi', Histori_TransaksiController::class);

    // Bagian Riwayat Stok
    Route::resource('stok_log', StokLogController::class);

    // --- BAGIAN LAPORAN ---
    Route::prefix('laporan')->group(function () {
        // Laporan Stok
        Route::get('/obat', [LaporanObatController::class, 'index'])->name('laporan.obat.index');
        Route::get('/obat/export', [LaporanObatController::class, 'export'])->name('laporan.obat.export');
        Route::get('/obat/print', [LaporanObatController::class, 'print'])->name('laporan.obat.print');

        // Laporan Obat Masuk
        Route::get('/obat-masuk', [LaporanObatMasukController::class, 'index'])->name('laporan.masuk.index');
        Route::get('/obat-masuk/export', [LaporanObatMasukController::class, 'export'])->name('obatmasuk.export');
        Route::get('/obat-masuk/print', [LaporanObatMasukController::class, 'print'])->name('laporanmasuk.print');

        // Laporan Obat Keluar
        Route::get('/obat-keluar', [LaporanObatKeluarController::class, 'index'])->name('laporan.keluar.index');
        Route::get('/obat-keluar/export', [LaporanObatKeluarController::class, 'export'])->name('obatkeluar.export');
        Route::get('/obat-keluar/print', [LaporanObatKeluarController::class, 'print'])->name('laporankeluar.print');
    });

    // Manajemen Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';