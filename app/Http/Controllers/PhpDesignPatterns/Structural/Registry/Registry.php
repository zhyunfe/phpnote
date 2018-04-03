<?php

/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/3
 * Time: 下午3:50
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