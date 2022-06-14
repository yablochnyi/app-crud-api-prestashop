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
//        return view('product.index');
        return redirect()->route('products');
    } else {
        return view('auth.login');
    }
});


Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/products', [\App\Http\Controllers\ProductController::class, 'index'])->name('products');
//    Route::get('/create', 'CreateController')->name('admin.post.create');
//    Route::post('/', 'StoreController')->name('admin.post.store');
//    Route::get('/{post}', 'ShowController')->name('admin.post.show');
//    Route::get('/{post}/edit', 'EditController')->name('admin.post.edit');
//    Route::patch('/{post}', 'UpdateController')->name('admin.post.update');
//    Route::delete('/{post}', 'DeleteController')->name('admin.post.delete');


//    Route::resource('products', \App\Http\Controllers\ProductController::class);
//    Route::group(['namespace' => 'Main', 'prefix' => 'main'], function () {
//        Route::get('/', 'IndexController')->name('personal.main.index');
//    });
});
//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
