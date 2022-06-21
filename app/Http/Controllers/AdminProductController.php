<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AdminProductController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $data = Product::all();
            return DataTables::of($data)
                ->addColumn('action', 'admin.product.action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->addColumn('category', function (Product $product) {
                    return $product->category->title;
                })
                ->make(true);
        }
        return view('admin.product.index');
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.product.create', compact('categories'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        Product::firstOrCreate($data);
        return redirect()->route('products.index')
            ->with('success', 'Product has been created successfully.');
    }

    public function show(Product $product)
    {
        return view('admin.product.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.product.edit', compact('product', 'categories'));
    }

    public function update(UpdateRequest $request, Product $product)
    {
        $data = $request->validated();
        $product->update($data);
        return redirect()->route('products.index')
            ->with('success', 'Product Has Been updated successfully');
    }

    public function destroy(Request $request)
    {
        $com = Product::where('id', $request->id)->delete();
        return Response()->json($com);
    }
}
