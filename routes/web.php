<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [CatalogController::class, 'index'])->name('catalog');
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::get('/orders', [OrderController::class, 'index'])->name('order');
Route::get('/order/{id}', [OrderController::class, 'order_update_show'])->name('order_update');

Route::post('/add_to_cart', [CartController::class, 'addToCart']);
Route::post('/delete_from_cart', [CartController::class, 'deleteFromCart']);
Route::post('/submit_order', [OrderController::class, 'submitOrder']);
Route::post('/update_order', [OrderController::class, 'order_update']);
