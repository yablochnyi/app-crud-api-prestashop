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
        return redirect()->route('products.index');
    } else {
        return view('auth.login');
    }
});


Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::resource('products', \App\Http\Controllers\ProductController::class);
    Route::post('/delete-product', [\App\Http\Controllers\ProductController::class,'destroy']);
});


require __DIR__ . '/auth.php';
