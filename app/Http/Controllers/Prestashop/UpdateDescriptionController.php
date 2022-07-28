<?php

namespace App\Http\Controllers\Prestashop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use PrestaShopWebservice;
use PrestaShopWebserviceException;

class UpdateDescriptionController extends Controller
{
    public function updateDescriptionOnPrestaShop()
    {
        $value = config('prestashop');
        $products = Product::all();
        try {
            $webService = new PrestaShopWebservice($value['path'], $value['key'], $value['debug']);
            foreach ($products as $product) {
                $xml = $webService->get([
                    'resource' => 'products',
                    'display' => 'full',
                    'filter[id_manufacturer]' => $product->item_code
                ]);

                $resource = $xml->products->children()->children();

                $xml = $webService->get([
                    'resource' => 'products',
                    'id' => $resource->id,
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

                $productFields->description->language[0] = $product->description;
                $productFields->description_short->language[0] = $product->short_description;

                $webService->edit([
                    'resource' => 'products',
                    'id' => (int)$productFields->id,
                    'putXml' => $xml->asXML(),
                ]);
            }
        } catch (PrestaShopWebserviceException $ex) {

            echo 'Other error: <br />' . $ex->getMessage();
        }
    }
}
