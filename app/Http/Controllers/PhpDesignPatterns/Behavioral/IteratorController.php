<?php

/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/4
 * Time: 下午3:46
 * 迭代器设计模式
 * 目的：让对象变得可迭代并表现的像对象集合
 * 例子：文件中是所有行上逐行处理文件
 */

class CD
{
    /**
     * @var string
     * 乐队
     */
    public $band = '';

    /**
     * @var string
     * 标题
     */
    public $title = '';

    /**
     * @var array
     * 曲目列表
     */
    public $trackList = array();

    public function __construct($band, $title)
    {
        $this->band = $band;
        $this->title = $title;
    }

    /**
     * @param $track
     * 添加歌曲到曲目列表
     */
    public function addTrack($track)
    {
        $this->trackList[] = $track;
    }
}
class CDSearchByBandIterator implements Iterator
{
    private $_CDs = array();
    private $_valid = FALSE;

    public function __construct($bandName)
    {
        $db = mysqli_connect('localhost', 'user', 'pwd', 'test');
        $sql = "select CD.id,CD.band,CD.title,tracks.tracknum, tracks.title as tracktitle from CD left join tracks on CD.id=tracks.cid where band={$bandName} order by tracks.tracknum";
        $result = mysqli_query($db,$sql);

        $cdID = 0;
        $cd = null;

        while ($result = mysqli_fetch_array($result)) {
            if ($result['id'] !== $cdID) {
                if (!is_null($cd)) {
                    $this->_CDs = $cd;
                }
                $cdID = $result['id'];
                $cd = new CD($result['band'], $result['title']);
                $cd->addTrack($cd);
            }
        }
    }

    public function next()
    {
        // TODO: Implement next() method.
        $this->_valid = next($this->_CDs) === false ? false : true;
    }

    public function rewind()
    {
        // TODO: Implement rewind() method.
        $this->_valid = reset($this->_CDs) === false ?  false :true;
    }
    public function valid()
    {
        // TODO: Implement valid() method.
        return $this->_valid;
    }
    public function current()
    {
        // TODO: Implement current() method.
        return current($this->_CDs);
    }
    public function key()
    {
        return key($this->_CDs);
    }
}

$queryItem = 'Nerver Agian';

$cds = new CDSearchByBandIterator($queryItem);
foreach ($cds as $cd) {
    echo $cd->band;
    echo $cd->title;
}