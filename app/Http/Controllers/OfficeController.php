<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Writer\Xls\BIFFwriter;
ini_set('memory_limit', '2G');
set_time_limit(0);

class OfficeController extends Controller
{
    private $storage;
    private $excel;
    private $writer;
    private $reader;
    private $mysql;
    public function __construct($type = 'Xlsx')
    {
        //设置默认存储路径
        $this->storage = storage_path('app/office/');
        //设置excel对象
        $this->excel = new Spreadsheet();
        $this->writer = IOFactory::createWriter($this->excel, $type);
        $this->reader = IOFactory::createReader($type);
    }

    public function index()
    {

    }

    public function getExcel()
    {
        $filename = $this->storage . 'qyj.xlsx';
        //全部加载文件
        $obj = IOFactory::load($filename);
        $obj2 = IOFactory::load($this->storage . 'qyj0725.xlsx');
//        //使用迭代器的方式读取数据
//        foreach ($obj->getWorksheetIterator() as $sheet) {
//            //循环取sheet
//            foreach ($sheet->getRowIterator() as $row) {
//                //设置从第2行读取
//                if ($row->getRowIndex() < 2) {
//                    continue;
//                }
//                foreach ($row->getCellIterator() as $cell) {
//                    $data = $cell->getValue() . PHP_EOL;
//                    echo $data;
//                }
//                echo "<br/>";
//            }
//            echo "<br/>";
//        }
        //全量读取小量数据可以使用该方法
        $sheetCount = $obj->getSheetCount();
        $data = array();
        for($i = 0; $i < $sheetCount; $i++) {
           $data[$i] = $obj->getSheet($i)->toArray();
        }
        $cporder = array();
        $order = array();
        foreach ($data as $key => $value) {

            foreach ($value as $v) {
                if ($key == 0) {
                    $cporder[] = trim($v[1]);
                } else {
                    $order[] = trim($v[1]);
                }
            }
        }

        $sheetCount2 = $obj2->getSheetCount();
        $data2 = array();
        for ($i = 0; $i < $sheetCount2; $i++) {
            $data2[$i] = $obj2->getSheet($i)->toArray();
        }
        $j = $data2[0];
        unset($j[0]);
        foreach ($j as $key => $value) {
            foreach ($cporder as $v) {
                if (in_array($v,$value)) {
                    unset($j[$key]);
                }
            }
            foreach ($order as $ov) {
                if (in_array($ov, $value)) {
                    unset($j[$key]);
                }
            }
        }
        $objSheet = $this->excel->getActiveSheet();
        $objSheet->setTitle('我方存在开发不存在订单');
        $objSheet->setCellValue('A1', '订单号')->setCellValue('B1', '厂商订单号')->setCellValue('C1', '支付时间')->setCellValue('D1', '台币金额');
        $n = 2;
        foreach ($j as $va) {
            $objSheet->getStyle('A'.$n)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
            $objSheet->setCellValue('A' . $n, $va[0])->setCellValue('B'.$n , (string)$va[1])->setCellValue('C'.$n, $va[2])->setCellValue('D'.$n, $va[3]);

            $n ++;
        }
        $this->writer->save($this->storage . 'diff.xlsx');
    }

    public function spreadReader()
    {
        $file = $this->storage . 'big.xlsx';
        $reader = new \SpreadsheetReader($file);
        $sheet = $reader->Sheets();
        if (!$sheet) {
            echo 0;
        }
        $reader->ChangeSheet(0);
        $i = 0;
        foreach ($reader as $row) {
            if ($i > 100) {
                break;
            }
            echo $i . PHP_EOL;$i++;
            var_dump($row);
        }
    }
    public function tail($fp, $n, $base = 5)
    {
        assert($n > 0);
        $pos = $n + 1;
        $lines = array();
        while (count($lines) <= $n)
        {
            try
            {
                fseek($fp, -$pos, SEEK_END);
            }
            catch (\Exception $e)
            {
                fseek($fp,0);
                break;
            }
            $pos *= $base;
            while (!feof($fp))
            {
                array_unshift($lines, fgets($fp));
            }
        }

        return array_slice($lines, 0, $n);
    }


    /**
     * 设置样式
     */
    public function setSheet()
    {
        //设置默认单元格的字体为水平居中和垂直居中
        $this->excel->getDefaultStyle()->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $obj = $this->excel->getActiveSheet();
        //设置默认字体和大小
        $this->excel->getDefaultStyle()->getFont()->setName('微软雅黑')->setSize(14);
        //设置大小和加粗
        $obj->getStyle("A2:Z2")->getFont()->setSize(20)->setBold(true);
        //设置颜色
        $obj->getStyle("B2:Z2")->getFont()->getColor()->setARGB(Color::COLOR_BLUE);
        //给当前sheet设置标题
        $obj->setTitle('学习设置单元格');
        //合并单元格
        $obj->setCellValue('A1', '成绩单');
        $obj->mergeCells("A1:C1");
        $obj->getStyle("A1:C1")->getFill()->setFillType(Fill::FILL_SOLID);
        $this->excel->getActiveSheet()->getStyle("B2:E2")->getFill()->getStartColor()->setRGB("e36951");
        $obj->setCellValue('A2', '学生')->setCellValue('B2', '分数')->setCellValue("C3", '时间');
        for ($i = 3; $i < 1000; $i ++)
        {

            $obj->setCellValue("A" . $i, "学生$i")->setCellValue("B$i", $i * 10)->setCellValue("C$i", Date::excelToDateTimeObject(time(),'UTC'));
        }
//        $this->writer->save($this->storage . 'set_demo.xlsx');
        $this->browserExcel($this->excel, 'Xlsx', 'set_demo');
    }
    public function create()
    {

        $objSheet = $this->excel->getActiveSheet();
        //设置标题
        $objSheet->setTitle('成绩单');
        //一行行设置数据
        $objSheet->setCellValue('A1', '姓名')->setCellValue('B1', '分数');
        $objSheet->setCellValue('A2', 'Demor')->setCellValue('B2', 100);

        //新建一个sheet
        $objSheet1 = $this->excel->createSheet(2);
        //设置标题
        $objSheet1->setTitle('账号映射表');
        //准备数据数组(大数组不建议这么操作)
        $data = array(
            array('账号', 'UID'),
            array('gm99test1', '123456'),
            array('gm99test2', '345678'),
            array('gm99test4', '09765'),
            array('gm99test3', '09876789')
        );
        $objSheet1->fromArray($data);
        //保存在指定路径
//        $this->writer->save($this->storage . 'demo1.xls');
        //输出在浏览器
//        $this->browserExcel($this->excel, 'Xls', 'demo1');
    }

    public function browserExcel($sheet, $type, $fileName)
    {
        switch ($type){
            case 'Xlsx' :
                // Redirect output to a client’s web browser (Xlsx)
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                break;
            case 'Xls':
                // Redirect output to a client’s web browser (Xls)
                header('Content-Type: application/vnd.ms-excel');
                break;
        }

        header('Content-Disposition: attachment;filename="' . $fileName . '.' . strtolower($type) .'"');

// If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0;
        $writer = IOFactory::createWriter($sheet, $type);
        $writer->save('php://output');
    }
}