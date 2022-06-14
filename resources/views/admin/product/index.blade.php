<x-app-layout>
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
            <table class="table table-bordered" id="datatable-crud">
                <thead>
                <tr>
                    <th>item_code</th>
                    <th>product_number</th>
                    <th>product_name</th>
                    <th>unit</th>
                    <th>quantity</th>
                    <th>price_aed</th>
                    <th>Action</th>
                </tr>
                </thead>
            </table>
            <div class="mt-6">
                <a class="btn btn-success" href="{{ route('products.create') }}"> Create Product</a>
            </div>
        </div>
    </div>
    </body>
</x-app-layout>
