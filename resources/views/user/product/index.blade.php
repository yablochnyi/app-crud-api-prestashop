@extends('user.product.layouts')
@section('user.content')
    <div class="container mt-2">
        <div class="card-body">
            <table id="app" class="table table-bordered">
                <thead>
                <tr>
                    <th>item_code</th>
                    <th>product_number</th>
                    <th>product_name</th>
                    <th>category</th>
                    <th>unit</th>
                    <th>quantity</th>
                    <th>price_aed</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{$product->item_code}}</td>
                        <td>{{$product->product_number}}</td>
                        <td>{{$product->product_name}}</td>
                        <td>{{$product->category->title}}</td>
                        <td>{{$product->unit}}</td>
                        <td>{{$product->quantity}}</td>
                        <td>{{$product->price_aed}}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>item_code</th>
                    <th>product_number</th>
                    <th>product_name</th>
                    <th>category</th>
                    <th>unit</th>
                    <th>quantity</th>
                    <th>price_aed</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
