<?php

/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/4
 * Time: 上午11:03
 * 抽象工场模式
 * 目的：在不指定具体类的情况下加创建一系列相关或依赖对象。
 * 通常创建的类都实现相同的接口。
 * 抽象工场的客户并不关心这些对象是如何创建的，它只是知道他们是如何一起运行的
 */

abstract class Text
{
    private $_text;

    public function __construct($text)
    {
        $this->_text = $text;
    }
}

class JsonText extends Text
{
    public function index()
    {

    }
}

class HtmlText extends Text
{
    public function index()
    {

    }
}
abstract class AbstractFactory
{
    abstract public function createText($content);
}

class JsonFactory extends AbstractFactory
{
    public function createText($content)
    {
        // TODO: Implement createText() method.
       return new JsonText($content);
    }
}
class HtmlFactory extends AbstractFactory
{
    public function createText($content)
    {
        // TODO: Implement createText() method.
        return new HtmlText($content);
    }
}

class Test
{
    public function index()
    {
        $factory = new HtmlFactory();
        $factory->createText('foobar');

        $factory2 = new JsonFactory();
        $factory2->createText('foobar');
    }
}