<?php

use App\Http\Controllers\Data\ClientController;
use App\Http\Controllers\Pages\DashboardController;
use Illuminate\Support\Facades\Route;

// mengarahkan halaman utama ke login page
Route::get('/', function () {
    return redirect()->route('login');
});

// gruping halaman sudah login
Route::group(['middleware' => 'auth'], function () {
    // halaman dashboard
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
    });
    // halaman data client
    Route::controller(ClientController::class)->group(function () {
        Route::get('/clients', 'index')->name('client');
        Route::get('/clients/search', 'search')->name('client.search');
        Route::get('/clients/filter', 'filter')->name('client.filter');
        Route::get('/clients/create', 'create')->name('client.create');
        Route::post('/clients/store', 'store')->name('client.store');
        Route::get('/clients/edit/{id}', 'edit')->name('client.edit');
        Route::post('/clients/update/{id}', 'update')->name('client.update');
        Route::get('/clients/delete/{id}', 'destroy')->name('client.delete');
        Route::get('/clients/export', 'export')->name('client.export');
        Route::get('/clients/pdf', 'pdf')->name('client.pdf');
        Route::get('/clients/print', 'print')->name('client.print');
    });
});

// gruping halaman belum login
require __DIR__ . '/admin.php';
require __DIR__ . '/auth.php';
