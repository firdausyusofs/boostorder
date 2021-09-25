<?php

use App\Http\Controllers\CatalogController;
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
Route::get('/cart', [CatalogController::class, 'cart'])->name('cart');
Route::get('/orders', [CatalogController::class, 'order'])->name('order');
Route::get('/order/{id}', [CatalogController::class, 'order_update_show'])->name('order_update');

Route::post('/add_to_cart', [CatalogController::class, 'addToCart']);
Route::post('/delete_from_cart', [CatalogController::class, 'deleteFromCart']);
Route::post('/submit_order', [CatalogController::class, 'submitOrder']);
