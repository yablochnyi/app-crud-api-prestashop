<?php

namespace App\Http\Controllers\Prestashop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use PrestaShopWebservice;
use PrestaShopWebserviceException;

class UpdateProductController extends Controller
{
    public function updateProductPriceOnPrestaShop(Product $product)
    {
        $value = config('prestashop');

        try {
            $webService = new PrestaShopWebservice($value['path'], $value['key'], $value['debug']);

            $xml = $webService->get([
                'resource' => 'products',
                'id' => $product->product_number,
            ]);

            $productFields = $xml->children()->children();

            unset($productFields->manufacturer_name);
            unset($productFields->quantity);
            unset($productFields->id_shop_default);
            unset($productFields->id_default_image);
            unset($productFields->associations);
            unset($productFields->id_default_combination);
            unset($productFields->position_in_category);
            unset($productFields->type);
            unset($productFields->pack_stock_type);
            unset($productFields->date_add);
            unset($productFields->date_upd);

            $productFields->price = $product->price_aed;

            $webService->edit([
                'resource' => 'products',
                'id' => $product->product_number,
                'putXml' => $xml->asXML(),
            ]);
            return redirect()->route('products.index')
                ->with('success', 'Price Has Been updated successfully');
        } catch (PrestaShopWebserviceException $ex) {

            echo 'Other error: <br />' . $ex->getMessage();
        }
    }

    public function updateProductQuantityOnPrestaShop(Product $product)
    {
        $value = config('prestashop');

        $webService = new PrestaShopWebservice($value['path'], $value['key'], $value['debug']);
        $opt = array('resource' => 'stock_availables');
        $opt['id'] = 236;
        $xml = $webService->get($opt);

        $resources = $xml->children()->children();
        dd($resources);
    }
}


//updated quantity
//    public function getQuantity(Product $product)
//    {
//        define('PS_SHOP_PATH', '');
//        define('PS_WS_AUTH_KEY', '');
//
//        $webService = new PrestaShopWebservice(PS_SHOP_PATH, PS_WS_AUTH_KEY, true);
//        $opt = array('resource' => 'stock_availables');
//        $opt['id'] = 19;
//        $xml = $webService->get($opt);
//
//        $resources = $xml->children()->children();
//        dd($resources);


// reference

//        require_once 'PSWebServiceLibrary.php';
//
//        $url = '';
//        $key = '';
//        $debug = true;
//        $webService = new PrestaShopWebservice($url, $key, $debug);
//
//        $searchTerm = "YOURPRODUCTREFERENCE";
//        $xml = $webService->get([
//            'resource' => 'products',
//            'display' => 'full',
//            'filter[reference]' => $searchTerm
//        ]);
//        $resource = $xml->products->children()->children();

