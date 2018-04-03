<?php

/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/3
 * Time: 上午11:48
 */
class Test
{
    private $_service;

    protected function setUp()
    {
        $this->_service = new Webservice('foobar');
    }

    public function testJsonDecorator()
    {
        $service = new JsonRender($this->_service);
        $service->renderData();
    }

    public function testXmlDecorator()
    {
        $service = new XmlRender($this->_service);
        $service->renderData();
    }
}