<?php

use App\Http\Controllers\Data\AreaController;
use App\Http\Controllers\Data\ClientController;
use App\Http\Controllers\Data\StaffController;
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
    // halaman data area
    Route::controller(AreaController::class)->group(function () {
        Route::get('/areas', 'index')->name('area');
        Route::get('/areas/get', 'get')->name('area.get');
        Route::get('/areas/search', 'search')->name('area.search');
        Route::get('/areas/wilayah', 'wilayah')->name('area.wilayah');
        Route::get('/areas/create', 'create')->name('area.create');
        Route::post('/areas/store', 'store')->name('area.store');
        Route::get('/areas/edit/{id}', 'edit')->name('area.edit');
        Route::post('/areas/update/{id}', 'update')->name('area.update');
        Route::post('/areas/delete/{id}', 'destroy')->name('area.delete');
        Route::get('/areas/export', 'export')->name('area.export');
        Route::get('/areas/pdf', 'pdf')->name('area.pdf');
        Route::get('/areas/print', 'print')->name('area.print');
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
        Route::post('/clients/delete/{id}', 'destroy')->name('client.delete');
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
        Route::post('/staffs/delete/{id}', 'destroy')->name('staff.delete');
        Route::get('/staffs/export', 'export')->name('staff.export');
        Route::get('/staffs/pdf', 'pdf')->name('staff.pdf');
        Route::get('/staffs/print', 'print')->name('staff.print');
    });
});

// gruping halaman belum login
require __DIR__ . '/admin.php';
require __DIR__ . '/auth.php';
