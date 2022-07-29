<?php

namespace App\Http\Controllers\Prestashop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use PrestaShopWebservice;
use PrestaShopWebserviceException;

class DeleteController extends Controller
{
    public static function deleteToPrestashopAndDatabase(Collection $collection)
    {
        try {
            $value = config('prestashop');
            $webService = new PrestaShopWebservice($value['path'], $value['key'], $value['debug']);
            foreach ($collection as $product) {
                $xml = $webService->get([
                    'resource' => 'products',
                    'display' => 'full',
                    'filter[id_manufacturer]' => $product->item_code
                ]);
                $webService->delete([
                    'resource' => 'products',
                    'id' => $xml->products->product->id
                ]);
                Product::where('id', $product->id)->delete();
            }
        } catch (PrestaShopWebserviceException $e) {
            echo 'Error:' . $e->getMessage();
        }
    }
}
