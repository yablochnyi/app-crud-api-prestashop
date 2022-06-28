<?php

namespace App\Http\Controllers\Prestashop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use PrestaShopWebservice;
use PrestaShopWebserviceException;

class DeleteProductController extends Controller
{
    public function deleteProductOnPrestaShop(Product $product)
    {
        $value = config('prestashop');

        try {
            $webService = new PrestaShopWebservice($value['path'], $value['key'], $value['debug']);
            $webService->delete([
                'resource' => 'products',
                'id' => $product->product_number,
            ]);
            return redirect()->route('products.index')
                ->with('success', 'Product has been deleted successfully.');
        } catch (PrestaShopWebserviceException $e) {
            echo 'Error:' . $e->getMessage();
        }
    }
}
