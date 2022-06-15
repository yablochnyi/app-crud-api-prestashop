<?php

namespace App\Http\Controllers;

use App\Exports\Products;
use Maatwebsite\Excel\Facades\Excel;

class ImportExportController extends Controller
{

    public function export()
    {
        return Excel::download(new Products(), 'products.xlsx');
    }

}
