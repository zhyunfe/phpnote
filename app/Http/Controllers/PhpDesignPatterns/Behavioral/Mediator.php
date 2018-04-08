<?php

/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/5
 * Time: 上午11:20
 * 中介者设计模式
 * 目的：本模式提供了一种轻松的多组件之间弱耦合的协同方式
 * 所有关联协同的组件仅与MediatorInterface接口建立耦合
 * 示例Web站点不仅允许乐队进入和管理他们的音乐合集，而且还允许乐队更新他们的配置文件、修改乐队相关信息以及更新其CD信息
 * 艺术家可以上传MP3集合并从WEB站点上撤下CD，因此Web站点需要保持相对应的CD和Mp3彼此同步
 */

/**
 * Class CD
 * CD对象可以具有乐队名和标题，函数changeBandName()接受新的乐队名参数
 */
class CD
{
    public $band = '';
    public $title = '';

    public function save()
    {
        var_dump($this);
    }
    public function changeBandName($newName)
    {
        $this->band = $newName;
        $this->save();
    }
}

/**
 * 为了添加MP3归档文件，就需要创建另一个类似的对象来处理归档文件，艺术家必须也能够在MP3归档文件页面上修改其乐队名，同样与之关联的CD中也必须能够修改乐队名
 */

class CDMed
{
    public $band = '';
    public $title = '';
    protected $_mediator;

    public function __construct($mediator = null)
    {
        $this->_mediator = $mediator;
    }

    public function save()
    {
        var_dump($this);
    }

    public function changeBandName($newName)
    {
        if (!is_null($this->_mediator)) {
            $this->_mediator->change($this, array('band' => $newName));
        }
        $this->band = $newName;
        $this->save();
    }

}

class MP3Archive
{
    public $band = '';
    public $title = '';
    protected $_mediator;

    public function __construct($mediator = null)
    {
        $this->_mediator = $mediator;
    }

    public function save()
    {
        value($this);
    }

    public function changeBandName($newName)
    {
        if (!is_null($this->_mediator)) {
            $this->_mediator->change($this, array('band' => $newName));
        }
        $this->band = $newName;
        $this->save();
    }
}

class MusicContainerMediator
{
    protected $_containers = array();

    public function __construct()
    {
        $this->_containers[] = 'CDMed';
        $this->_containers[] = 'MP3Archive';
    }

    public function change($originalObject, $newValue)
    {
        $title = $originalObject->title;
        $band  = $originalObject->band;

        foreach ($this->_containers as $container) {
            if (!($originalObject instanceof $container)) {
                $object = new $container;
                $object->title = $title;
                $object->band = $band;
                foreach ($newValue as $key=>$value) {
                    $object->$key = $value;
                }
                $object->save;
            }
        }
    }
}

$titleFromDB = 'Waste of a Rib';
$bandFromDB = 'Nerver Again';

$mediator = new MusicContainerMediator();
$cd = new CDMed($mediator);
$cd->title = $titleFromDB;
$cd->band = $bandFromDB;
$cd->changeBandName('Maybe Once More');