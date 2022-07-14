<?php

namespace App\Http\Controllers\Cleatdb;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DescriptionController extends Controller
{
    public function getDescription()
    {
        $productsGetDesc = DB::connection('cleat_db')
            ->table('products')
            ->get();

        foreach ($productsGetDesc as $value) {
            $description = DB::connection('cleat_db')
                ->table('product_descriptions')
                ->select('desc', 'short_desc')
                ->where('language_id', '=', '4')
                ->where('xl_id', $value->xl_id)
                ->get();

            foreach ($description as $getIndex) {
                $search = Product::where('product_number', $value->index)->update([
                    'description' => $getIndex->desc,
                    'short_description' => $getIndex->short_desc
                ]);
            }
        }
    }
}

