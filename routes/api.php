<?php

use App\Http\Controllers\AuthenticationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(AuthenticationController::class)->group(function(){
    Route::post('login', 'login');
});
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
