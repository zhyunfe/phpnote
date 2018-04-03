<?php

/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/3
 * Time: 下午3:19
 * 数据映射模式
 * 数据映射模式是一种数据访问层，它执行持久性数据存储（通常是关系数据库）和内存数据表示（域层）之间的数据双向传输，该模式的目标是保持内存表示和持久数据存储相互独立，并保持数据映射器本身
 * 该层由一个或者多个映射器（或数据访问对象）组成，执行数据传输
 * 映射器实现的范围有所不同
 * 通用映射器将处理许多不同的域实体类型
 * 专用映射器处理一个或几个
 *
 * 这种模式的关键在于，与活动记录模式不同，数据模型遵循单一责任原则
 */

/**
 * Class User
 * 用户对象
 */
class User
{
    private $username;

    private $email;

    public static function fromState($state)
    {
        return new self($state['username'], $state['email']);
    }
    public function __construct($username, $email)
    {
        $this->username = $username;
        $this->email = $email;
    }

    public function getUsername()
    {
        return $this->username;
    }
    public function getEmail()
    {
        return $this->email;
    }
}

/**
 * Class StorageAdapter
 * 存储数据
 */
class StorageAdapter
{
    private $data = [];

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function find($id)
    {
        if (isset($this->data[$id])) {
            return $this->data[$id];
        }
        return null;
    }
}
class UserMapper
{
    //存储委托器
    private $adpter;

    public function __construct(StorageAdapter $storage)
    {
        $this->adpter = $storage;
    }
    public function findById($id)
    {
        $result = $this->adpter->find($id);

        if ($result == null) {
            throw new Exception('User #id not found');
        }
        //返回User对象
        return $this->mapRowToUser($result);
    }

    private function mapRowToUser($row)
    {
        //返回User对象
        return User::fromState($row);
    }
}

class Test
{
    public function canMapUserFromStorage()
    {
        $storage = new StorageAdapter([1 => ['username' => 'zhyunfe', 'email' => 'zhyunfe@hotmail.com']]);
        $mapper = new UserMapper($storage);

        $user = $mapper->findById(1);
        return $user;
    }

    public function cannotMapUserFromStorage()
    {
        $storage = new StorageAdapter([]);
        $mapper = new UserMapper($storage);
        return $mapper->findById(1);
    }
}