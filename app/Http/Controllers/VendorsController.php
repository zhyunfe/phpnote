<?php
/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/3/23
 * Time: 上午9:18
 */
namespace App\Http\Controllers;

use Illuminate\Support\Composer;
use Monolog\Logger;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class VendosrController extends Controller
{
    public function index()
    {
        return view('');
    }

    /**
     * excel处理
     */
    public function excelVendor()
    {
        $excel = new Spreadsheet();
    }

    /**
     * monolog处理
     */
    public function monologVendor()
    {
        $log = new Logger(__CLASS__);
    }

    public function composerVendor()
    {
    }
}