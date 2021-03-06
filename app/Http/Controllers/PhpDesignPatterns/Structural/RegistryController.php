<?php

/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/3
 * Time: 上午10:30
 * 注册模式
 * 目的是能够存储在应用程序中经常使用的对象实例，通常会使用只有静态方法的抽象类来实现(或者单例模式)
 * 需要注意的是这里可能会引入全局的状态，我们需要使用依赖注入来避免它
 *
 * 例子：Zend框架Zend_Registry 实现了整个应用程序的logger对象和前端控制器等
 *      Yii框架 具有全部应用程序组件，例如CWebUser,CUrlManager
 */
abstract class Registry
{
    const LOGGER = 'logger';

    /**
     * 这里将在你的应用中引入全局状态，但是不可以被模拟测试
     * 因此被视作一种反抗模式，使用依赖注入进行替换
     * @var array
     * 定义存储值数组
     */
    private static $storedValues = [];


    /**
     * @var array
     * 定义合法键名数组
     * 可在此定义用户唯一性
     */
    private static $allowedKeys = [
        self::LOGGER,
    ];

    public static function set($key, $value)
    {
        if (!in_array($key, self::$allowedKeys)) {
            throw new Exception('Invalid key given');
        }
        self::$storedValues[$key] = $value;
    }

    public static function get($key)
    {
        if (!in_array($key, self::$allowedKeys) || !isset(self::$storedValues[$key])) {
            throw new Exception('Invalid key given');
        }
        return self::$storedValues[$key];
    }
}

class Test
{
    public function testSetAndGetLogger()
    {
        $key = Registry::LOGGER;
        $logger = new stdClass();

        Registry::set($key, $logger);
        $storedLogger = Registry::get($key);
        return $storedLogger;
    }
}