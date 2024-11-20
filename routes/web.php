<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('welcome');
});




Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
Route::get('logout',[AuthController::class, 'logout'])->name('logout');
Route::get('admin', [AuthController::class, 'admin'])->name('admin');
Route::post('/orders/update', [OrderController::class, 'updateOrder'])->name('orders.update');
Route::post('/payments/submit', [OrderController::class, 'submitPayment'])->name('payments.submit');

Route::post('/create-order', [OrderController::class, 'createOrder'])->name('createOrder');
Route::post('/orders/store', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/download-all', [OrderController::class, 'downloadAllOrders'])->name('orders.download-all');
