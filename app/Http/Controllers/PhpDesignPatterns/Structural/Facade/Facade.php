<?php

/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/3
 * Time: 上午11:10
 */
class Facade
{
    private $_os;
    private $_bios;

    public function __construct(BiosInterface $bios, OsInterface $os)
    {
        $this->_bios = $bios;
        $this->_os   = $os;
    }

    public function turnOn()
    {
        $this->_bios->execute();
        $this->_bios->waitForKeyPress();
        $this->_bios->launch($this->_os);
    }
    public function turnOff()
    {
        $this->_os->halt();
        $this->_bios->powerDown();
    }
}