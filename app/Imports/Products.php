<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Products implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            'item_code' => $row['item_code'],
            'product_number' => $row['product_number'],
            'product_name' => $row['product_name'],
            'unit' => $row['unit'],
            'quantity' => $row['quantity'],
            'price_aed' => $row['price_aed'],
        ]);
    }
}
