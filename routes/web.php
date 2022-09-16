<?php

use App\Http\Controllers\Data\ClientController;
use App\Http\Controllers\Master\StaffController;
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
    // halaman data karyawan
    Route::controller(StaffController::class)->group(function () {
        Route::get('/staffs', 'index')->name('staff');
        Route::get('/staffs/search', 'search')->name('staff.search');
        Route::get('/staffs/filter', 'filter')->name('staff.filter');
        Route::get('/staffs/create', 'create')->name('staff.create');
        Route::post('/staffs/store', 'store')->name('staff.store');
        Route::get('/staffs/edit/{id}', 'edit')->name('staff.edit');
        Route::post('/staffs/update/{id}', 'update')->name('staff.update');
        Route::get('/staffs/delete/{id}', 'destroy')->name('staff.delete');
        Route::get('/staffs/export', 'export')->name('staff.export');
        Route::get('/staffs/pdf', 'pdf')->name('staff.pdf');
        Route::get('/staffs/print', 'print')->name('staff.print');
    });
});

// gruping halaman belum login
require __DIR__ . '/admin.php';
require __DIR__ . '/auth.php';
