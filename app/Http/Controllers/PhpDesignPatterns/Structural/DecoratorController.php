<?php

/**
 * 装饰器模式
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/3/28
 * Time: 上午9:18
 */
//新建一个CD类，用来添加和输出音轨
class CD
{
    public $tractList;
    public function __construct()
    {
        $this->tractList = array();
    }

    public function addTrack($track)
    {
        $this->tractList[] = $track;
    }
    public function getTrackList()
    {
        $outPut = '';

        foreach ($this->tractList as $num=>$track) {
            $outPut .= ($num + 1) ."){$track}";
        }
        return $outPut;
    }
}

$tracksFromExternalSource = array('What It Means', 'Brr', 'GoodBye');
$cd = new CD();
foreach ($tracksFromExternalSource as $track)
{
    $cd->addTrack($track);
}
print $cd->getTrackList();

//需要将上面的输出大写，创建一个修饰器

class CDTrackListDecoratorCaps
{
    private $_cd;
    public function __construct(CD $cd)
    {
        $this->_cd = $cd;
    }
    //新增方法，大写输出
    public function makeCaps()
    {
        foreach ($this->_cd->tractList as $key=>$track) {
            $this->_cd->tractList[$key] = strtoupper($track);
        }
    }
}

$myCd = new CD();

foreach ($tracksFromExternalSource as $track)
{
    $myCd->addTrack($track);
}
$myCdDeractorCaps = new CDTrackListDecoratorCaps($myCd);
$myCdDeractorCaps->makeCaps();

print $myCd->getTrackList();