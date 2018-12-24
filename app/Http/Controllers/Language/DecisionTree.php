<?php
/**
 * Created by PhpStorm.
 * User: demorzhao
 * Date: 2018/10/19
 * Time: 下午2:15
 */
class DecisionTree
{
    public $originMoney = 3900;
    public $devMoney = 2000;
    public $chatMoney = 50;
    public $ori = 0.0060;
    public $assensment = 6000;
    public $storage = 100;
    public function chat($hign)
    {
        if ($hign == 1) {
            $this->originMoney = 4300;
            echo '谈判价格高，目前得到价格' . $this->originMoney . PHP_EOL;;
        }
        echo '谈判价格低，目前得到价格' . $this->originMoney . PHP_EOL;;
        return $this;
    }

    public function dev()
    {
        $this->originMoney -= $this->devMoney;
        echo '开采了，目前价格' . $this->originMoney . PHP_EOL;;
    }

    public function oil($level)
    {
      if ($level == 1) {
          $this->ori = $this->ori * 1.2;
          echo '油价涨了当前油价' . $this->ori . PHP_EOL;
          return $this;
      }
      if ($level == 2) {
          $this->ori = $this->ori * 0.9;
          return $this;
      }
      return $this;
    }

    public function storage($level)
    {
        if ($level == 1) {
            $this->storage *= 1.1;
            return $this;
        }
        if ($level == 2) {
            $this->storage *= 0.9;
            return $this;
        }
        return $this;
    }

    public function over()
    {
        $this->chat(1);
        var_dump($this->originMoney);
    }
}
$tree = new DecisionTree();
$tree->over();