@extends('admin.product.layouts')
@section('admin.content')
    <body>
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <x-slot name="header">
                    <div class="pull-left">
                        <h2> DataTables Products</h2>
                    </div>
                </x-slot>
            </div>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        <div class="card-body">
            <table class="dataTable table-bordered ml-4" id="datatable-crud" width="1200" >
                <thead>
                <tr>
                    <th>Action App-CRUD-RME</th>
                    <th>Item code</th>
                    <th>Product number</th>
                    <th>Product name</th>
                    <th>Category</th>
                    <th>Unit</th>
                    <th>Quantity</th>
                    <th>Price AED</th>
                    <th width="200px">Action PrestaShop</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    </body>
@endsection

