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
            $resource_product->reference = $product->unit;
            $resource_product->active = 1;
            $resource_product->name->language[0] = $product->product_name;
            $resource_product->state = 1;

            $products['postXml'] = $xml->asXML();

            $xml = $webService->add($products);
            $ProductId = $xml->product->id;

            $this->getIdStockAvailableAndSet($ProductId, $product);
            return redirect()->route('products.index')
                ->with('success', 'Product Has Been created successfully');

        } catch (PrestaShopWebserviceException $ex) {
            echo 'Error: <br />' . $ex->getMessage();
        }

    }























    public function getIdStockAvailableAndSet($ProductId, $product)
    {
        $webService = new PrestaShopWebservice(PS_SHOP_PATH, PS_WS_AUTH_KEY, true);

        $opt['resource'] = 'products';
        $opt['id'] = $ProductId;

        $xml = $webService->get($opt);
        $item = $xml->product->associations->stock_availables->stock_available;

        $this->set_product_quantity($ProductId, $item->id, $item->id_product_attribute, $product);
    }

    public function set_product_quantity($ProductId, $StokId, $AttributeId, $product)
    {
        $webService = new PrestaShopWebservice(PS_SHOP_PATH, PS_WS_AUTH_KEY, true);
        $xml = $webService->get(array('url' => PS_SHOP_PATH . '/api/stock_availables?schema=blank'));
        $resources = $xml->children()->children();
        $resources->id = $StokId;
        $resources->id_product = $ProductId;
        $resources->quantity = $product->quantity;
        $resources->id_shop = 1;
        $resources->out_of_stock = 1;
        $resources->depends_on_stock = 0;
        $resources->id_product_attribute = $AttributeId;
        try {
            $opt = array('resource' => 'stock_availables');
            $opt['putXml'] = $xml->asXML();
            $opt['id'] = $StokId;
            $xml = $webService->edit($opt);
        } catch (PrestaShopWebserviceException $ex) {
            echo 'Error: <br />' . $ex->getMessage();
        }
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
