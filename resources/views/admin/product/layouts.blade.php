<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
</head>
<body class="font-sans antialiased">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Crud RME | Prestashop</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('adminlte/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}">
</body>
</head>
    <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item ">
                    <div class="nav-item d-none d-sm-inline-block">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="float-right flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                    <div>{{ Auth::user()->name }}</div>

                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                  clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-dropdown-link :href="route('logout')"
                                                     onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </li>
            </ul>
            <!-- Right navbar links -->
        </nav>
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->

            <a href="{{route('admin.product.index')}}" class="brand-link">
                <x-application-logo class="brand-image img-circle elevation-3" style="opacity: .8"/>
            </a>
            <!-- Sidebar -->
            <div class="sidebar">

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                             with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="{{ route('admin.product.create') }}" class="nav-link">

                                Create Product</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('export')}}" class="nav-link">
                                <i class="nav-icon fas fa-file-excel"></i>
                                <p>
                                    Export
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" data-toggle="modal" data-target="#exampleModal" class="nav-link">
                                <i class="nav-icon fas fa-file-excel"></i>
                                <p>
                                    import
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
        <!-- Content Wrapper. Contains page content -->
    @yield('admin.content')
    <!-- /.row (main row) -->
        <!-- /.container-fluid -->
        <!-- /.content -->
        <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2022-{{now()->year}} <a href="/">CRUD App - RME</a>.</strong>
        All rights reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    </div>
    <!-- /.control-sidebar -->
    <!-- ./wrapper -->
    <!-- jQuery -->
    <script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{asset('adminlte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <script src="{{asset('adminlte/plugins/datatables/jquery.dataTables.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('adminlte/js/adminlte.js')}}"></script>


    <script type="text/javascript">
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#datatable-crud').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: "{{ url('admin/products') }}",
                columns: [
                    {data: 'actionRme', name: 'actionRme', orderable: true},
                    {data: 'item_code', name: 'item_code'},
                    {data: 'product_number', name: 'product_number'},
                    {data: 'product_name', name: 'product_name'},
                    {data: 'category', name: 'category'},
                    {data: 'description', name: 'description'},
                    {data: 'short_description', name: 'short_category'},
                    {data: 'unit', name: 'unit'},
                    {data: 'quantity', name: 'quantity'},
                    {data: 'price_aed', name: 'price_aed'},
                    {data: 'actionPresta', name: 'actionPresta', orderable: false},
                ],

                order: [[0, 'desc']]
            });
            $('body').on('click', '.delete', function () {
                var id = $(this).data('id');
                $.ajax({
                    type: "POST",
                    url: "{{ url('admin/delete-product') }}",
                    data: {id: id},
                    dataType: 'json',
                    success: function (res) {
                        var oTable = $('#datatable-crud').dataTable();
                        oTable.fnDraw(false);
                    }
                });
            });
        });
    </script>
    </body>
</html>
