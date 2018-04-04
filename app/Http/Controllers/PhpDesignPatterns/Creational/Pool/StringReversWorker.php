<?php
/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/4
 * Time: 下午2:55
 */
class StringReverseWorker
{
    private $createAt;

    public function __construct()
    {
        $this->createAt = new DateTime();
    }

    public function run($text)
    {
        return strrev($text);
    }
}
