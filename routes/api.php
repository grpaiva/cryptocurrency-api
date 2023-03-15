<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CryptocurrencyController;

Route::get('/cryptocurrency/{coin}', [CryptocurrencyController::class, 'getSinglePrice']);
Route::get('/cryptocurrency', [CryptocurrencyController::class, 'getAllPrices']);
