<?php
/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/3
 * Time: 上午10:00
 */
class Index
{
    public function index()
    {
        $playList = new Playlist('mp3');
        $playListContent = $playList->getPlayList();
    }
}