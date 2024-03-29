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
    if (\Illuminate\Support\Facades\Auth::check() && auth()->user()->role == 1 ) {
        return redirect()->route('filament.resources.products.index');
    } elseif (\Illuminate\Support\Facades\Auth::check() && auth()->user()->role == 0) {
        return redirect()->route('filament.resources.user-products.index');
    } else {
        return redirect()->route('filament.auth.login');
    }
});

//Route::group(['middleware' => ['auth', 'admin', 'verified']], function () {
    // EXPORT
    Route::get('admin/products/export/', [\App\Http\Controllers\ExportImportController::class, 'export'])->name('export');
    // PRESTASHOP
    Route::get('add/all/prestashop', [\App\Http\Controllers\Prestashop\CreateAllProductController::class, 'searchProduct'])->name('add.all.prestashop');
    Route::get('update/priceall/prestashop', [\App\Http\Controllers\Prestashop\UpdateProductController::class, 'updateAllProductPriceOnPrestaShop'])->name('update.all.price.prestashop');
    Route::get('update/quantityall/prestashop', [\App\Http\Controllers\Prestashop\UpdateProductController::class, 'updateAllProductQuantityOnPrestaShop'])->name('update.all.quantity.prestashop');
    Route::get('get/category', [\App\Http\Controllers\Prestashop\GetAllCategoryController::class, 'getCategory'])->name('get.category');
    Route::get('get/product', [\App\Http\Controllers\Prestashop\GetAllProductController::class, 'getProduct'])->name('get.product');
    // Cleat DB
//    Route::get('cleat', [\App\Http\Controllers\Cleatdb\DescriptionController::class, 'getDescription'])->name('description.cleat');
//    Route::get('update/description', [\App\Http\Controllers\Prestashop\UpdateDescriptionController::class, 'updateDescriptionOnPrestaShop'])->name('update.description');
//});







