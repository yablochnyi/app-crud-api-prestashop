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
        define('PS_SHOP_PATH', 'https://rme.rywal.dev/');
        define('PS_WS_AUTH_KEY', 'V8B6U7TS71NCU18K1WLG4F4CI6A4IMHF');

        try {
            $webService = new PrestaShopWebservice(PS_SHOP_PATH, PS_WS_AUTH_KEY, true);
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
