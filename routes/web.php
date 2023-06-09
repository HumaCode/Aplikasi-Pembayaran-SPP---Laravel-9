<?php

use App\Http\Controllers\BerandaOperatorController;
use App\Http\Controllers\BerandaWaliController;
use App\Http\Controllers\BiayaController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WaliController;
use App\Http\Controllers\WaliSiswaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::prefix('operator')->middleware(['auth', 'auth.operator'])->group(function () {
    //ini route khusus untuk operator
    Route::get('beranda', [BerandaOperatorController::class, 'index'])->name('operator.beranda');

    // user
    Route::resource('user', UserController::class);

    // wali
    Route::resource('wali', WaliController::class);

    // siswa
    Route::resource('siswa', SiswaController::class);

    // wali siswa
    Route::resource('walisiswa', WaliSiswaController::class);

    // wali biaya
    Route::resource('biaya', BiayaController::class);
});


Route::prefix('wali')->middleware(['auth', 'auth.wali'])->group(function () {
    //ini route khusus untuk wali-murid
    Route::get('beranda', [BerandaWaliController::class, 'index'])->name('wali.beranda');
});


Route::prefix('admin')->middleware(['auth', 'auth.admin'])->group(function () {
    //ini route khusus untuk admin
});


Route::get('logout', function () {
    Auth::logout();

    return redirect('login');
})->name('logout');
