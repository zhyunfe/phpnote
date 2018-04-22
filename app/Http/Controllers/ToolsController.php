<?php
namespace App\Http\Controllers;

use Illuminate\Redis\RedisServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Http\Controllers\Controller;
ini_set('max_execution_time', 99999999);
ini_set('display_errors',E_ALL);

class ToolsController extends Controller
{
    public function excelExample()
    {
        $inputFileName = PUBLIC_URL . '/3.xls';
        $reader = IOFactory::createReader('Xls');
        $office = $reader->load($inputFileName);
        $currentSheet = $office->getSheet(0);
        $allRow = $currentSheet->getHighestRow();
        $allColumn = $currentSheet->getHighestColumn();
        $qyjarr = array();
        for($rowIndex=2;$rowIndex<=10;$rowIndex++){
            for ($colIndex='A';$colIndex<$allColumn;$colIndex++) {
                $addr = $colIndex.$rowIndex;
                $cell = $currentSheet->getCell($addr)->getValue();
                echo $cell;
//                $qyjarr[] = trim($cell);
            }
        };
//        var_dump($qyjarr);die();
        $rows1 = array();
        $reader2 = IOFactory::createReader('Xlsx');
        $office2 = $reader2->load(PUBLIC_URL . '/orderID.xlsx');
        $currentSheet2 = $office2->getSheet(0);
        $allRow = $currentSheet2->getHighestRow();

        for($rowIndex=2;$rowIndex<=$allRow;$rowIndex++){
            $temp = array();
            if ($colIndex = 'B') {
                $addr = $colIndex.$rowIndex;
                $cell = $currentSheet2->getCell($addr)->getValue();
                 $rows1[]= trim($cell);
            }
        };
    }

}