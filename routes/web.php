<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', App\Livewire\Auth\Login::class)->name('login')->middleware('guest'); 

// GRUP RUTE APLIKASI UTAMA
Route::middleware('auth')->group(function () {

    // Rute yang bisa diakses SEMUA role (0, 1, 2)
    Route::get('/request-surat', \App\Livewire\RequestSurat\Index::class)->name('request-surat');
    Route::get('/profile', \App\Livewire\Profile\EditProfile::class)->name('profile');


    // Rute yang hanya bisa diakses oleh ADMIN (0) dan ARSIP (1)
    Route::middleware('role:0,1')->group(function () {
        Route::get('/homepage', \App\Livewire\Homepage\Index::class)->name('homepage');
        Route::get('/surat-masuk', \App\Livewire\SuratMasuk\Index::class)->name('surat-masuk');
        Route::get('/surat-keluar', \App\Livewire\SuratKeluar\Index::class)->name('surat-keluar');
        Route::get('/log-surat', \App\Livewire\LogSurat\Index::class)->name('log-surat');
    });


    // Rute yang HANYA bisa diakses oleh ADMIN (0)
    Route::middleware('role:0')->group(function () {
        Route::get('/list-user', \App\Livewire\ListUser\Index::class)->name('list-user');
    });

});


require __DIR__.'/auth.php';
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
