<?php

/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/2
 * Time: 下午4:18
 */
class AdapterE extends Adaptee implements Target
{
    public function method2()
    {
        echo 'method2';
    }
}