<?php

/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/3
 * Time: 上午11:45
 */
class JsonRender extends RenderDecorator
{
    public function renderData()
    {
        // TODO: Implement renderData() method.
        return json_encode($this->wrapped->renderData());
    }
}