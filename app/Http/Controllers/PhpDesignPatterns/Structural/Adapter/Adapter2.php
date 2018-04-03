<?php

/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/2
 * Time: 下午4:23
 */
class Adapter2 implements Target
{
    private $_adaptee;
    public function __construct(Adaptee $adaptee)
    {
        $this->_adaptee = $adaptee;
    }
    public function method1()
    {
        echo 'method1';
    }
    public function method2()
    {
        echo 'method2';
    }
}