<?php

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

Route::get('/', function () {
    if (\Illuminate\Support\Facades\Auth::check()) {
        return view('user.product.index');
    } else {
        return view('auth.login');
    }
});

Route::group(['middleware' => ['auth', 'admin', 'verified']], function () {
    Route::resource('admin/products', \App\Http\Controllers\AdminProductController::class);
    Route::post('admin/delete-product', [\App\Http\Controllers\AdminProductController::class, 'destroy']);
});

Route::get('/products', [\App\Http\Controllers\ProductController::class, 'getProducts'])->name('user.products.index');

require __DIR__ . '/auth.php';
