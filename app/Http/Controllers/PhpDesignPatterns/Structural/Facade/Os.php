<?php
/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/3
 * Time: 上午11:26
 */
class Os implements OsInterface
{
    private $_name;

    public function __construct($name)
    {
        $this->_name = $name;
    }

    public function getName()
    {
        // TODO: Implement getName() method.
        return $this->_name;
    }

    public function halt()
    {
        // TODO: Implement halt() method.
        echo '关机';
    }
}