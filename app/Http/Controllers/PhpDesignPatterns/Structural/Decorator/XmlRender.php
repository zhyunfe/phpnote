<?php
/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/3
 * Time: 上午11:43
 */
class XmlRender extends RenderDecorator
{
    public function renderData()
    {
        // TODO: Implement renderData() method.
        $doc = new DOMDocument();
        $data = $this->wrapped->renderData();
        $doc->appendChild($doc->createElement('content', $data));

        return $doc->saveXML();
    }
}