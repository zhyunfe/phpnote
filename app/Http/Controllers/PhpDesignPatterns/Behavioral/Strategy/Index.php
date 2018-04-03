<?php
/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/2
 * Time: 下午4:13
 */
class Index
{
    public static function index()
    {
        //使用策略A
        $contextA = new Context(new ConcreteStrategyA());
        $contextA->contextInterface();

        //使用策略B
        $contextB = new Context(new ConcreteStrategyB());
        $contextB->contextInterface();
    }
}