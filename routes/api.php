<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\ExchangeRateController;

Route::get('/exchange', [ExchangeRateController::class, 'doExchange'])->name('api.exchange');

