<?php

/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/3
 * Time: 下午4:39
 */
abstract class FactoryMethod
{
    const CHEAP = 'cheap';
    const FAST = 'fast';

    abstract protected function createVehicle($type);

    public function create($type)
    {
        $obj = $this->createVehicle($type);

        $obj->setColor('black');
        return $obj;
    }
}