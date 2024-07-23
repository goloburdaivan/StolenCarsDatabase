<?php

use App\Http\Controllers\AutosController;
use Illuminate\Support\Facades\Route;

Route::controller(AutosController::class)->group(function () {
    Route::get('/autos', 'index')->name('autos.index');
    Route::post('/autos', 'store')->name('autos.store');
    Route::patch('/autos/{auto}', 'update')->name('autos.update');
    Route::delete('/autos/{auto}', 'destroy')->name('autos.destroy');
    Route::get('/autos/export', 'export')->name('autos.export');
});
