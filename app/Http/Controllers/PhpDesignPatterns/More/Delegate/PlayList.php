<?php
/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/3
 * Time: 上午9:56
 */
class PlayList
{
    private $_songs;
    private $_typeObject;
    public function __construct($type)
    {
        $this->_songs = array();
        $type = strtoupper($type);
        $this->_typeObject = "{$type}PlayListDelegate";
    }

    public function addSong($location, $title)
    {
        $this->_songs[] = array('location' => $location, 'title' => $title);
    }

    public function getPlayList()
    {
        $playList = $this->_typeObject->getPlayList($this->_songs);
        return $playList;
    }
}