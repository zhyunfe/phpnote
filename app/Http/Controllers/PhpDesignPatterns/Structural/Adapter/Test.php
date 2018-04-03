<?php
/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/2
 * Time: 下午4:19
 */
class Index
{
    //类适配
    public function index()
    {
        $adpter = new AdapterE();
        $adpter->method1();
        $adpter->method2();
    }
    //对象适配器
    public function index2()
    {
        $adpter = new Adapter2(new Adaptee());
        $adpter->method1();
        $adpter->method2();
    }
}