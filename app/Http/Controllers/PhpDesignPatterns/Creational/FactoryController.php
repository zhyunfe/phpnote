<?php

/**
 * 工厂模式
 * 目的：定义一个用于创建对象的接口，让子类决定实例化哪一个类
 *
 * 主要角色：
 * 抽象产品角色：具体产品对象共有的父类或者接口
 * 具体产品角色：实现抽象产品角色所定义的接口，并且工厂方法模式所创建的每一个对象都是某具体产品对象的实例
 *
 * 抽象工厂角色：模式中任何创建对象的工厂类都要实现这个接口，它声明了工厂方法，该方法返回一个Producut类型的对象
 * 具体工厂角色：实现抽象工厂接口，具体工厂角色与应用逻辑相关，由应用程序直接调用以创建产品对象
 *
 * 优点：
 * 可以允许系统在不修改工厂角色的情况下引进新产品
 *
 * 缺点：
 * 客户可能仅仅为了创建一个特定的ConcreteProduct对象就不得不创建一个Creator子类
 *
 * 适用场景
 * 1、当一个类不知道它所必须创建的对象的类的时候
 * 2、当一个类希望由它的子类来指定它所创建的对象的时候
 * 3、当类将创建对象的职责委托给多个帮助子类的某一个，并且你希望将哪一个帮组子类是代理者这一信息局部化的时候
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/3/30
 * Time: 下午3:06
 */
//抽象工厂
interface Creator
{
    public function factoryMethod();
}
//具体工场
class ConcreteCreatorA implements Creator
{
    public function factoryMethod()
    {
        return new ConcreteProductA();
    }
}

class ConcreteCreatorB implements Creator
{
    public function factoryMethod()
    {
        return new ConcreteProductB();
    }
}

//抽象产品
interface Product
{
    public function operation();
}
//具体产品
class ConcreteProductA implements Product
{
    public function operation()
    {
        echo 'ConcretePoductA';
    }
}
class ConcreteProductB implements Product
{
    public function operation()
    {
        echo 'ConcreteProductB';
    }
}

class Client
{
    public static function main()
    {
        $creatorA = new ConcreteCreatorA();
        $productA = $creatorA->factoryMethod();
        $productA->operation();

        $creatorB = new ConcreteCreatorB();
        $productB = $creatorB->factoryMethod();
        $productB->operation();
    }
}
Client::main();