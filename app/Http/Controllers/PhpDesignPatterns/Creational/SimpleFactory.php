<?php

/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/4
 * Time: 上午11:51
 * 简单工厂模式是一个精简版的工厂模式
 * 它与静态工厂模式最大的区别是它不是静态的，因为非静态，所以你可以拥有多个不同参数的工场，你可以为其创建子类
 */
class SimpleFactory
{
    public function createBicycle()
    {
        return new Bicycle();
    }
}
class Bicycle
{
    public function driveTo($destination)
    {

    }
}
class Test
{
    public function index()
    {
        $factory = new SimpleFactory();
        $bicycle = $factory->createBicycle();
        $bicycle->driveTo('home');
    }
}