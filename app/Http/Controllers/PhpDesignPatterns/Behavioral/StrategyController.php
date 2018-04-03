<?php
/**
 * 策略模式
 *
 * 目的：定义一些列的算法，把他们一个个封装起来，并且使他们可以相互替换，策略模式可以使算法可独立于使用它的客户而变化
 *
 * 策略模式变化的是算法
 *
 * 主要角色：
 * 抽象策略角色：
 *  定义所有支持的算法的公共接口，通常是以一个接口或抽象来实现，Context使用这个接口来调用其ConcreteStrategy定义算法
 * 具体策略角色：
 *  以Strategy接口实现某具体算法
 * 环境角色：
 *  持有一个Strategy类的引用，用一个ConcreteStrategy对象来配置
 *
 * 优点：
 * 1、策略模式提供了管理相关算法族的办法
 * 2、策略模式提供了可以替换继承关系的办法，将算法封闭在独立的Strategy类中使得你可以独立于其Context改变它
 * 3、使用策略模式可以避免多重条件转移语句
 *
 * 缺点：
 * 1、客户必须了解所有的策略，这是策略模式一个潜在的缺点
 * 2、Strategy和Context之间的通信开销
 * 3、策略模式会造成很多的策略类
 *
 * 适用场景：
 * 1、许多相关的类仅仅是行为有异，策略提供一种用多个行为中的一个行为来配置一个类的方法
 * 2、需要使用一个算法的不同变体
 * 3、算法使用客户不应该知道的数据，可使用策略模式以避免暴复杂的，与算法相关的数据结构
 * 4、一个类兴义了多种行为，并且这些行为在这个类的操作中以多个形式出现。
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/1
 * Time: 下午4:10
 */

//抽象策略角色
interface Strategy
{
    public function suanfaInterface();
}

//具体策略角色
class ConcreteStrategyA implements Strategy
{
    public function suanfaInterface()
    {
        echo '算法 A';
    }
}

class ConcreteStrategyB implements Strategy
{
    public function suanfaInterface()
    {
        echo '算法B';
    }
}

class ConcreteStrategyC implements Strategy
{
    public function suanfaInterface()
    {
        echo '算法C';
    }
}

//环境角色
class Context
{
    private $_strategy;

    public function __construct(Strategy $strategy)
    {
        $this->_strategy = $strategy;
    }

    public function contextInterface()
    {
        $this->_strategy->suanfaInterface();
    }
}

class Client
{
    public static function main()
    {
        //使用策略A
        $strategyA = new ConcreteStrategyA();
        $context = new Context($strategyA);
        $context->contextInterface();

        $strategyB = new ConcreteStrategyB();
        $context = new Context($strategyB);
        $context->contextInterface();


    }
}

/**
 * 例子2
 */

class CDUserStrategy
{
    public $title;
    public $band;

    protected $_strategy;

    public function __construct($title, $band)
    {
        $this->title = $title;
        $this->band = $band;
    }

    public function setStrateContext($strategyObj)
    {
        $this->_strategy = $strategyObj;
    }

    public function get()
    {
        return $this->_strategy->get($this);
    }
}

class CDAsXMLStrategy
{
    public function get(CDUserStrategy $cd)
    {
        $doc = new DOMDocument();
        $root = $doc->createElement('CD');
        $root = $doc->appendChild($root);

        $title = $doc->createElement('Title', $cd->title);
        $title = $doc->appendChild($title);

        $band = $doc->createElement('BAND', $cd->band);
        $band = $doc->appendChild($band);

        return $doc->saveXML();
    }
}

class CDAsJsonStrategy
{
    public function get(CDUserStrategy $cd)
    {
        return json_encode(array('Title' => $cd->title, 'BAND' => $cd->band));
    }
}

$cd = new CDUserStrategy('zhyunfe', 'demoer');
$cd->setStrateContext(new CDAsXMLStrategy());
var_dump($cd->get());