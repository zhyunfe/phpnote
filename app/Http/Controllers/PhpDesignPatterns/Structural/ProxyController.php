<?php

/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/3
 * Time: 上午10:30
 * 代理模式
 * 目的：链接任何具有高价值或无法复制的代码
 */
class Record
{
    private $_data;

    public function __construct(array $data = [])
    {
        $this->_data = $data;
    }

    public function __set($name, $value)
    {
        // TODO: Implement __set() method.
        $this->_data[$name] = $value;
    }

    public function __get($name)
    {
        // TODO: Implement __get() method.
        if (isset($this->_data[$name])) {
            return $this->_data[$name];
        }
        return false;
    }
}

class RecordProxy extends Record
{
    private $_isDirty = false;

    private $_isInitialized = false;

    public function __construct(array $data)
    {
        parent::__construct($data);
        if (count($data) > 0) {
            $this->_isDirty = true;
            $this->_isInitialized = true;
        }
    }

    public function __set($name, $value)
    {
        $this->_isDirty = true;
        parent::__set($name, $value); // TODO: Change the autogenerated stub
    }

    public function isDirty()
    {
        return $this->_isDirty;
    }
}