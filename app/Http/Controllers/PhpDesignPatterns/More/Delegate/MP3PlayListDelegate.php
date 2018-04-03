<?php

/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/3
 * Time: 上午9:58
 */
class Mp3PlayListDelegate
{
    public function getPlayList($songs)
    {
        $mp3 = "#extm3u\n\n";
        foreach ($songs as $song) {
            $mp3 .= '#extinf:-1' . $song['title'];
            $mp3 .= $song['location'];
        }
        return $mp3;
    }
}