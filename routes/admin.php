<?php

use App\Http\Controllers\ImportController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::controller(ImportController::class)->group(function () {
        Route::get('/imports', 'index')->name('import');
        Route::post('/imports/client', 'client')->name('import.client');
        Route::post('/imports/staff-category', 'staffCategory')->name('import.staff.category');
        Route::post('/imports/staff', 'staff')->name('import.staff');
    });
});
