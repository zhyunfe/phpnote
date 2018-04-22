<?php
/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/3/20
 * Time: 下午7:26
 */
namespace App\Http\Controllers;
use  App\Http\Controllers\BlockChain\DappController;
use App\Http\Controllers\Language\FileSystemController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class IndexController extends Controller
{
    public $blockChain = array();
    public function index()
    {
        $geniseBlock = DappController::createGensisBlock();
        $this->blockChain[] = $geniseBlock;
        $block = $geniseBlock;
        for($i = 0; $i < 20; $i++) {
            $next = DappController::nextBlock($block);
            $block = $next;
            $this->blockChain[] = $block;
        }
        var_dump($this->blockChain);
    }
    public function getPhpinfo()
    {
        $redis = new \Redis();
        var_dump($redis);
        $config = array(
            1 => array( //appstore
                'CNT' => 17,
                'AMOUNT' => 40000
            ),
            2 => array( //google play
                'CNT' => 16,
                'AMOUNT' => 40000
            ),
            11 => array( //cosmopay
                'CNT' => 8,
                'AMOUNT' => 12000
            ),
            12 => array( //fb
                'CNT' => 5,
                'AMOUNT' => 1500
            ),
        );
        $queryStr = '2|8|20000';
        $queryArr = explode('|', $queryStr);
        var_dump($queryArr);
        if (strlen($queryStr) && count($queryArr) % 3 === 0) {
            for($i = 0; $i < count($queryArr); $i = $i + 3) {
                echo $i;
                $config[$queryArr[$i]]['CNT'] = $queryArr[$i+1];
                $config[$queryArr[$i]]['AMOUNT'] = $queryArr[$i+2];
            }
        }
        var_dump($config);
    }
    public function test()
    {
        echo date('Y-m-d H:i:s',strtotime('-90 day'));
//        $url = 'abpassportapi.gm99api.com';
//        $socket = fsockopen($url,443,$errno, $errstr, 10);
//        dd($socket);
//        fwrite($socket,'POST / HTTP/1.1  Host: abpassportapi.gm99api.com  Content-Type: text/plain  Content-Length: 102  Accept-Encoding: compress, gzip    a:3:{s:5:"class";s:8:"UsersApi";s:6:"method";s:7:"getUser";s:9:"arguments";a:1:{i:0;s:9:"gm99test8";}}');
    }
    public function yar()
    {
        $service = new \Yar_Server(new YarController());
        $service->handle();
    }
    public function upload(FileSystemController $file)
    {
        $file->upload();
    }

    public function excel()
    {
        $excel = new Spreadsheet();

    }
}