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
    return view('welcome');
});
require __DIR__ . '/auth.php';
//
//Route::get('/', function () {
//    if (\Illuminate\Support\Facades\Auth::check()) {
//        return view('admin.product.index');
//    } else {
//        return view('auth.login');
//    }
//});
//
//Route::group(['middleware' => ['auth', 'verified']], function () {
//    Route::get('/products', [\App\Http\Controllers\ProductController::class, 'getProducts'])->name('user.products.index');
//});
//
//Route::group(['middleware' => ['auth', 'admin', 'verified']], function () {
//    // CRUD RME
//    Route::get('admin/products', [\App\Http\Controllers\AdminProductController::class, 'index'])->name('admin.product.index');
//    Route::get('admin/products/create', [\App\Http\Controllers\AdminProductController::class, 'create'])->name('admin.product.create');
//    Route::post('admin/products', [\App\Http\Controllers\AdminProductController::class, 'store'])->name('admin.product.store');
//    Route::get('admin/products/{product}', [\App\Http\Controllers\AdminProductController::class, 'show'])->name('admin.product.show');
//    Route::get('admin/products/{product}/edit', [\App\Http\Controllers\AdminProductController::class, 'edit'])->name('admin.product.edit');
//    Route::patch('admin/products/{product}', [\App\Http\Controllers\AdminProductController::class, 'update'])->name('admin.product.update');
//    Route::post('admin/delete-product', [\App\Http\Controllers\AdminProductController::class, 'destroy']);
//    // EXPORT/IMPORT
    Route::get('products/export/', [\App\Http\Controllers\ExportImportController::class, 'export'])->name('export');
    Route::post('admin/products/import', [\App\Http\Controllers\ExportImportController::class, 'import'])->name('import');
//    Route::view('admin/products/import', 'admin.product.modal')->name('import');
//    // PRESTASHOP
//    Route::post('add/all/prestashop', [\App\Http\Controllers\Prestashop\CreateAllProductController::class, 'searchProduct'])->name('add.all.prestashop');
//    Route::post('add/{product}/prestashop', [\App\Http\Controllers\Prestashop\CreateProductController::class, 'searchProduct'])->name('add.prestashop');
//    Route::put('update/price/{product}/prestashop', [\App\Http\Controllers\Prestashop\UpdateProductController::class, 'updateProductPriceOnPrestaShop'])->name('update.price.prestashop');
//    Route::get('update/price/all/prestashop', [\App\Http\Controllers\Prestashop\UpdateProductController::class, 'updateAllProductPriceOnPrestaShop'])->name('update.all.price.prestashop');
//    Route::put('update/quantity/{product}/prestashop', [\App\Http\Controllers\Prestashop\UpdateProductController::class, 'updateProductQuantityOnPrestaShop'])->name('update.quantity.prestashop');
//    Route::get('update/quantity/all/prestashop', [\App\Http\Controllers\Prestashop\UpdateProductController::class, 'updateAllProductQuantityOnPrestaShop'])->name('update.all.quantity.prestashop');
    // Cleat DB
//    Route::get('cleat', [\App\Http\Controllers\Cleatdb\DescriptionController::class, 'getDescription'])->name('description.cleat');
//    Route::get('update/description', [\App\Http\Controllers\Prestashop\UpdateDescriptionController::class, 'updateDescriptionOnPrestaShop'])->name('update.description');
//});







