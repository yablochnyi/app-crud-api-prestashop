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
        <div class="hidden sm:flex sm:items-center sm:ml-6">
            <div>
                <a class="btn btn-success flex border-none items-center gap-1 border px-2 py-1 rounded-lg text-white font-bold bg-emerald-600 hover:bg-emerald-500 transition-all"
                   href="{{ route('products.create') }}"> Create Product</a>
            </div>

            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button
                        class="btn btn-success flex border-none items-center gap-1 border px-2 py-1 rounded-lg text-white font-bold bg-emerald-600 hover:bg-emerald-500 transition-all">

                        <div> Export</div>
                        <div class="ml-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" class="fill-current"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M14.17 5L19 9.83V19H5V5H14.17ZM14.17 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19V9.83C21 9.3 20.79 8.79 20.41 8.42L15.58 3.59C15.21 3.21 14.7 3 14.17 3ZM7 15H17V17H7V15ZM7 11H17V13H7V11ZM7 7H14V9H7V7Z"/>
                            </svg>
                        </div>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('export')">
                        {{ __('Export') }}
                    </x-dropdown-link>
                </x-slot>
            </x-dropdown>

        </div>
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
        </div>
    </div>
    </body>
@endsection

