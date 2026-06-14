<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// 1. Halaman utama langsung diarahkan ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
});

// 2. Alur Pengarah (Redirect) Otomatis setelah Berhasil Login
Route::get('/dashboard', function () {
    $role = auth()->user()->role;

    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($role === 'mandor') {
        return redirect()->route('mandor.dashboard');
    } elseif ($role === 'owner') {
        return redirect()->route('owner.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// 3. Kelompok Rute Khusus USER: ADMIN
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard Admin
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Fitur Kelola User oleh Admin (Lengkap CRUD)
    Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::post('/users', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');

    // Fitur Kelola & Monitoring Proyek oleh Admin
    Route::get('/proyek', [\App\Http\Controllers\Admin\ProyekController::class, 'index'])->name('proyek.index');
    Route::post('/proyek', [\App\Http\Controllers\Admin\ProyekController::class, 'store'])->name('proyek.store');
    Route::get('/proyek/{id}', [\App\Http\Controllers\Admin\ProyekController::class, 'show'])->name('proyek.show');
    Route::get('/proyek/{id}/edit', [\App\Http\Controllers\Admin\ProyekController::class, 'edit'])->name('proyek.edit');
    Route::put('/proyek/{id}', [\App\Http\Controllers\Admin\ProyekController::class, 'update'])->name('proyek.update');
    Route::delete('/proyek/{id}', [\App\Http\Controllers\Admin\ProyekController::class, 'destroy'])->name('proyek.destroy');

    // FIX TOTAL ROUTE PENGELUARAN KAS
    Route::post('/proyek/pengeluaran/store', [\App\Http\Controllers\Admin\ProyekController::class, 'storePengeluaran'])->name('proyek.store_pengeluaran');
    Route::get('/proyek/pengeluaran/{id}/edit', [\App\Http\Controllers\Admin\ProyekController::class, 'editPengeluaran'])->name('proyek.edit_pengeluaran');
    Route::put('/proyek/pengeluaran/{id}', [\App\Http\Controllers\Admin\ProyekController::class, 'updatePengeluaran'])->name('proyek.update_pengeluaran');
    Route::delete('/proyek/pengeluaran/{id}', [\App\Http\Controllers\Admin\ProyekController::class, 'destroyPengeluaran'])->name('proyek.destroy_pengeluaran');

    // Fitur Audit Absensi Mandor oleh Admin
    Route::get('/audit', [\App\Http\Controllers\Admin\AuditAbsensiController::class, 'index'])->name('audit.index');
    // Route melihat rekap absensi pekerja lapangan oleh Admin
    Route::get('/proyek/{id}/absen-pekerja', [\App\Http\Controllers\Admin\ProyekController::class, 'showAbsenPekerja'])->name('proyek.absen_pekerja');

    // Route untuk kendali sisa stok barang terkelompok & ekspor cetak
    Route::get('/material-gudang', [\App\Http\Controllers\Admin\AdminMaterialController::class, 'index'])->name('material.index');
    Route::get('/material-gudang/export', [\App\Http\Controllers\Admin\AdminMaterialController::class, 'exportReport'])->name('material.export');

    // Route cetak PDF keseluruhan rangkuman logistik per proyek
    Route::get('/proyek/{id}/export-all', [\App\Http\Controllers\Admin\AdminMaterialController::class, 'exportProyekReport'])->name('proyek.export_all');
});

// 4. Kelompok Rute Khusus USER: MANDOR (Mobile Responsive)
Route::middleware(['auth', 'role:mandor'])->prefix('mandor')->name('mandor.')->group(function () {

    // Dashboard Mandor
    Route::get('/dashboard', function () {
        return view('mandor.dashboard');
    })->name('dashboard');

    // Fitur Absensi Mandor
    Route::get('/absensi', [\App\Http\Controllers\Mandor\AbsensiController::class, 'create'])->name('absensi.create');
    Route::post('/absensi', [\App\Http\Controllers\Mandor\AbsensiController::class, 'store'])->name('absensi.store');

    // Fitur Input Laporan Progres Harian
    Route::get('/laporan', [\App\Http\Controllers\Mandor\LaporanHarianController::class, 'create'])->name('laporan.create');
    Route::post('/laporan', [\App\Http\Controllers\Mandor\LaporanHarianController::class, 'store'])->name('laporan.store');
    Route::get('/laporan/riwayat', [\App\Http\Controllers\Mandor\LaporanHarianController::class, 'riwayat'])->name('laporan.riwayat');

    // Fitur Input Nota Belanjaan Logistik
    Route::get('/nota', [\App\Http\Controllers\Mandor\NotaBelanjaController::class, 'create'])->name('nota.create');
    Route::post('/nota', [\App\Http\Controllers\Mandor\NotaBelanjaController::class, 'store'])->name('nota.store');

    // Fitur Update Sisa Stok Material Gudang Lapangan
    Route::get('/material', [\App\Http\Controllers\Mandor\MaterialSisaController::class, 'create'])->name('material.create');
    Route::post('/material', [\App\Http\Controllers\Mandor\MaterialSisaController::class, 'store'])->name('material.store');

    // FIX DROPDOWN: Jalur rute absen pekerja sekarang bersih tanpa parameter ID di URL
    Route::get('/absen-pekerja', [\App\Http\Controllers\Mandor\LaporanHarianController::class, 'createAbsenPekerja'])->name('absen.create');
    Route::post('/absen-pekerja', [\App\Http\Controllers\Mandor\LaporanHarianController::class, 'storeAbsenPekerja'])->name('absen.store');
});

// 5. Kelompok Rute Khusus USER: OWNER
Route::middleware(['auth', 'role:owner'])->prefix('owner')->name('owner.')->group(function () {

    // Dashboard Utama Owner
    Route::get('/dashboard', [\App\Http\Controllers\Owner\OwnerDashboardController::class, 'index'])->name('dashboard');

    // Detail Proyek yang dimiliki oleh Owner tersebut
    Route::get('/proyek/{id}', [\App\Http\Controllers\Owner\OwnerDashboardController::class, 'showProyek'])->name('proyek.show');
});

// 6. Pengaturan Profil Bawaan Laravel Breeze
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
