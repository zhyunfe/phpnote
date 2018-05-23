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
}