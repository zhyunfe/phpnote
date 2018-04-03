<?php
/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/3
 * Time: 上午9:51
 */
class UsualPlayList
{
    private $_song;

    public function __construct()
    {
        $this->_song = array();
    }

    public function addSong($location, $title)
    {
        $this->_song[] = array('location' => $location, 'title' => $title);
    }

    public function getMp3()
    {
        $mp3 = "#extm3u\n\n";
        foreach ($this->_song as $song) {
            $mp3 .= '#extinf:-1' . $song['title'];
            $mp3 .= $song['location'];
        }
        return $mp3;
    }

    public function getPls()
    {
        $pls = "[playlist]\n NumberOfEntires=" . count($this->_song) . PHP_EOL;

        foreach ($this->_song as $count => $song) {
            $counter = $count + 1;
            $pls .= "File {$counter} = {$song['location']}" . PHP_EOL;
            $pls .= "Title{$counter} = {$song['title']}" . PHP_EOL;
            $pls .= "Length{$counter}";
        }
        return $pls;
    }
}
$type = '';
$usualPlayList = new Playlist();
$usualPlayList->addSong('/home/brr.mp3','Brr');
$usualPlayList->addSong('/home/goodbye.mp3','goodbye');

if ($type == 'mp3') {
    $usualPlayList->getM3U();
} else {
    $usualPlayList->getPLS();
}