<?php
/**
 * 观察者模式
 * 目的：定义对象见的一种一对多的依赖关系，当一个对象的状态发生改变时，所有依赖于它的对象都得到通知并被自动更新，又称发布-订阅模式、模型-视图模式、源-监听模式或从属者模式
 *
 * 主要角色：
 * 抽象主题角色：主题角色将所有对观察者对象的引用保存在一个集合中，每个主题可以有任意多个观察者，抽象主题提供你那个了增加和删除观察者对象的接口
 * 抽象观察者角色：为所有的具体观察者定义一个接口，在观察的主题发生改变时更新自己
 *
 * 具体主题角色：存储相关状态到具体观察对象，当具体对象的内部状态改变时，给所有登记过的观察者发出通知，具体主题角色通常用一个具体子类实现
 * 具体观察者角色：存储一个具体主题角色，存储相关状态，实现抽象观察者角色所要求的更新接口，以使得自身状态和主题的状态保持一致
 *
 * 优点：
 * 1、观察者和主题之间的耦合度较小
 * 2、支持广播通信
 * 缺点：
 * 1、由于观察者不知道其他观察者的存在，它可能对该边目标的最终代价一无所知，这可能会引起意外的更新
 *
 * 适用场景
 * 1、当一个抽象模型有两个方面，其中一个方面依赖于另一个方面
 * 2、当对一个对象的改变需要同时改变其他对象，而不知道具体有多少个对象待改变
 * 3、当一个对象必须通知其他对象，而它又不能假定其他对象是谁，换句话说，你不希望这些对象是紧密耦合的
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/3/30
 * Time: 下午6:31
 */

//抽象主题
interface Subject
{
    //添加一个观察者对象
    public function attach(Observer $observer);

    //删除一个观察者对象
    public function delete(Observer $observer);
}

//具体主题
class ConcreteSubject implements Subject
{
    private $_observer;
    public function __construct()
    {
        $this->_observer = array();
    }

    //添加一个观察者
    public function attach(Observer $observer)
    {
        $this->_observer[] = $observer;
        return $this->_observer;
    }

    public function delete(Observer $observer)
    {
        if (in_array($observer, $this->_observer)) {
            //找到这个对象的索引
            $index = array_search($observer, $this->_observer);
            unset($this->_observer[$index]);
        }
        return $this->_observer;
    }

    public function notifyObserver()
    {
        if (!is_array($this->_observer)) {
            return false;
        }
        foreach ($this->_observer as $observer)
        {
            $observer->update();
        }
        return true;
    }
}
//抽象观察者
interface Observer
{
    public function update();
}

//具体观察者
class ConcreteObserver implements Observer
{
    private $_name;

    public function __construct($name)
    {
        $this->_name = $name;
    }

    public function update()
    {
        echo 'Observer ' . $this->_name . ' has notified' . PHP_EOL;
    }
}

//客户端
class Client
{
    public static function main()
    {
        //创建一个主题
        $subject = new ConcreteSubject();
        //创建两个观察者
        $observer1 = new ConcreteObserver('Demor');
        $observer2 = new ConcreteObserver('zhyunfe');
        //将观察者插入
        $subject->attach($observer1);
        $subject->attach($observer2);
        //通知更新
        $subject->notifyObserver();
        //删除观察者
        $subject->delete($observer1);
    }
}
Client::main();

//示例2 Web站点具有站点访问者可用某些社交类型功能，其中，集成的最新功能是一个活动流，它能够在主页显示最近的购买情况。

class CD
{
    public $title = '';
    public $band = '';

    protected $_observers = array();

    public function __construct($title, $band)
    {
        $this->title = $title;
        $this->band = $band;
    }

    public function attachObserver($type, $observer)
    {
        $this->_observers[$type][] = $observer;
    }

    public function notifyObserver($type)
    {
        if (isset($this->_observers[$type])) {
            foreach ($this->_observers[$type] as $observer) {
                $observer->update($this);
            }
        }
    }

    public function buy()
    {
        $this->notifyObserver('purchased');
    }
}

class bugCDNotifyStreamObserver
{
    public function update(CD $cd)
    {
        $activity = 'The CD named' . $cd->title . 'by' . $cd->band . 'was just purchased';
        activityStream::addNewItem($activity);
    }
}

class activityStream
{
    public static function addNewItem($item)
    {
        echo $item;
    }
}

$title = 'Waste of a Rib';
$band = 'Nerver Again';

$cd = new CD($title, $band);
var_dump($cd);
$observer = new bugCDNotifyStreamObserver();
$cd->attachObserver('purchased', $observer);
$cd->buy();