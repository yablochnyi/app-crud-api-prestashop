<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Products implements ToModel, WithHeadingRow
{

    private $categories;

    public function __construct()
    {
        $this->categories = Category::select('id', 'title')->get();
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $category = $this->categories->where('title', $row['category'])->first();

        return new Product([
            'item_code' => $row['item_code'],
            'product_number' => $row['product_number'],
            'product_name' => $row['product_name'],
            'category_id' => $category->id,
            'unit' => $row['unit'],
            'quantity' => $row['quantity'],
            'price_aed' => $row['price_aed'],
        ]);
    }
}
