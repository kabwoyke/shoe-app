<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/callback', function (Request $request) {
    error_log(print_r("hitted" , true),0);
    // Log::debug("hitted");
});
