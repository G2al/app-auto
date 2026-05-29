<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehicleContractController;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/admin/vehicles/{vehicle}/contract', VehicleContractController::class)
    ->middleware('auth')
    ->name('vehicles.contract');
