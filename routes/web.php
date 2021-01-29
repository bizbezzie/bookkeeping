<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::prefix('bizbezzie/bookkeeping')->group(function () {
    //Here will go BizBezzie Routes
});

Route::get('vouchers', [HomeController::class, 'getVoucherNames']);