<?php
/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/2
 * Time: 下午4:34
 */
class Index
{
    public function index()
    {
        $builder = new ProductBuilder(array('size' => 'xxl', 'color' => 'red', 'type' => 'god'));
        $builder->build();
        $builder->getProduct();
    }
}