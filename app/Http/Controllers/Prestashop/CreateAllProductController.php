<?php

namespace App\Http\Controllers\Prestashop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use PrestaShopWebservice;
use PrestaShopWebserviceException;

class CreateAllProductController extends Controller
{
    public function searchProduct(Product $product)
    {
        $value = config('prestashop');

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

    public function addProductOnPrestaShop()
    {
        $value = config('prestashop');
        $lists = Product::all();

        try {
            $webService = new PrestaShopWebservice($value['path'], $value['key'], $value['debug']);
            $products = array('resource' => 'products');
            foreach ($lists as $product) {
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
            }
            return redirect()->route('products.index')
                ->with('success', 'Products Has Been created successfully');

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

    public function addOrUpdateAllProductOnPrestaShop()
    {
        $value = config('prestashop');
        $products = Product::all();

        try {
            $webService = new PrestaShopWebservice($value['path'], $value['key'], $value['debug']);
            $opt = array('resource' => 'products');
            $xml = $webService->get(array('url' => $value['path'] . '/api/products?schema=blank'));
            $resource_product = $xml->children()->children();

            unset($resource_product->position_in_category);
            unset($resource_product->manufacturer_name);
            unset($resource_product->quantity);
            unset($resource_product->associations);
            unset($resource_product->id_shop_default);
            unset($resource_product->id_default_image);
            unset($resource_product->id_default_combination);
            unset($resource_product->type);
            unset($resource_product->pack_stock_type);
            unset($resource_product->date_add);
            unset($resource_product->date_upd);

            foreach ($products as $product) {
                $resource_product->id_category_default = $product->category_id;
                $resource_product->price = $product->price_aed;
                $resource_product->reference = $product->unit;
                $resource_product->active = 1;
                $resource_product->name->language[0] = $product->product_name;
                $resource_product->state = 1;

                $opt['postXml'] = $xml->asXML();

                $xml = $webService->add($opt);
                $ProductId = $xml->product->id;

                $this->updateall($ProductId, $product);

            }

        } catch (PrestaShopWebserviceException $ex) {
            echo 'Error: <br />' . $ex->getMessage();
        }
//        return redirect()->route('products.index')
//            ->with('success', 'Product Has Been created successfully');
    }
    public function updateall($ProductId, $product)
    {
        $value = config('prestashop');
        try {
            $webService = new PrestaShopWebservice($value['path'], $value['key'], $value['debug']);

                $opt['resource'] = 'products';
                $opt['id'] = $ProductId;

                $xml = $webService->get($opt);
                $item = $xml->product->associations->stock_availables->stock_available;

                $xml = $webService->get(array('url' => $value['path'] . '/api/stock_availables?schema=blank'));
                $resources = $xml->children()->children();
                $resources->id = $item->id;
                $resources->id_product = $product->product_number;
                $resources->quantity = $product->quantity;
                $resources->id_shop = 1;
                $resources->out_of_stock = 1;
                $resources->depends_on_stock = 0;
                $resources->id_product_attribute = $item->id_product_attribute;

                $opt = array('resource' => 'stock_availables');
                $opt['putXml'] = $xml->asXML();
                $opt['id'] = $item->id;
                $webService->edit($opt);

        } catch (PrestaShopWebserviceException $ex) {
            echo 'Error: <br />' . $ex->getMessage();
        }
    }
}
