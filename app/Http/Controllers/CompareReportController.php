<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class CompareReportController extends Controller
{
    public $reader;
    public $writer;
    private $storage;
    public function __construct($type = 'Xlsx')
    {
        $this->reader = new Spreadsheet();
        $this->storage = storage_path('app/office/hms/');
        $this->writer = IOFactory::createWriter($this->reader, $type);
    }

    public function compare()
    {
        $hmsData = $this->hms();
        $bossData = $this->hms_boss();
        foreach ($hmsData as $currency => $value) {
            if (isset($bossData[$currency])) {
                $data = array_keys($bossData[$currency]);
                foreach ($value as $order => $val) {
                    if(in_array($order, $data)) {
                        unset($bossData[$currency][$order]);
                        unset($hmsData[$currency][$order]);
                    }
                }
            }
        }
        $objectSheet = $this->reader->getActiveSheet();
        $objectSheet->setTitle('华为多出订单');
        $i = 1;
        foreach ($hmsData as $currency => $value) {
            foreach ($value as $order => $val) {

                $objectSheet->setCellValue('A'.$i, $order)->setCellValue('B'.$i, $val['厂商订单号'])->setCellValue('C'.$i, $val['支付时间'])->setCellValue('D'.$i, $val['游戏名称'])->setCellValue('E'.$i, $val['商品名称'])-> setCellValue('F'.$i, $val['支付金额'])->setCellValue('G'.$i, $val['支付状态'])->setCellValue('H'.$i, $val['回调'])->setCellValue('I'.$i, $val['支付类型'])->setCellValue('J'.$i, $val['初始订单号'])->setCellValue('K'.$i, $val['是否退款'])->setCellValue('L'.$i, $val['退款金额'])->setCellValue('L'.$i, $val['国家'])->setCellValue('M'.$i, $currency);
                $i ++;
                file_put_contents($this->storage . '../hms_diff.txt', $order . PHP_EOL, FILE_APPEND);
            }
        }
        $this->writer->save($this->storage . '../hms_diff.xls');
    }
    public function hms()
    {
        $files = $this->getFile($this->storage);
        $data = array();
        foreach ($files as $key => $file) {
            $obj = IOFactory::load($this->storage . $file);
            $data[$key] = $obj->getActiveSheet()->toArray();
            unset($data[$key][0]);
        }
        $hms = array();
        foreach ($data as $value) {
            foreach ($value as $v) {
                $CPorderID = $v[1];
                $orderID = $v[2];
                $payTime = $v[3];
                $gameName = $v[8];
                $product = $v[9];
                $currenct = $v[11];
                $money = $v[10];
                $status = $v[14];
                $callBack = $v[15];
                $type = $v[16];
                $ooN = $v[17];
                $refuned = $v[18];
                $refundAmount = $v[19];
                $country = $v[20];

                $hms[$currenct][$orderID] = array(
                        '厂商订单号' => $CPorderID,
                        '支付时间'   => $payTime,
                        '游戏名称'   => $gameName,
                        '商品名称'   => $product,
                        '支付金额'   => $money,
                        '支付状态'   => $status,
                        '回调'       => $callBack,
                        '支付类型'   => $type,
                        '初始订单号' => $ooN,
                        '是否退款'   => $refuned,
                        '退款金额'   => $refundAmount,
                        '国家'       => $country
                );
            }
        }
       return $hms;
    }

    public function hms_boss()
    {
        $obj = IOFactory::load($this->storage . '../hms07.xlsx');
        $data = $obj->getActiveSheet()->toArray();
        unset($data[0]);
        $hms_boss = array();
        foreach ($data as $value) {
            $orderID = $value[0];
            $money = $value[5];
            $currency = $value[4];
            $game = $value[6];
            $product = $value[7];
            $hms_boss[$currency][$orderID] = array(
                '金额' => $money,
            );
        }
        return $hms_boss;
    }

    public function getFile($dir)
    {
        $files = array();
        if ($handle = opendir($dir)) {
            while (($file = readdir($handle)) !== false) {
                if ($file != ".." && $file != ".") {
                    if (is_dir($dir . "/" . "$file")) {
                        $files[$file] = $this->getFile($dir . '/' . $file);
                    } else {
                        $files[] = $file;
                    }
                }
            }
            closedir($handle);
        }
        return $files;
    }
}