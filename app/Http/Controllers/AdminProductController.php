<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use PrestaShopWebservice;
use PrestaShopWebserviceException;
use Yajra\DataTables\DataTables;

class AdminProductController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $data = Product::all();
            return DataTables::of($data)
                ->addColumn('actionRme', 'admin.product.action_rme')
                ->addColumn('actionPresta', 'admin.product.action_prestashop')
                ->rawColumns(['actionPresta', 'actionRme'])
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
        try {
            $value = config('prestashop');
            $webService = new PrestaShopWebservice($value['path'], $value['key'], $value['debug']);
            $xml = $webService->get(['resource' => 'categories']);
            $resources = $xml->categories->category;
            $opts = [];
            foreach ($resources as $resource) {
                $attributes = $resource->attributes();

                $opts[] = $webService->get(['resource' => 'categories', 'id' => $attributes]);
            }
            return view('admin.product.create', compact('opts'));
        } catch (PrestaShopWebserviceException $ex) {
            echo 'Error: <br />' . $ex->getMessage();
        }
    }

    public function store(StoreRequest $request)
    {
        try {
            $value = config('prestashop');
            $webService = new PrestaShopWebservice($value['path'], $value['key'], $value['debug']);

            $data = $request->validated();
            // get categories
            $catName = $data['category_id'];
            $xml = $webService->get(['resource' => 'categories', 'id' => $catName]);
            // create category
            Category::firstOrCreate([
                'title' => $xml->category->name->language[0],
                'prestashop_id' => $xml->category->id
            ]);
            // get id category in db
            $catId = Category::where('prestashop_id', $data['category_id'])->get('id');
            $catId = json_decode($catId, true);
            // create product
            $data['category_id'] = $catId[0]['id'];
            Product::firstOrCreate($data);

            return redirect()->route('products.index')
                ->with('success', 'Product has been created successfully.');
        } catch (PrestaShopWebserviceException $ex) {
            echo 'Error: <br />' . $ex->getMessage();
        }
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
