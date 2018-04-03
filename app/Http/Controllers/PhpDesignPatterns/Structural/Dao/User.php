<?php
/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/3
 * Time: 下午3:33
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