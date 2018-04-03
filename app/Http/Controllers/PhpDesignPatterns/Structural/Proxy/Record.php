<?php
/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/3
 * Time: 下午12:28
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