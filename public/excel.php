<?php
ini_set('max_execution_time', 999999);
ini_set('memory_limit', '1G');
include '../vendor/phpoffice/phpspreadsheet/src/Bootstrap.php';
class Qyj
{
    public function index($reader, $qyjArr, $file, $store)
    {
        $office = $reader->load($file);
        $currentSheet = $office->getSheet(0);
        $allRow = $currentSheet->getHighestRow();
        $tmp = array();
        for($rowIndex=1;$rowIndex<=$allRow;$rowIndex++){
            $A = '';
            for ($colIndex='A';$colIndex<'C';$colIndex++) {
                $addr = $colIndex.$rowIndex;
                $cell = $currentSheet->getCell($addr)->getValue();
                if ($colIndex == 'A') {
                    $A = trim($cell);
                } else {
                    $tmp[$A] =trim($cell);
                }
            }
        };
        $qyjKey = array_keys($qyjArr);
        foreach ($tmp as $key=>$value) {
            if (in_array($key, $qyjKey)) {
                if (intval($value) !== intval($qyjArr[$key])) {
                    $str = $value . '=>' . $qyjArr[$key] . PHP_EOL;
                    file_put_contents($store, $str, FILE_APPEND);
                }
            } else {
                $str = $key  . '=>' . $value .'|notfound'. PHP_EOL ;
                file_put_contents($store, $str, FILE_APPEND);
            }
        }
        unset($qyjArr);
        unset($tmp);
    }
    public function run()
    {
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xls');
        $file = array('1+.xls','10+.xls','20+.xls');
        $diff = array('diff1.txt', 'diff2.txt', 'diff3.txt');
        $qyjArr = array();
        $office = $reader->load('cporder1.xls');
        $currentSheet = $office->getSheet(0);
        $allRow = $currentSheet->getHighestRow();
        for($rowIndex=1;$rowIndex<=$allRow;$rowIndex++){
            $A = '';
            for ($colIndex='A';$colIndex<'C';$colIndex++) {
                $addr = $colIndex.$rowIndex;
                $cell = $currentSheet->getCell($addr)->getValue();
                if ($colIndex == 'A') {
                    $A = trim($cell);
                } else {
                    $qyjArr[$A] = trim($cell);
                }
            }
        };
        $this->index($reader, $qyjArr, 'cporder.xls', 'diff4.txt');
    }
}
$excel = new Qyj();
$excel->run();