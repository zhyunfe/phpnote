<?php

/**
 * 外观模式/门面模式
 * 目的：为子系统中的一组接口提供一个一致的界面，Facade模式定义了一个高层次的接口，使得子系统更加容易使用
 *
 * 主要角色：
 * 门面角色：此角色将被客户端调用
 *          知道哪些子系统负责处理请求
 *          将用户的请求指派给适当的子系统
 * 子系统角色：
 *          实现子系统的功能
 *          处理由Facade对象指派的任务
 *          没有Facade的相关信息，可以被客户端直接调用
 *
 * 优点：
 * 1、对客服屏蔽了子系统组件，因而减少了客户处理的对象的数目并使得子系统使用起来更加方便
 * 2、实现子系统与客户之间的怂耦合关系
 * 3、如果应用需要，它并不限制他们使用子系统类，因此可以在系统易用性与能用性之间加以选择
 *
 * 使用场景
 * 1、将一些复杂的子系统提供一组接口
 * 2、提高子系统的独立性
 * 3、在层次化结构中，可以使用门面模式定义系统的每一层的接口
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/3/28
 * Time: 下午4:09
 */

//为了完全必要的审计，公司的web站点每夜都要讲其库存信息传递至公司内的不同系统，这个系统只处理大写的字符串，具体代码需要获取CD对象，对其所有的属性应用大写形式，并且创建一个要提交给web服务的格式完整的XML文档
//两个任务：大写 + 创建xml文档

class CD
{
    public $tracks = array();
    public $band = '';
    public $title = '';
    public function __construct($title, $band, $tracks)
    {
        $this->title = $title;
        $this->band = $band;
        $this->tracks = $tracks;
    }
}

class CDUpperCase
{
    public static function makeString(CD $cd, $type)
    {
        $cd->$type = strtoupper($cd->$type);
    }
    public static function makeArray(CD $cd, $type)
    {
        $cd->$type = array_map('strtoupper', $cd->$type);
    }
}

class CDMakeXML
{
    public static function create(CD $cd)
    {
        $doc = new DOMDocument();
        $root = $doc->createElement('CD');
        $root = $doc->appendChild($root);

        $title = $doc->createElement('TITLE', $cd->title);
        $title = $root->appendChild($title);

        $band = $doc->createElement('BAND', $cd->band);
        $band = $root->appendChild($band);

        $tracks = $doc->createElement('TRACKS');
        $tracks = $root->appendChild($tracks);

        foreach ($cd->tracks as $track) {
            $track = $doc->createElement('TRACK', $track);
            $track = $tracks->appendChild($track);
        }
        return $doc->saveXML();
    }
}


$tracksFromExternalSource = array('What It Means', 'Brr','Goodbye');
$title = 'Waste of a Rib';
$band = 'Never Again';
$cd = new CD($title, $band, $tracksFromExternalSource);

CDUpperCase::makeString($cd, 'title');
CDUpperCase::makeString($cd, 'band');
CDUpperCase::makeArray($cd, 'tracks');
print CDMakeXML::create($cd);

//门面模式
class WebServiceFacade
{
    public static function makeXMLCall(CD $cd)
    {
        CDUpperCase::makeString($cd, 'title');
        CDUpperCase::makeString($cd, 'band');
        CDUpperCase::makeArray($cd, 'tracks');
        $xml = CDMakeXML::create($cd);

        return $xml;
    }
}

print WebServiceFacade::makeXMLCall($cd);


/**
 * 例子2
 */

class Camera
{
    public function turnOn()
    {
        echo 'turn on the camera';
    }
    public function turnOff()
    {
        echo 'turn off the camera';
    }
    public function rotate($degree)
    {
        echo 'rotating the camera by ' . $degree . 'degress' . PHP_EOL;
    }
}

class Light
{
    public function turnOn()
    {
        echo 'turn on the light';
    }
    public function turnOff()
    {
        echo 'turn off the light';
    }

    public function changeBulb()
    {
        echo 'changing the light-bulb' .PHP_EOL;
    }

}

class Sensor
{
    public function active()
    {
        echo 'active the sensor';
    }
    public function deactive()
    {
        echo 'deactive the sensor';
    }
    public function trigger()
    {
        echo 'the sensor has been trigged';
    }
}


//门面类

class SecurityFacade
{
    private $_camera1, $_camera2;
    private $_light1, $_light2, $_light3;
    private $_sensor;

    public function __construct()
    {
        $this->_camera1 = new Camera();
        $this->_camera2 = new Camera();

        $this->_light1 = new Light();
        $this->_light2 = new Light();
        $this->_light3 = new Light();

        $this->_sensor = new Sensor();
    }

    public function active()
    {
        $this->_camera1->turnOn();
        $this->_camera2->turnOn();
        $this->_light1->turnOn();
        $this->_sensor->active();
    }

    public function deactive()
    {
        $this->_camera1->turnOff();
        $this->_camera2->turnOff();
        $this->_light1->turnOff();
    }
}

//客户端
class Client
{
    private static $_security;

    public static function main()
    {
        self::$_security = new SecurityFacade();
        self::$_security->active();
    }
}
Client::main();