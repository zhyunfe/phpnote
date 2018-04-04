<?php

/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/4
 * Time: 下午12:14
 * 原型模式
 * 目的：相比正常创建一个对象new Foo()，首先创建一个原型然后克隆它会更节省开销
 * 示例：大数据量(通过ORM模型一次性往数据库插入1000000条数据)
 *
 * 主要角色：
 * 抽象原型角色：声明一个克隆自身的操作
 * 具体原型角色：实现一个克隆自身的操作
 *
 * 优点：
 * 1、可以在运行时刻增加和删除产品
 * 2、可以改变值以指定新对象
 * 3、可以改变结构以指定新对象
 * 4、减少子类的构造
 * 5、用类动态配置应用
 *
 * 缺点：
 * 每一个类必须配备一个克隆的方法，这个克隆方法需要对类的功能进行通盘考虑，这对全新类来说不是很难，但对已有的类进行改造时不一定是件容易的事
 *
 * 适用场景：
 * 1、当一个系统应该独立于它的产品常见、构成和表示时
 * 2、要实例化的类是在运行时刻指定时，例如动态加载
 * 3、为了避免创建一个与产品类层次平等的工厂类层次时
 * 4、当一个类的实例只能有几个不同状态组合中的一种时，建立相应数目的原型并克隆他们可能比每次用合适的状态手工实例化该类更方便一些
 */

//抽象原型角色
interface Prototype
{
    public function copy();
}

//具体原型角色
class ConcretePrototype implements Prototype
{
    private $_name;

    public function __construct($name)
    {
        $this->_name = $name;
    }


    public function setName($name)
    {
        $this->_name = $name;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function copy()
    {
        // TODO: Implement copy() method.
        return clone $this;
    }
}
class Demo {
    public $array;
}

class Client
{
    public static function main()
    {
        $demo = new Demo();
        $demo->array = array(1,2);
        $object1 = new ConcretePrototype($demo);
        $object2 = $object1->copy();
    }
}