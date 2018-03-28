<?php

/**
 *
 * 适配器模式
 * 主要角色:目标角色(target)、源角色(Adaptee)、适配器角色(Adapter)
 * 使用场景:1、想使用一个已存在的类，而他的接口不符合你的要求
 *         2、想创建一个可服用的类，该类可以与其他不相关的类或不可预见的类协同工作
 *         3、想使用一个已存在的子类，但是不可能对每一个都进行子类化以匹配他们的接口，对象适配器可以适配它的父类接口（仅限于对象适配器）
 * 类适配器与对象适配器：
 * 类适配器：Adapter和Adaptee是继承关系
 *          1、用一个Adapter类和Target进行匹配结果是当我们想要一个匹配一个类及所有它的子类时，Adapter将不能胜任工作
 *          2、使得Adapter可以重定义Adaptee的部分行为，因为Adapter是Adaptee的一个子集
 *          3、仅仅引入一个对象，并不需要额外的指针以间接取得adaptee
 *
 * 对象适配器：Adapter和Adaptee是委托关系
 *          1、允许一个Adapter与多个Adaptee同时工作，Adapter也可以一次给所有的Adaptee添加功能
 *          2、使用重定义Adaptee的行为比较困难
 */


/***************************************类适配器实现*****************************/
/**
 * Interface Target
 * 目标角色，定义了两个接口
 */
interface Target
{
    public function method1();
    public function method2();
}

/**
 * Class Adaptee
 * 源角色，实现了method1
 */
class Adaptee
{
    public function method1()
    {
        echo 'Adaptee Method 1';
    }
}

/**
 * Class Adapter
 * 适配器对象
 */
class Adapter extends Adaptee implements Target
{
    /**
     * 因为声明了Target，在Adaptee中没有method2，在这里要补充
     */
    public function method2()
    {
        echo 'Adapter Method 2';
    }
}

class AdapterController
{
    public function index()
    {
        $adpter = new Adapter();
        $adpter->method1();
        $adpter->method2();
    }
}

/***************************************类适配器实现*****************************/
//对象适配器使用的是委派

interface Target2
{
    public function method1();
    public function method2();
}

class Adaptee2
{
    public function method1()
    {
        echo 'Adaptee Method1';
    }
}

class Adapter2 implements Target2
{
    private $_adaptee;
    public function __construct(Adaptee2 $adaptee)
    {
        $this->_adaptee = $adaptee;
    }

    public function method1()
    {
        $this->_adaptee->method1();
    }

    public function method2()
    {
        echo 'Adapter Method2';
    }
}

class AdapterController2
{
    public function index()
    {
        $adptee = new Adaptee2();
        $adpter = new Adapter($adptee);

        $adpter->method1();
        $adpter->method2();
    }
}