<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ImportController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::controller(ImportController::class)->group(function () {
        Route::get('/imports', 'index')->name('import');
        Route::post('/imports/client', 'client')->name('import.client');
        Route::post('/imports/staff', 'staff')->name('import.staff');
        Route::post('/imports/wilayah', 'wilayah')->name('import.wilayah');
        Route::post('/imports/kelurahan', 'kelurahan')->name('import.kelurahan');
    });
    //halaman user admin
    Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'index')->name('user');
        Route::get('/users/get', 'get')->name('user.get');
        Route::get('/users/create', 'create')->name('user.create');
        Route::post('/users/store', 'store')->name('user.store');
        Route::get('/users/edit/{id}', 'edit')->name('user.edit');
        Route::post('/users/update/{id}', 'update')->name('user.update');
        Route::post('/users/delete/{id}', 'destroy')->name('user.delete');
    });
});
