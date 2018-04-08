<?php

/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/8
 * Time: 下午4:32
 */
class Client extends Colleague
{
    public function request()
    {
        $this->mediator->makeRequest();
    }

    public function output($content)
    {
        echo $content;
    }
}