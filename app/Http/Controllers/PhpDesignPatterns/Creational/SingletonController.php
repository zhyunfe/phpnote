<?php
/**
 * 单例模式
 * 一个类只有一个实例，并且提供一个访问它的全局访问点
 *
 * 三个特点：
 * 1、一个类只有一个实例
 * 2、必须自行创建这个实例
 * 3、必须自行向整个系统提供这个实例
 *
 * 主要角色：Singleton定义一个Instance操作，允许客户访问它的唯一实例。Instance是一个类方法，负责创建它的唯一的实例
 *
 * 有点：
 * 1、对唯一实例的受控访问
 * 2、缩小命名空间，单例模式是对全局变量的一种改进，它避免了那些存储唯一实例的全局变量污染命名空间
 * 3、允许对操作和表示的精华，单例类可以有子类，而且用这个扩展类的实例来配置一个应用是很容易的。可以根据所需要的类的实例在运行时刻配置应用
 * 4、允许可变数目的实例
 * 5、比类操作更灵活
 *
 * 适用场景
 * 1、当类智能有一个实例而且客户可以从一个众所周知的访问点访问它时
 * 2、当这个唯一实例应该是通过子类化可扩展的，并且用户应该无需更改代码就能使用一个扩展的实例时
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/1
 * Time: 下午4:42
 */


class Singleton
{
    private static $_instance = null;

    private function __construct()
    {

    }

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    //防止用户克隆实例
    public function __clone()
    {
        die('clone is not allowd');
    }
    public function test()
    {
        echo '这是一个单例';
    }
}

class Client
{
    public static function main()
    {
        $instance = Singleton::getInstance();
        $instance->test();
    }
}
Client::main();