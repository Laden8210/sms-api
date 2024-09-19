<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SMSController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/send-sms', [SMSController::class, 'sendSMS']);

Route::get('/get-sms', [SMSController::class, 'getSMS']);
Route::put('/update-status/{id}', [SMSController::class, 'updateStatus']);
