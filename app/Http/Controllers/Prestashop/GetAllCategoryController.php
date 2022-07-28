<?php

namespace App\Http\Controllers\Prestashop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use PrestaShopWebservice;
use PrestaShopWebserviceException;

class GetAllCategoryController extends Controller
{
    public function getCategory()
    {
        $value = config('prestashop');
        try {
            $webService = new PrestaShopWebservice($value['path'], $value['key'], $value['debug']);
            $opt['resource'] = 'categories';

            $xml = $webService->get($opt);
            $resources = $xml->categories;
            foreach ($resources->category as $category) {
                $xml = $webService->get([
                    'resource' => 'categories',
                    'id' => $category->attributes()['id'],
                ]);
                Category::firstOrCreate([
                    'title' => $xml->category->name->language[0]
                ], [
                    'prestashop_id' => $xml->category->id,
                    'title' => $xml->category->name->language[0]
                ]);
            }
            return redirect()->route('filament.resources.products.index');
        } catch (PrestaShopWebserviceException $ex) {

            echo 'Other error: <br />' . $ex->getMessage();
        }
    }
}
