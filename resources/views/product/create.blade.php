<x-app-layout>
<body>
<div class="container mt-2">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <x-slot name="header">
            <div class="pull-left mb-2">
                <h2>Add Product</h2>
            </div>
            </x-slot>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('products.index') }}"> Back</a>
            </div>
        </div>
    </div>
    @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
    @endif
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Item Code:</strong>
                    <input type="number" name="item_code" class="form-control" placeholder="Item Code">
                    @error('item_code')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Product Number:</strong>
                    <input type="number" name="product_number" class="form-control" placeholder="Product Number">
                    @error('product_number')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>product_name:</strong>
                    <input type="text" name="product_name" class="form-control" placeholder="Product Name">
                    @error('product_name')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Unit:</strong>
                    <input type="number" name="unit" class="form-control" placeholder="Unit">
                    @error('unit')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Quantity:</strong>
                    <input type="number" name="quantity" class="form-control" placeholder="Quantity">
                    @error('quantity')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Price AED:</strong>
                    <input type="number" name="price_aed" class="form-control" placeholder="Price AED">
                    @error('price_aed')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div>

            <button type="submit" class="btn btn-primary ml-3">Submit</button>
            </div>
        </div>
    </form>
</div>
</body>
</x-app-layout>
