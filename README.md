

## About 

- Access after authorization
- Output from the product database in the form of a table
- Admin panel
    - CRUD for products on RME
    - Export/Import
    - Add one product to prestashop
    - Add all new products to prestashop
    - Update price one product to prestashop
    - Update all prices products to prestashop
    - Update quantity one product to prestashop
    - Update quantity all products to prestashop
    - Get products from prestashop
    - Get category from prestashop


## Technological stack

- Laravel 9
- MySQL database
- API PrestaShop (WebService)
- Admin Panel (Filanent)

## Instalation 

- Clone repo.
- Handle .ENV file
- Generate key: php artisan key:generate
- composer install
- Add key to env PS_WS_AUTH_KEY
- php artisan db:seed
   
    

For dev purpose: php artisan serve.

## Commands
- php artisan update:price (Update prices all products)
- php artisan update:quantity (Update quantity all products)
 
