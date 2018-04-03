<?php

/**
 *
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/2
 * Time: 下午4:29
 */
class ProductBuilder
{
    protected $_product = null;
    protected $_configs = array();

    public function __construct($config)
    {
        $this->_product = new Product();
        $this->_configs = $config;
    }

    public function build()
    {
        $this->_product->setSize($this->_configs['size']);
        $this->_product->setColor($this->_configs['color']);
        $this->_product->setType($this->_configs['type']);
    }
    public function getProduct()
    {
        return $this->_product;
    }
}