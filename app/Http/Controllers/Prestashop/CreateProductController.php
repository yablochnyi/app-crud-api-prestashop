<?php

namespace App\Http\Controllers\Prestashop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use PrestaShopWebservice;
use PrestaShopWebserviceException;

class CreateProductController extends Controller
{
    public function addProductOnPrestaShop(Product $product)
    {
        define('PS_SHOP_PATH', 'https://rme.rywal.dev/');
        define('PS_WS_AUTH_KEY', 'V8B6U7TS71NCU18K1WLG4F4CI6A4IMHF');

        try {
            $webService = new PrestaShopWebservice(PS_SHOP_PATH, PS_WS_AUTH_KEY, true);
            $products = array('resource' => 'products');
            $xml = $webService->get(array('url' => PS_SHOP_PATH . '/api/products?schema=blank'));
            $resource_product = $xml->children()->children();

            unset($resource_product->position_in_category);

            $resource_product->id_category_default = $product->category_id;
            $resource_product->price = $product->price_aed;
            $resource_product->active = 1;
            $resource_product->name->language[0] = $product->product_name;
            $resource_product->state = 1;

            $products['postXml'] = $xml->asXML();
            $webService->add($products);

        } catch (PrestaShopWebserviceException $ex) {
            echo 'Error: <br />' . $ex->getMessage();
        }
        return redirect()->route('products.index')
            ->with('success', 'Product Has Been created successfully');
    }

    public function addOrUpdateAllProductOnPrestaShop()
    {
        define('PS_SHOP_PATH', 'https://rme.rywal.dev/');
        define('PS_WS_AUTH_KEY', 'V8B6U7TS71NCU18K1WLG4F4CI6A4IMHF');

        $products = Product::all();

        try {
            $webService = new PrestaShopWebservice(PS_SHOP_PATH, PS_WS_AUTH_KEY, false);
            $opt = array('resource' => 'products');
            $xml = $webService->get(array('url' => PS_SHOP_PATH . '/api/products?schema=blank'));
            $resource_product = $xml->children()->children();

            unset($resource_product->position_in_category);

            foreach ($products as $product) {
                $resource_product->id_category_default = $product->category_id;
                $resource_product->price = $product->price_aed;
                $resource_product->active = 1;
                $resource_product->name->language[0] = $product->product_name;
                $resource_product->state = 1;

                $opt['postXml'] = $xml->asXML();
                $webService->add($opt);
            }

        } catch (PrestaShopWebserviceException $ex) {
            echo 'Error: <br />' . $ex->getMessage();
        }
        return redirect()->route('products.index')
            ->with('success', 'Product Has Been created successfully');
    }
}
