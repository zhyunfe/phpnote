<?php

/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/3
 * Time: 上午9:45
 */
class SingletonM
{
    private static $instance;
    public function __construct()
    {

    }
    //懒汉式单例，PHP不支持饿汉式单例
    public static function getInstance()
    {
        if (null == self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __clone()
    {
        echo "it's not allowed by clone";
    }
    public function test()
    {
        echo '测试，测试一下';
    }
}