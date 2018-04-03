<?php

/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/3
 * Time: 下午3:33
 */
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