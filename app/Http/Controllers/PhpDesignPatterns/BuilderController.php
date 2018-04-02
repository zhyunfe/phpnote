<?php

/**
 * 建造者模式
 * 建造者模式可以让一个产品内部表象和产品的生产过程分离开，从而可以生成具有不同内部表象的产品
 * 优点：可以很好的将一个对象的实现与相关的业务逻辑分离开来，从而可以在不改变时间逻辑的前提下使得增加(或改变)实现变得非常容易
 * 缺点：建造者的接口的修改会导致所有执行类的修改
 *
 * 使用场景和效果
 *
 * 使用场景：
 * 1、需要生成的产品对象有复杂的内部结构
 * 2、需要生成的产品对象的属性相互依赖，建造者模式可以强迫生成顺序
 * 3、在对象创建过程中会使用到系统的一些其他对象，这些对象在产品对象的创建过程中不易得到
 *
 * 效果：
 * 1、建造者模式的使用使得产品的内部表象可以独立的变化，使用建造者模式可以使客户端不必知道产品内部组成的细节
 * 2、每一个builder都相对独立，与其他builder无关
 * 3、模式所建造的最终产品更易于
 */

class Product
{
    protected $_type = '';
    protected $_size = '';
    protected $_color = '';

    public function setType($type)
    {
        $this->_type = $type;
    }

    public function setSize($size)
    {
        $this->_size = $size;
    }

    public function setColor($color)
    {
        $this->_color = $color;
    }
}
//为了创建完整的产品对象，需要将产品配置分别传递给产品类的每个方法

$productConfigs = array('type' => 'shirt', 'size' => 'XL', 'color' => 'red');

$product = new Product();
$product->setType($productConfigs['type']);
$product->setSize($productConfigs['size']);
$product->setColor($productConfigs['color']);
//这样分别调用每个方法并不是最佳的做法，此时我们最好使用基于建造者设计模式的对象来创建产品实例

class ProductBuilder
{
    protected $_product = NULL;
    protected $_configs = array();

    public function __construct($config)
    {
        $this->_product = new Product();
        $this->_configs = $config;
    }

    public function build()
    {
        $this->_product->setSize($this->_configs['size']);
        $this->_product->setType($this->_configs['type']);
        $this->_product->setColor($this->_configs['color']);
    }

    public function getProduct()
    {
        return $this->_product;
    }
}

$builder = new ProductBuilder($productConfigs);
$builder->build();
$product = $builder->getProduct();