

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


## Technological stack

- Laravel 9
- Yajra DataTables
- MySQL database
- API PrestaShop (WebService)

## Instalation 

1. Clone repo.
2. Handle .ENV file
3. Generate key: php artisan key:generate
4. composer install
5. Add key to env PS_WS_AUTH_KEY

For dev purpose: php artisan serve.

## Commands
- php artisan update:price (Update prices all products)
- php artisan update:quantity (Update quantity all products)
 
