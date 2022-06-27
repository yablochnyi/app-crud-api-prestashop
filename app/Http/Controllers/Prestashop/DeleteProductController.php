<?php

namespace App\Http\Controllers\Prestashop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use PrestaShopWebservice;
use PrestaShopWebserviceException;

class DeleteProductController extends Controller
{
    public function DeleteProductOnPrestaShop(Product $product)
    {
        define('PS_SHOP_PATH', 'https://rme.rywal.dev/');
        define('PS_WS_AUTH_KEY', 'V8B6U7TS71NCU18K1WLG4F4CI6A4IMHF');

        try {
            $webService = new PrestaShopWebservice(PS_SHOP_PATH, PS_WS_AUTH_KEY, true);
//            $id = $product->product_number;
            $webService->delete([
                'resource' => 'products',
                'id' => $product->product_number, // Here we use hard coded value but of course you could get this ID from a request parameter or anywhere else
            ]);
            echo 'Customer with ID ' . $product->product_number . ' was successfully deleted' . PHP_EOL;
        } catch (PrestaShopWebserviceException $e) {
            echo 'Error:' . $e->getMessage();
        }
    }
}
