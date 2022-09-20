<?php

use App\Http\Controllers\Data\AreaController;
use App\Http\Controllers\Data\ClientController;
use App\Http\Controllers\Data\StaffController;
use App\Http\Controllers\Pages\DashboardController;
use App\Http\Controllers\Transaction\WorkOrderController;
use App\Http\Controllers\Types\TypeDocumentController;
use App\Http\Controllers\Types\TypeWorkOrderController;
use Illuminate\Support\Facades\Route;

// mengarahkan halaman utama ke login page
Route::get('/', function () {
    return redirect()->route('login');
});

// gruping halaman sudah login
Route::group(['middleware' => 'auth'], function () {
    // halaman dashboard
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard'); // view halaman dashboard
    });

    // halaman data area
    Route::controller(AreaController::class)->group(function () {
        Route::get('/areas', 'index')->name('area'); //view halaman
        Route::get('/areas/get', 'get')->name('area.get'); //ambil data
        Route::get('/areas/search', 'search')->name('area.search'); //cari data
        Route::get('/areas/wilayah', 'wilayah')->name('area.wilayah'); //ambil data wilayah
        Route::get('/areas/create', 'create')->name('area.create'); //view form tambah
        Route::post('/areas/store', 'store')->name('area.store'); //simpan data
        Route::get('/areas/edit/{id}', 'edit')->name('area.edit'); //view form edit
        Route::post('/areas/update/{id}', 'update')->name('area.update'); //update data
        Route::post('/areas/delete/{id}', 'destroy')->name('area.delete'); //hapus data
    });
    // halaman data karyawan
    Route::controller(StaffController::class)->group(function () {
        Route::get('/staffs', 'index')->name('staff'); //view halaman
        Route::get('/staffs/search', 'search')->name('staff.search'); //cari data
        Route::get('/staffs/filter', 'filter')->name('staff.filter'); //filter data
        Route::get('/staffs/create', 'create')->name('staff.create'); //view form tambah
        Route::post('/staffs/store', 'store')->name('staff.store'); //simpan data
        Route::get('/staffs/edit/{id}', 'edit')->name('staff.edit'); //view form edit
        Route::post('/staffs/update/{id}', 'update')->name('staff.update'); //update data
        Route::post('/staffs/delete/{id}', 'destroy')->name('staff.delete'); //hapus data
        Route::get('/staffs/export', 'export')->name('staff.export'); //export data
        Route::get('/staffs/pdf', 'pdf')->name('staff.pdf'); //export pdf
        Route::get('/staffs/print', 'print')->name('staff.print'); //print data
    });

    // halaman data client
    Route::controller(ClientController::class)->group(function () {
        Route::get('/clients', 'index')->name('client'); //view halaman
        Route::get('/clients/get', 'get')->name('client.get'); //ambil data
        Route::get('/clients/select', 'select')->name('client.select'); //pilih data
        Route::get('/clients/create', 'create')->name('client.create'); //view form tambah
        Route::get('/clients/check', 'check')->name('client.check'); //check id pelanggan
        Route::post('/clients/store', 'store')->name('client.store'); //simpan data
        Route::get('/clients/edit/{id}', 'edit')->name('client.edit'); //view form edit
        Route::post('/clients/update/{id}', 'update')->name('client.update'); //update data
        Route::post('/clients/delete/{id}', 'destroy')->name('client.delete'); //hapus data
        Route::get('/clients/export', 'export')->name('client.export'); //export data
        Route::get('/clients/pdf', 'pdf')->name('client.pdf'); //export pdf
        Route::get('/clients/print', 'print')->name('client.print'); //print data
    });

    // halaman data Jenis Work order
    Route::controller(TypeWorkOrderController::class)->group(function () {
        Route::get('/types/work-order', 'index')->name('type.work-order'); //view halaman
        Route::get('/types/work-order/get', 'get')->name('type.work-order.get'); //ambil data
        Route::get('/types/work-order/create', 'create')->name('type.work-order.create'); //view form tambah
        Route::post('/types/work-order/store', 'store')->name('type.work-order.store'); //simpan data
        Route::get('/types/work-order/edit/{id}', 'edit')->name('type.work-order.edit'); //view form edit
        Route::post('/types/work-order/update/{id}', 'update')->name('type.work-order.update'); //update data
        Route::post('/types/work-order/delete/{id}', 'destroy')->name('type.work-order.delete'); //hapus data
    });
    // halaman data Jenis Document
    Route::controller(TypeDocumentController::class)->group(function () {
        Route::get('/types/document', 'index')->name('type.document'); //view halaman
        Route::get('/types/document/get', 'get')->name('type.document.get'); //ambil data
        Route::get('/types/document/create', 'create')->name('type.document.create'); //view form tambah
        Route::post('/types/document/store', 'store')->name('type.document.store'); //simpan data
        Route::get('/types/document/edit/{id}', 'edit')->name('type.document.edit'); //view form edit
        Route::post('/types/document/update/{id}', 'update')->name('type.document.update'); //update data
        Route::post('/types/document/delete/{id}', 'destroy')->name('type.document.delete'); //hapus data
    });

    // halaman transaksi Work order
    Route::controller(WorkOrderController::class)->group(function () {
        Route::get('/work-order', 'index')->name('work-order'); //view halaman
        Route::get('/work-order/request', 'permintaan')->name('work-order.request'); //view halaman permintaan
        Route::get('/work-order/response', 'respon')->name('work-order.process'); //view halaman proses
        Route::get('/work-order/realization', 'realisasi')->name('work-order.realization'); //view halaman realisasi
        Route::get('/work-order/get', 'get')->name('work-order.get'); //ambil data
        Route::get('/work-order/create', 'create')->name('work-order.create'); //view form tambah
        Route::post('/work-order/store', 'store')->name('work-order.store'); //simpan data
        Route::get('/work-order/edit/{id}', 'edit')->name('work-order.edit'); //view form edit
        Route::post('/work-order/update/{id}', 'update')->name('work-order.update'); //update data
        Route::post('/work-order/delete/{id}', 'destroy')->name('work-order.delete'); //hapus data
    });

});

// gruping authentikasi
require __DIR__ . '/auth.php';

// route khusus admin
require __DIR__ . '/admin.php';
