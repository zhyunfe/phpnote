<?php

/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/8
 * Time: 下午4:35
 */
class Test
{
    public function testOutputHelloWorld()
    {
        $client = new Client();
        new Mediator(new Database(), $client, new Server());
        $client->request();
    }
}