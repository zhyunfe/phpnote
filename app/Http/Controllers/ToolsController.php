<?php
namespace App\Http\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use App\Http\Controllers\Controller;

class ToolsController extends Controller
{
    public function excelExample()
    {
        $excel = new Spreadsheet();
        var_dump($excel);
    }

}