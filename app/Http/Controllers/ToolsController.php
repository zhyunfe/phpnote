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
    public function redis()
    {
        $redis = new \Redis();
        $redis->connect('127.0.0.1',6379);
        var_dump($redis);
    }
    public function haxi()
    {
        $name = 'zhyunfe';
        echo hash('sha256',$name);
    }
}