<?php

/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/3
 * Time: 下午4:49
 */
class Test
{
    public function testCanCreateCheapVehicleInGermany()
    {
        $factory = new GermanFactory();
        $result = $factory->create(FactoryMethod::CHEAP);
        return $result;
    }

    public function testCanCreateFastVehicleInIntaly()
    {
        $fatory = new ItalianFactory();
        $result = $fatory->create(FactoryMethod::FAST);
        return $result;
    }
}