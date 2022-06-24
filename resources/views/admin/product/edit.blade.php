<x-app-layout>
    <body>
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <x-slot name="header">
                    <div class="pull-left">
                        <h2>Edit Product</h2>
                    </div>
                </x-slot>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('products.index') }}" enctype="multipart/form-data">
                        Back</a>
                </div>
            </div>
        </div>
        @if(session('status'))
            <div class="alert alert-success mb-1 mt-1">
                {{ session('status') }}
            </div>
        @endif
        <form action="{{ route('products.update',$product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Item code:</strong>
                        <input type="number" name="item_code" value="{{ $product->item_code }}" class="form-control"
                               placeholder="item_code">
                        @error('item_code')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Product number:</strong>
                        <input type="number" name="product_number" class="form-control" placeholder="product_number"
                               value="{{ $product->product_number }}">
                        @error('product_number')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Product name:</strong>
                        <input type="text" name="product_name" value="{{ $product->product_name }}" class="form-control"
                               placeholder="product_name">
                        @error('product_name')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Category</strong>
                        <select class="form-control" name="category_id">
                            <option selected>Open this select menu</option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}"
                                    {{$category->id == $product->category_id ? ' selected' : ''}}>
                                    {{$category->title}}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Unit:</strong>
                        <input type="text" name="unit" value="{{ $product->unit }}" class="form-control"
                               placeholder="unit">
                        @error('unit')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Quantity:</strong>
                        <input type="number" name="quantity" value="{{ $product->quantity }}" class="form-control"
                               placeholder="quantity">
                        @error('quantity')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Price AED:</strong>
                        <input type="number" name="price_aed" value="{{ $product->price_aed }}" class="form-control"
                               placeholder="price_aed">
                        @error('price_aed')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary ml-3">Save</button>
            </div>
        </form>
    </div>
    </body>
</x-app-layout>
