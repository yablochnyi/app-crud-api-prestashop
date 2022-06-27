<?php

namespace App\Http\Controllers\Prestashop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use PrestaShopWebservice;
use PrestaShopWebserviceException;

class UpdateProductController extends Controller
{
    public function updateProductOnPrestaShop()
    {
        define('PS_SHOP_PATH', 'https://rme.rywal.dev/');
        define('PS_WS_AUTH_KEY', 'V8B6U7TS71NCU18K1WLG4F4CI6A4IMHF');

//        $webService = new PrestaShopWebservice(PS_SHOP_PATH, PS_WS_AUTH_KEY, true);
//        $resources = array('resource' => 'products');
//        $resources['id'] = $product->product_number;
//        $xml = $webService->get($resources);
//
//        $resources = $xml->children()->children();
//
//        $resources->price = 5;
//
//
//        $resources = array('resource' => 'products');
//        $resources['putXml'] = $xml->asXML();
//        $resources['id'] = $product->product_number;
//        $xml = $webService->edit($resources);
//        $updatedXml->children()->children();


        // creating webservice access
        $webService = new PrestaShopWebservice(PS_SHOP_PATH, PS_WS_AUTH_KEY, true);            // call to retrieve customer with ID 2
        $xml = $webService->get([
            'resource' => 'products',
            'id' => 19, // Here we use hard coded value but of course you could get this ID from a request parameter or anywhere else
        ]);
        $resources = $xml->children()->children();
        $resources->id = 19;
        $resources->price = 6.9;

        try {
            $opt = array('resource' => 'products');
            $opt['putXml'] = $xml->asXML();
            $opt['id'] = 19;
            $xml = $webService->edit($opt);
        } catch (PrestaShopWebserviceException $ex) {
            echo 'Error: <br />' . $ex->getMessage();
        }

//        $updatedXml = $webService->edit([
//            'resource' => 'products',
//            'id' => $customerFields->id,
//            'putXml' => $xml->asXML(),
//        ]);

//    }



//updated quantity
//    public function getQuantity(Product $product)
//    {
//        define('PS_SHOP_PATH', 'https://rme.rywal.dev/');
//        define('PS_WS_AUTH_KEY', 'V8B6U7TS71NCU18K1WLG4F4CI6A4IMHF');
//
//        $webService = new PrestaShopWebservice(PS_SHOP_PATH, PS_WS_AUTH_KEY, true);
//        $opt = array('resource' => 'stock_availables');
//        $opt['id'] = 19;
//        $xml = $webService->get($opt);
//
//        $resources = $xml->children()->children();
//        dd($resources);
    }
}
