<?php
/**
 * 开始学习比特币挖矿
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/3/20
 * Time: 下午6:54
 */
namespace App\Http\Controllers\BlockChain;
use App\Http\Controllers\Controller;

class DappController extends Controller
{
    private static $instance = null;
    //索引
    public $index;
    //时间戳
    public $timestamp;
    //交易数据
    public $data;
    //上一个区块的哈希值
    public $previous_hash;
    //当前区块的哈希值
    public $hash;
    //区块链
    public $blockChain = array();
    //给矿工的奖励
    private $invite = 100;
    private $createdCoinNum = 0;
    //默认发行币数量
    private $demoerCoin = 10000000;
    //初始难度值为1
    private $difficulty = 1;
    //随机数
    private $nonce;
    //用来存储难度的16进制目标值,初始值x+8个0+56个F
    private $bits = 'x00000000FFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFFF';
    public function __construct($index = '', $timestamp = '', $data = '', $previous_hash = '')
    {
        $this->index = $index;
        $this->timestamp = $timestamp;
        $this->data = $data;
        $this->previous_hash = $previous_hash;
    }

    public static function createGensisBlock(){
        if(null === self::$instance) {
            //创世区块
            self::$instance = new self(0, time(), "Demoer's Block With PHP", '0');
            self::$instance->hash = self::hashBlock(self::$instance);
        }
        return self::$instance;
    }

    /**
     * 将区块进行哈希处理
     * @param $obj
     * @return string
     */
    public static function hashBlock($obj)
    {
        $str = $obj->index . $obj->timestamp . $obj->data . $obj->previous_hash;
        return bin2hex(hash('sha256', $str, true));
    }

    /**
     * 生成新的区块
     * @param $block
     * @return DappController
     */
    public static function nextBlock($block)
    {
        $index = $block->index + 1;
        $timestamp = time();
        $data = 'create new block' . $block->index;
        $previous_hash = $block->hash;
        $nextBlock = new self($index, $timestamp, $data, $previous_hash);
        $nextBlock->hash = self::hashBlock($nextBlock);
        return $nextBlock;
    }

    /**
     * 交易
     */
    public function transaction()
    {
        //获取传输过来的json数据
        $trans = file_get_contents('php://input');
        $transArr = json_decode($trans);
        $nodeTrans[] = $trans;
        echo 'New transaction' . PHP_EOL;
        echo "From:" . $transArr['from'] . PHP_EOL;
        echo "To:" . $transArr['to'] . PHP_EOL;
        echo "Amount" . $transArr['amount'] . PHP_EOL;
    }

    /**
     * 开始挖矿,默认奖励100个比特币
     */
    public function mine()
    {
        //获取当前区块链中的最新区块
        $lastBlock = $this->blockChain[count($this->blockChain) - 1];
        //获取上一个区块的pow
        $lastProof = $lastBlock['pow'];
        //进行pow
        $proof = $this->proofOfWork($lastProof);
        //准备交易信息
        $trans = array('from' => 'from', 'to' => 'mine_address', 'amount' => 1);
        $nodeTrans = json_decode($trans);
        //准备交易数据
        $newBlockData       = json_decode(array('pow' => $proof, 'transactions' => $nodeTrans));
        //准备时间戳
        $newBlockTimestamp  = time();
        //准备索引
        $newBlockIndex      = $lastBlock->index + 1;
        //准备上一个区块的哈希值
        $newBlockLastHash   = $lastBlock->hash;
        //生成新区块
        $mineBlock = new self($newBlockIndex, $newBlockTimestamp, $newBlockData, $newBlockLastHash);
        //生成当前区块的哈希
        $mineBlock->hash = self::hashBlock($mineBlock);
        //加入区块链
        $this->blockChain[] = $mineBlock;
        //判断当前的奖励
        $this->invite = $this->getInvite();
    }

    /**工作量证明
     * @param $lastProof
     * @return int
     */
    private function proofOfWork($lastProof)
    {
        $incremt = $lastProof + 1;
        while ($incremt % 9 == 0 and $incremt % $lastProof == 0) {
            $incremt += 1;
        }
        return $incremt;
    }
    public function initBits()
    {
        $bits = 0x00FFFF * 2 ^ (8 * (0x1D - 3));
        var_dump($bits);
    }

    private function getInvite()
    {
        //当前区块数量
        $blockNum = count($this->blockChain);
        if ( floor($blockNum / 10000) == $blockNum / 10000) {
            $this->invite /= 2;
        }
    }

}