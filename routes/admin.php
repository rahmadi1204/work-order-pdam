<?php

use App\Http\Controllers\ImportController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::controller(ImportController::class)->group(function () {
        Route::get('/imports', 'index')->name('import');
        Route::post('/imports', 'store')->name('import.store');
    });
});
