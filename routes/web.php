<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BankSeklolahController;
use App\Http\Controllers\BerandaOperatorController;
use App\Http\Controllers\BerandaWaliController;
use App\Http\Controllers\BiayaController;
use App\Http\Controllers\KartuSppController;
use App\Http\Controllers\KwitansiPembayaranController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WaliController;
use App\Http\Controllers\WaliMuridPembayaranController;
use App\Http\Controllers\WaliMuridSiswaController;
use App\Http\Controllers\WaliMuridTagihanController;
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

Route::get('login/login-url', [LoginController::class, 'loginUrl'])->name('login.url');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::prefix('operator')->middleware(['auth', 'auth.operator'])->group(function () {
    //ini route khusus untuk operator
    Route::get('beranda', [BerandaOperatorController::class, 'index'])->name('operator.beranda');

    // user
    Route::resource('user', UserController::class);

    // bank sekolah
    Route::resource('banksekolah', BankSeklolahController::class);

    // wali
    Route::resource('wali', WaliController::class);

    // siswa
    Route::resource('siswa', SiswaController::class);

    // wali siswa
    Route::resource('walisiswa', WaliSiswaController::class);

    // wali biaya
    Route::resource('biaya', BiayaController::class);

    // tagihan
    Route::resource('tagihan', TagihanController::class);

    // pembayaran
    Route::resource('pembayaran', PembayaranController::class);

    // print kwitansi
    Route::get('kwitansi-pembayaran/{id}', [KwitansiPembayaranController::class, 'show'])->name('kwitansipembayaran.show');

    // kartu spp
    Route::get('kartuspp', [KartuSppController::class, 'index'])->name('kartuspp.index');
});

// login wali
Route::get('/login-wali', [LoginController::class, 'showLoginFormWali'])->name('login.wali');

Route::get('/register-wali', [RegisterController::class, 'showRegistrationForm'])->name('register.wali');


Route::prefix('wali')->middleware(['auth', 'auth.wali'])->name('wali.')->group(function () {
    //ini route khusus untuk wali-murid
    Route::get('beranda', [BerandaWaliController::class, 'index'])->name('beranda');

    // siswa
    Route::resource('siswa', WaliMuridSiswaController::class);

    // tagihan
    Route::resource('tagihan', WaliMuridTagihanController::class);

    // pembayaran
    Route::resource('pembayaran', WaliMuridPembayaranController::class);
});


Route::prefix('admin')->middleware(['auth', 'auth.admin'])->group(function () {
    //ini route khusus untuk admin
});


Route::get('logout', function () {
    Auth::logout();

    return redirect('login');
})->name('logout');
