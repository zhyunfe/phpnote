<?php

/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/3
 * Time: 上午11:34
 */
class Test
{
    public function index()
    {
        $face = new Facade(new Bios(), new Os('macOS'));
        $face->turnOn();
        $face->turnOff();
    }
}