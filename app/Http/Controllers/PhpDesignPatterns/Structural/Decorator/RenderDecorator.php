<?php

/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/3
 * Time: 上午11:41
 */
abstract  class RenderDecorator implements RenderableInterface
{
    /**
     * @var
     * 定义渲染接口变量
     */
    protected $wrapped;

    /**
     * RenderDecorator constructor.
     * @param RenderableInterface $render
     * 传入渲染接口类对象 $render
     */
    public function __construct(RenderableInterface $render)
    {
        $this->wrapped = $render;
    }
}