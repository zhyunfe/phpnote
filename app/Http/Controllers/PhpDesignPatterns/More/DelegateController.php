<?php

/**
 * 委托设计模式
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/3/28
 * Time: 下午3:20
 * Web站点具有创建MP3文件播放列表的功能，MP3文件可以来自访问者的硬盘驱动器，也可以来自Internet，访问者可以选在MP3或者PLS格式下载播放列表
 */

class Playlist
{
    private $_songs;

    public function __construct()
    {
        $this->_songs = array();
    }

    public function addSong($location, $title)
    {
        $song = array('location' => $location, 'title' => $title);
        $this->_songs = $song;
    }

    public function getM3U()
    {
        $m3u = "#extm3u\n\n";
        foreach ($this->_songs as $song) {
            $m3u .= "#EXTINF:-1,{$song['title']}\n";
            $m3u .= "{$song['location']}\n";
        }
        return $m3u;
    }

    public function getPLS()
    {
        $pls = "[playlist]\n NumberOfEntires=" . count($this->_songs) . PHP_EOL;

        foreach ($this->_songs as $count => $song) {
            $counter = $count + 1;
            $pls .= "File {$counter} = {$song['location']}" . PHP_EOL;
            $pls .= "Title{$counter} = {$song['title']}" . PHP_EOL;
            $pls .= "Length{$counter}";
        }
        return $pls;
    }
}
$enyernalRetrivedType = '';
$playlist = new Playlist();
$playlist->addSong('/home/brr.mp3', 'Brr');
$playlist->addSong('/home/goodbye.mp3', 'goodbye');

if ($enyernalRetrivedType == 'mp3') {
    $playlistContent = $playlist->getM3U();
} else {
    $playlistContent = $playlist->getPLS();
}

/**
 * 使用委托模式
 */

class newPlaylist
{
    private $_songs;
    private $_typeObject;
    public function __construct($type)
    {
        $this->_songs = array();
        //根据传入的类型实例化自己的委托对象
        $object = "{$type}PlaylistDelegate";
        $this->_typeObject = new $object;
    }

    public function addSong($location, $title)
    {
        $song = array('location' => $location, 'title' => $title);
        $this->_songs = $song;
    }
    //寻找传入类型指定的对象方法
    public function getPlayList()
    {
        $playlist = $this->_typeObject->getPlayList($this->_songs);
        return $playlist;
    }
}

//作为Playlist对象原有的上述两个方法被移动至这些对象自己的委托对象

class m3uPlaylistDelegate
{
    public function getPlayList($songs)
    {
        $m3u = "#extm3u\n\n";
        foreach ($songs as $song) {
            $m3u .= "#EXTINF:-1,{$song['title']}\n";
            $m3u .= "{$song['location']}\n";
        }
        return $m3u;
    }
}

class plsPlaylistDelegate
{
    public function getPlayList($songs)
    {
        $pls = "[playlist]\n NumberOfEntires=" . count($songs) . PHP_EOL;

        foreach ($songs as $count => $song) {
            $counter = $count + 1;
            $pls .= "File {$counter} = {$song['location']}" . PHP_EOL;
            $pls .= "Title{$counter} = {$song['title']}" . PHP_EOL;
            $pls .= "Length{$counter}";
        }
        return $pls;
    }
}
//使用

$externalRetrievedType = 'pls';
$playlist = new newPlaylist($externalRetrievedType);
$playlistContent = $playlist->getPlayList();