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

Route::get('/', function() {
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
    
    Route::get('/proyek/get-spbu-by-customer', [ProyekController::class, 'getSpbuByCustomer'])
         ->name('proyek.getSpbuByCustomer');
    Route::get('/proyek/get-next-id', [ProyekController::class, 'getNextProyekId'])
         ->name('proyek.getNextId');
    Route::resource('proyek', ProyekController::class);
});