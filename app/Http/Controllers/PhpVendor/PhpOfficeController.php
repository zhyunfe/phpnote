<?php
/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/3/29
 * Time: 下午1:12
 */

namespace App\Http\Controllers\PhpVendor;


use PhpOffice\PhpSpreadsheet\Spreadsheet;

class PhpOfficeController
{
    public $office;
    public function __construct()
    {
        $this->office = new Spreadsheet();
    }

    public function handleBigFile()
    {
        $file = $_FILES;
        var_dump($file);
    }
}