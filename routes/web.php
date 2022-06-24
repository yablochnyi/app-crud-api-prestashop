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

Route::get('/view', function () {
    return view('test');
});

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/products', [\App\Http\Controllers\ProductController::class, 'getProducts'])->name('user.products.index');

});

Route::group(['middleware' => ['auth', 'admin', 'verified']], function () {
    Route::resource('admin/products', \App\Http\Controllers\AdminProductController::class);
    Route::post('admin/delete-product', [\App\Http\Controllers\AdminProductController::class, 'destroy']);
    Route::get('products/export/', [\App\Http\Controllers\ExportImportController::class, 'export'])->name('export');
    Route::post('admin/products/import', [\App\Http\Controllers\ExportImportController::class, 'import'])->name('import');
});


require __DIR__ . '/auth.php';
Route::get('/test/{product}/prestashop', [\App\Http\Controllers\Prestashop\CreateProductController::class, 'addProductOnPrestaShop'])->name('add.prestashop');
Route::get('/tester', [\App\Http\Controllers\Prestashop\TestProductController::class, 'getProducts'])->name('stashop');
Route::get('/test/prestashop', [\App\Http\Controllers\Prestashop\CreateProductController::class, 'addOrUpdateAllProductOnPrestaShop'])->name('add.all.prestashop');
Route::get('/test2', [\App\Http\Controllers\TestController::class, 'gettest'])->name('test2');
