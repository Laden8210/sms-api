<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('welcome');
});




Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
Route::get('logout',[AuthController::class, 'logout'])->name('logout');
Route::get('admin', [AuthController::class, 'admin'])->name('admin');


Route::post('/create-order', [OrderController::class, 'createOrder'])->name('createOrder');
