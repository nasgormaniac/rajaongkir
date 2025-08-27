<?php

use App\Http\Controllers\RajaOngkirController;
use Illuminate\Support\Facades\Route;

Route::get('/', [RajaOngkirController::class, 'index']);

Route::get('/cities/{provinceId}', [RajaOngkirController::class, 'getCities']);

Route::get('/districts/{cityId}', [RajaOngkirController::class, 'getDistrics']);

Route::post('/check-ongkir', [RajaOngkirController::class, 'checkOngkir']);
