<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;

class Products implements ToCollection, WithHeadingRow
{
    private $categories;

    public function __construct()
    {
        $this->categories = Category::select('id', 'title')->get();
    }

    public function collection(Collection $rows)
    {
        Validator::make($rows->toArray(), [
            '*.item_code' => 'required|integer',
//            '*.product_number' => 'required|nullable',
            '*.product_name' => 'required|string',
            '*.unit' => 'required',
            '*.quantity' => 'required|integer',
            '*.price_aed' => 'required',
            '*.category' => 'required',
            '*.description' => 'nullable',
            '*.short_description' => 'nullable',
        ])->validate();

        foreach ($rows as $row) {
            $category = $this->categories->where('title', $row['category'])->first();

            Product::updateOrCreate([
                'product_number' => $row['product_number']
            ], [
                'item_code' => $row['item_code'],
                'product_number' => $row['product_number'],
                'product_name' => $row['product_name'],
                'category_id' => $category->id,
                'unit' => $row['unit'],
                'quantity' => $row['quantity'],
                'price_aed' => $row['price_aed'],
                'description' => $row['description'],
                'short_description' => $row['short_description'],
            ]);
        }
    }
}
