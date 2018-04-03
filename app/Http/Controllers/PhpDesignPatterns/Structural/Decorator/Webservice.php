<?php
/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/3
 * Time: 上午11:46
 */
class Webservice implements RenderableInterface
{
    private $_data;

    public function __construct($data)
    {
        $this->_data = $data;
    }

    /**
     * @return mixed
     * 实现RenderableInterface渲染接口中的renderData方法
     */
    public function renderData()
    {
        // TODO: Implement renderData() method.
        return $this->_data;
    }
}