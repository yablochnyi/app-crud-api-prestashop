<?php

namespace App\Http\Controllers;

use App\Exports\Products;
use Maatwebsite\Excel\Facades\Excel;

class ExportImportController extends Controller
{
    public function export()
    {
        return Excel::download(new Products(), 'products.xlsx');
    }
}
