<?php

namespace App\Http\Controllers;

use App\Exports\Products;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportImportController extends Controller
{
    public function export()
    {
        return Excel::download(new Products(), 'products.xlsx');
    }

    public function import(Request $request)
    {
        Excel::import(new \App\Imports\Products(), $request->file('import'));

        return redirect()->back()->with('success', 'Import Has Been updated successfully');
    }
}
