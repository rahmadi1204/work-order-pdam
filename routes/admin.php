<?php

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
});
