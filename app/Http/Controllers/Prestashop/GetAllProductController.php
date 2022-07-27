<?php

namespace App\Http\Controllers\Prestashop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use PrestaShopWebservice;
use PrestaShopWebserviceException;

class GetAllProductController extends Controller
{
    public function getProduct()
    {
        $value = config('prestashop');
        try {
            $webService = new PrestaShopWebservice($value['path'], $value['key'], $value['debug']);
            $opt['resource'] = 'products';

            $xml = $webService->get($opt);
            $resources = $xml->products;
            foreach ($resources->product as $product) {
                $xml = $webService->get([
                    'resource' => 'products',
                    'id' => $product->attributes()['id'],
                ]);
                print_r($xml->unity);
                dd($xml);
                Product::firstOrCreate([
                    'product_name' => $xml->product->name->language[0]
                ], [
                    'product_name' => $xml->product->name->language[0],
                    'product_number' => $xml->product->reference,
                    'category_id' => $xml->product->id_category_default,
                    'quantity' => $xml->product->quantity,
                    'price_aed' => $xml->product->price,
                    'description' => $xml->product->description->language[1],
                    'short_description' => $xml->product->description_short->language[1],
                ]);
            }
            return redirect()->route('filament.resources.products.index');
        } catch (PrestaShopWebserviceException $ex) {

            echo 'Other error: <br />' . $ex->getMessage();
        }
    }
}
