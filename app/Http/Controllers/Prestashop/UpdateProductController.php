<?php

namespace App\Http\Controllers\Prestashop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use PrestaShopWebservice;
use PrestaShopWebserviceException;

class UpdateProductController extends Controller
{
    public static function updateProductPriceOnPrestaShop(Collection $collection)
    {
        $value = config('prestashop');

        try {
            $webService = new PrestaShopWebservice($value['path'], $value['key'], $value['debug']);
            foreach ($collection as $product) {
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

                $productFields->price = $product->price_aed;

                $webService->edit([
                    'resource' => 'products',
                    'id' => (int)$productFields->id,
                    'putXml' => $xml->asXML(),
                ]);
            }
            return redirect()->route('filament.resources.products.index')
                ->with('success', 'Price Has Been updated successfully');
        } catch (PrestaShopWebserviceException $ex) {

            echo 'Other error: <br />' . $ex->getMessage();
        }
    }

    public static function updateAllProductPriceOnPrestaShop()
    {
        $products = Product::all();
        $value = config('prestashop');

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

                $productFields->price = $product->price_aed;

                $webService->edit([
                    'resource' => 'products',
                    'id' => (int)$productFields->id,
                    'putXml' => $xml->asXML(),
                ]);
            }
            return redirect()->route('filament.resources.products.index')
                ->with('success', 'Prices Has Been updated successfully');
        } catch (PrestaShopWebserviceException $ex) {

            echo 'Other error: <br />' . $ex->getMessage();
        }
    }

    public static function updateProductQuantityOnPrestaShop(Collection $collection)
    {
        $value = config('prestashop');
        try {
            $webService = new PrestaShopWebservice($value['path'], $value['key'], $value['debug']);

            foreach ($collection as $product) {
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

                $item = $xml->product->associations->stock_availables->stock_available;

                $xml = $webService->get(array('url' => $value['path'] . '/api/stock_availables?schema=blank'));
                $resources = $xml->children()->children();
                $resources->id = $item->id;
                $resources->id_product = $resource->id;
                $resources->quantity = $product->quantity;
                $resources->id_shop = 1;
                $resources->out_of_stock = 1;
                $resources->depends_on_stock = 0;
                $resources->id_product_attribute = $item->id_product_attribute;

                $opt = array('resource' => 'stock_availables');
                $opt['putXml'] = $xml->asXML();
                $opt['id'] = $item->id;
                $xml = $webService->edit($opt);
            }
            return redirect()->route('filament.resources.products.index')
                ->with('success', 'Quantity Has Been updated successfully');
        } catch (PrestaShopWebserviceException $ex) {
            echo 'Error: <br />' . $ex->getMessage();
        }
    }

    public static function updateAllProductQuantityOnPrestaShop()
    {
        $products = Product::all();
        $value = config('prestashop');
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
                $item = $xml->product->associations->stock_availables->stock_available;

                $xml = $webService->get(array('url' => $value['path'] . '/api/stock_availables?schema=blank'));
                $resources = $xml->children()->children();
                $resources->id = $item->id;
                $resources->id_product = $resource->id;
                $resources->quantity = $product->quantity;
                $resources->id_shop = 1;
                $resources->out_of_stock = 1;
                $resources->depends_on_stock = 0;
                $resources->id_product_attribute = $item->id_product_attribute;

                $opt = array('resource' => 'stock_availables');
                $opt['putXml'] = $xml->asXML();
                $opt['id'] = $item->id;
                $webService->edit($opt);
            }
            return redirect()->route('filament.resources.products.index')
                ->with('success', 'Quantity Has Been updated successfully');
        } catch (PrestaShopWebserviceException $ex) {
            echo 'Error: <br />' . $ex->getMessage();
        }
    }
}
