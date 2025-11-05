<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SpbuController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProyekController;
use App\Http\Controllers\TransaksiController;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::resource('karyawan', KaryawanController::class);
    Route::resource('supplier', SupplierController::class);
    Route::resource('customer', CustomerController::class);
    Route::resource('spbu', SpbuController::class);
    Route::resource('material', MaterialController::class);

    Route::get('/proyek/get-spbu-by-customer', [ProyekController::class, 'getSpbuByCustomer'])->name('proyek.getSpbuByCustomer');
    Route::get('/proyek/get-next-id', [ProyekController::class, 'getNextProyekId'])->name('proyek.getNextId');
    Route::resource('proyek', ProyekController::class);
    Route::get('/proyek/{proyek}/print', [ProyekController::class, 'printPdf'])
     ->name('proyek.printPdf');

    Route::prefix('transaksi')
        ->name('transaksi.')
        ->group(function () {
            Route::get('/', [TransaksiController::class, 'index'])->name('index');
            Route::get('/{transaksi}', [TransaksiController::class, 'show'])->name('show');
            Route::post('/', [TransaksiController::class, 'store'])->name('store');
            Route::patch('/{transaksi}/update-status', [TransaksiController::class, 'updateStatus'])->name('updateStatus');
            Route::post('/{transaksi}/add-material', [TransaksiController::class, 'addMaterial'])->name('addMaterial');
            Route::delete('/remove-material/{item}', [TransaksiController::class, 'removeMaterial'])->name('removeMaterial');
            Route::post('/{transaksi}/add-karyawan', [TransaksiController::class, 'addKaryawan'])->name('addKaryawan');
            Route::delete('/remove-karyawan/{item}', [TransaksiController::class, 'removeKaryawan'])->name('removeKaryawan');
            Route::post('/{transaksi}/add-pengeluaran', [TransaksiController::class, 'addPengeluaran'])->name('addPengeluaran');
            Route::delete('/remove-pengeluaran/{item}', [TransaksiController::class, 'removePengeluaran'])->name('removePengeluaran');
        });
});
