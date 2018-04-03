<?php

/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/2
 * Time: 下午4:12
 */
class Context
{
    private $_strategy;
    public function __construct(Strategy $strategy)
    {
        $this->_strategy = $strategy;
    }
    public function contextInterface()
    {
        $this->_strategy->suanfaInterface();
    }
}