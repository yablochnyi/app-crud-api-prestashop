<?php
try {
    define('DEBUG', true);
    define('PS_SHOP_PATH', 'https://rme.rywal.dev/');
    define('PS_WS_AUTH_KEY', 'V8B6U7TS71NCU18K1WLG4F4CI6A4IMHF');
    // creating webservice access
    $webService = new PrestaShopWebservice(PS_SHOP_PATH, PS_WS_AUTH_KEY, DEBUG);
    // call to retrieve customer with ID 2
    $xml = $webService->get([
        'resource' => 'products',
//        'id' => 2, // Here we use hard coded value but of course you could get this ID from a request parameter or anywhere else
    ]);
    $resources = $xml->children()->children();
    foreach ($resources as $value => $key)
    {
        $xml = $webService->get([
            'resource' => 'products',
        'id' => $key, // Here we use hard coded value but of course you could get this ID from a request parameter or anywhere else
        ]);
        print_r($xml);
//        dd($value);
//        echo '<pre>';
//        print_r($key);
    }
} catch (PrestaShopWebserviceException $ex) {
    // Shows a message related to the error
    echo 'Other error: <br />' . $ex->getMessage();
}
