<?php

/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/3
 * Time: 下午3:34
 */
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