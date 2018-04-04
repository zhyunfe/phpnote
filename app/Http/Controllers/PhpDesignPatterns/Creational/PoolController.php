<?php
/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/4
 * Time: 下午2:41
 * 对象池设计模式
 * 目的：对象池设计模式是一种提前准备了一组已经初始化的对象池，而不是按需创建或者销毁的创建性设计模式。
 * 对象池的客户端会向对象池中请求一个对象，然后使用这个返回的对象执行相关操作，当客户端使用完毕，它将把这个特定类型的工厂对象返回给对象池，而不是销毁这个对象
 *
 * 在初始化实例成本高、实例化率高、可用例不足的情况下，对象池可以极大地提升性能
 * 在创建对象，尤其是通过网络时间花销不确定的情况下，通过对象池在可期时间内就可以获得所需的对象
 *
 * 对象池模式在需要耗时创建对象方面，例如创建数据库连接，套接字连接，线程和大型图形对象（比如字体或位图），使用起来都是大有裨益的
 *
 * 在某些情况下，简单的对象池（无外部资源，只占内存）可能效率不高，甚至会有损性能
 */
class StringReverseWorker
{
    private $createAt;

    public function __construct()
    {
        $this->createAt = new DateTime();
    }

    public function run($text)
    {
        return strrev($text);
    }
}

class WorkPool implements Countable
{
    private $occupiedWorkers = [];

    private $freeWorkers = [];

    public function get()
    {
        if (count($this->freeWorkers) == 0) {
            $worker = new StringReverseWorker();
        } else {
            $worker = array_pop($this->freeWorkers);
        }
        $this->occupiedWorkers[spl_object_hash($worker)] = $worker;
        return $worker;
    }

    public function dispose( StringReverseWorker $worker)
    {
        $key = spl_object_hash($worker);

        if (isset($this->occupiedWorkers[$key])) {
            unset($this->occupiedWorkers[$key]);
            $this->freeWorkers[$key] = $worker;
        }
    }

    public function count()
    {
        // TODO: Implement count() method.
        return count($this->occupiedWorkers) + count($this->freeWorkers);
    }
}

class Test
{
    public function testCanGetNewInstanceWithGet()
    {
        $pool = new WorkPool();
        $worker1 = $pool->get();
        $pool->dispose($worker1);
        $worker2 = $pool->get();
    }
}