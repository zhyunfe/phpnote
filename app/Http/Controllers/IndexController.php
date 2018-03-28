<?php
/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/3/20
 * Time: 下午7:26
 */
namespace App\Http\Controllers;
use  App\Http\Controllers\BlockChain\DappController;

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
        echo phpinfo();
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
}