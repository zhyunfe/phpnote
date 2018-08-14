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
use PhpOffice\PhpSpreadsheet\Writer\Xls\BIFFwriter;

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
        $filename = $this->storage . 'demo1.xls';
        //全部加载文件
        $obj = IOFactory::load($filename);
        //使用迭代器的方式读取数据
        foreach ($obj->getWorksheetIterator() as $sheet) {
            //循环取sheet
            foreach ($sheet->getRowIterator() as $row) {
                //设置从第2行读取
                if ($row->getRowIndex() < 2) {
                    continue;
                }
                foreach ($row->getCellIterator() as $cell) {
                    $data = $cell->getValue() . PHP_EOL;
                    echo $data;
                }
                echo "<br/>";
            }
            echo "<br/>";
        }
        //全量读取小量数据可以使用该方法
//        $sheetCount = $obj->getSheetCount();
//        for($i = 0; $i < $sheetCount; $i++) {
//           $data = $obj->getSheet($i)->toArray();
//            var_dump($data);
//        }

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