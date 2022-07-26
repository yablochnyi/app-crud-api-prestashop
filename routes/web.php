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
        return redirect()->route('filament.resources.user-products.index');
    } else {
        return view('auth.login');
    }
});

//Route::group(['middleware' => ['auth', 'admin', 'verified']], function () {
    // EXPORT/IMPORT
    Route::get('admin/products/export/', [\App\Http\Controllers\ExportImportController::class, 'export'])->name('export');
//    Route::post('admin/products/import', [\App\Http\Controllers\ExportImportController::class, 'import'])->name('import');
    // PRESTASHOP
    Route::get('add/all/prestashop', [\App\Http\Controllers\Prestashop\CreateAllProductController::class, 'searchProduct'])->name('add.all.prestashop');
    Route::get('add/{product}/prestashop', [\App\Http\Controllers\Prestashop\CreateProductController::class, 'searchProduct'])->name('add.prestashop');
    Route::get('update/price/{product}/prestashop', [\App\Http\Controllers\Prestashop\UpdateProductController::class, 'updateProductPriceOnPrestaShop'])->name('update.price.prestashop');
    Route::get('update/price/all/prestashop', [\App\Http\Controllers\Prestashop\UpdateProductController::class, 'updateAllProductPriceOnPrestaShop'])->name('update.all.price.prestashop');
    Route::get('update/quantity/{product}/prestashop', [\App\Http\Controllers\Prestashop\UpdateProductController::class, 'updateProductQuantityOnPrestaShop'])->name('update.quantity.prestashop');
    Route::get('update/quantity/all/prestashop', [\App\Http\Controllers\Prestashop\UpdateProductController::class, 'updateAllProductQuantityOnPrestaShop'])->name('update.all.quantity.prestashop');
    // Cleat DB
//    Route::get('cleat', [\App\Http\Controllers\Cleatdb\DescriptionController::class, 'getDescription'])->name('description.cleat');
//    Route::get('update/description', [\App\Http\Controllers\Prestashop\UpdateDescriptionController::class, 'updateDescriptionOnPrestaShop'])->name('update.description');
//});







