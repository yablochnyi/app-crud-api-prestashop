<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AdminProductController extends Controller
{

    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(Product::select('*'))
                ->addColumn('action', 'admin.product.action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.product.index');
    }

    public function create()
    {
        return view('admin.product.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_code' => 'required',
            'product_number' => 'required',
            'product_name' => 'required',
            'unit' => 'required',
            'quantity' => 'required',
            'price_aed' => 'required',
        ]);
        $product = new Product();
        $product->item_code = $request->item_code;
        $product->product_number = $request->product_number;
        $product->product_name = $request->product_name;
        $product->unit = $request->unit;
        $product->quantity = $request->quantity;
        $product->price_aed = $request->price_aed;
        $product->save();
        return redirect()->route('products.index')
            ->with('success', 'Product has been created successfully.');
    }

    public function show(Product $product)
    {
        return view('admin.product.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('admin.product.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'item_code' => 'required',
            'product_number' => 'required',
            'product_name' => 'required',
            'unit' => 'required',
            'quantity' => 'required',
            'price_aed' => 'required',
        ]);
        $product = Product::find($id);
        $product->item_code = $request->item_code;
        $product->product_number = $request->product_number;
        $product->product_name = $request->product_name;
        $product->unit = $request->unit;
        $product->quantity = $request->quantity;
        $product->price_aed = $request->price_aed;
        $product->save();
        return redirect()->route('products.index')
            ->with('success', 'Product Has Been updated successfully');
    }

    public function destroy(Request $request)
    {
        $com = Product::where('id', $request->id)->delete();
        return Response()->json($com);
    }

}
