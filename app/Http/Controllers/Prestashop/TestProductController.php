<?php

namespace App\Http\Controllers\Prestashop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use PrestaShopWebservice;
use PrestaShopWebserviceException;


class TestProductController extends Controller
{

    public function getProducts()
    {
        define('DEBUG', true);											// Debug mode
        define('PS_SHOP_PATH', 'http://www.myshop.com/');							// Root path of your PrestaShop store
        define('PS_WS_AUTH_KEY', 'ZQ88PRJX5VWQHCWE4EE7SQ7HPNX00RAJ');	// Auth key (Get it in your Back Office)

        $webService = new PrestaShopWebservice(PS_SHOP_PATH, PS_WS_AUTH_KEY, DEBUG);
        // Here we set the option array for the Webservice : we want customers resources
        $opt['resource'] = 'products';
        // We set an id if we want to retrieve infos from a customer
        if (isset($_GET['id']))
            $opt['id'] = (int)$_GET['id']; // cast string => int for security measures

        // Call
        $xml = $webService->get($opt);

        // Here we get the elements from children of customer markup which is children of prestashop root markup
        $resources = $xml->children()->children();
        if (!isset($_GET['id']))
        {
            echo '<tr><th>Id</th><th>More</th></tr>';
            foreach ($resources as $resource)
            {
                // Iterates on the found IDs
                echo '<tr><td>'.$resource->attributes().'</td><td>'.
                    '<a href="?id='.$resource->attributes().'">Retrieve</a>'.
                    '</td></tr>';
            }
        }
        else
        {
            foreach ($resources as $key => $resource)
            {
                // Iterates on customer's properties
                echo '<tr>';
                echo '<th>'.$key.'</th><td>'.$resource.'</td>';
                echo '</tr>';
            }
        }
    }

    public function updateProductOnPrestaShop()
    {
//        define('PS_SHOP_PATH', 'https://rme.rywal.dev/');
//        define('PS_WS_AUTH_KEY', 'V8B6U7TS71NCU18K1WLG4F4CI6A4IMHF');

    }


    function set_product_quantity($ProductId, $StokId, $AttributeId)
    {
        $webService = new PrestaShopWebservice(PS_SHOP_PATH, PS_WS_AUTH_KEY, true);
        $xml = $webService->get(array('url' => PS_SHOP_PATH . '/api/stock_availables?schema=blank'));
        $resources = $xml->children()->children();
        $resources->id = $StokId;
        $resources->id_product = $ProductId;
        $resources->quantity = 1;
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
            echo "<b>Error al setear la cantidad  ->Error : </b>" . $ex->getMessage() . '<br>';
        }
    }

    function getIdStockAvailableAndSet($ProductId)
    {
        define('PS_SHOP_PATH', 'https://rme.rywal.dev/');
        define('PS_WS_AUTH_KEY', 'V8B6U7TS71NCU18K1WLG4F4CI6A4IMHF');
        $webService = new PrestaShopWebservice(PS_SHOP_PATH, PS_WS_AUTH_KEY, true);

        $opt['resource'] = 'products';

        $opt['id'] = $ProductId;

        $xml = $webService->get($opt);

        $qwe = $xml->product->associations->stock_availables->stock_available;

        $this->set_product_quantity($ProductId, $qwe->id, $qwe->id_product_attribute);


//        foreach ($xml->product->associations->stock_availables->stock_available as $item) {
//
//            echo "ID: ".$item->id."<br>";
//            echo "Id Attribute: ".$item->id_product_attribute."<br>";
//            $this->set_product_quantity($ProductId, $item->id, $item->id_product_attribute);
//            set_product_quantity($ProductId, $item->id, $item->id_product_attribute);
//        }
    }
}

