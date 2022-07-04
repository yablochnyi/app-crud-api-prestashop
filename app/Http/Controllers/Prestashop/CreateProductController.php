<?php

namespace App\Http\Controllers\Prestashop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use PrestaShopWebservice;
use PrestaShopWebserviceException;

class CreateProductController extends Controller
{
    public function searchProduct(Product $product)
    {
        $value = config('prestashop');
        $webService = new PrestaShopWebservice($value['path'], $value['key'], $value['debug']);
        $xml = $webService->get([
            'resource' => 'customers',
            'filter[reference]'  => '[21]', // Here we use hard coded value but of course you could get this ID from a request parameter or anywhere else
        ]);
        dd($xml);


        try {
            $value = config('prestashop');
            $webService = new PrestaShopWebservice($value['path'], $value['key'], $value['debug']);
            $products = array('resource' => 'products');
            $list = $webService->get($products);
            $newProductId = $product->product_number;
            $flag = false;
            foreach ($list->products->product as $value) {
                if ($value->attributes()['id'] == $newProductId) {
                    $flag = true;
                    break;
                }
            }
            if ($flag !== true) {
                $this->addProductOnPrestaShop($product);
            } else {
                return redirect()->route('products.index')
                    ->with('success', 'Product already exists');
            }
        } catch (PrestaShopWebserviceException $ex) {
            echo 'Other error: <br />' . $ex->getMessage();
        }
    }

    public function addProductOnPrestaShop($product)
    {
        $value = config('prestashop');

        try {
            $webService = new PrestaShopWebservice($value['path'], $value['key'], $value['debug']);
            $products = array('resource' => 'products');
            $xml = $webService->get(array('url' => $value['path'] . '/api/products?schema=blank'));
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
        $value = config('prestashop');
        $webService = new PrestaShopWebservice($value['path'], $value['key'], $value['debug']);

        $opt['resource'] = 'products';
        $opt['id'] = $ProductId;

        $xml = $webService->get($opt);
        $item = $xml->product->associations->stock_availables->stock_available;

        $this->set_product_quantity($ProductId, $item->id, $item->id_product_attribute, $product);
    }

    public function set_product_quantity($ProductId, $StokId, $AttributeId, $product)
    {
        $value = config('prestashop');
        $webService = new PrestaShopWebservice($value['path'], $value['key'], $value['debug']);
        $xml = $webService->get(array('url' => $value['path'] . '/api/stock_availables?schema=blank'));
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

//    public function addOrUpdateAllProductOnPrestaShop()
//    {
//        $value = config('prestashop');
//        $lists = Product::all();
//
//        try {
//            $webService = new PrestaShopWebservice($value['path'], $value['key'], $value['debug']);
//            $products = array('resource' => 'products');
//            foreach ($lists as $product) {
//                $xml = $webService->get(array('url' => $value['path'] . '/api/products?schema=blank'));
//
//                $resource_product = $xml->children()->children();
//
//                unset($resource_product->position_in_category);
//
//                $resource_product->id_category_default = $product->category_id;
//                $resource_product->price = $product->price_aed;
//                $resource_product->reference = $product->unit;
//                $resource_product->active = 1;
//                $resource_product->name->language[0] = $product->product_name;
//                $resource_product->state = 1;
//
//                $products['postXml'] = $xml->asXML();
//
//                $xml = $webService->add($products);
//                $ProductId = $xml->product->id;
//
//                $this->getIdStockAvailableAndSet($ProductId, $product);
//            }
//            return redirect()->route('products.index')
//                ->with('success', 'Products Has Been created successfully');
//
//        } catch (PrestaShopWebserviceException $ex) {
//            echo 'Error: <br />' . $ex->getMessage();
//        }
//    }
}
