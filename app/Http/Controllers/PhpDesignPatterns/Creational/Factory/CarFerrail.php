<?php

/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/3
 * Time: 下午4:45
 */
class CarFerrail implements VehicleInterface
{
    private $_color;
    public function setColor($rgb)
    {
        // TODO: Implement setColor() method.
        $this->_color = $rgb;
    }
}