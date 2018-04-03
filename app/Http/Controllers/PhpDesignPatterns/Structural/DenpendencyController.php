<?php

/**
 * 依赖注入模式
 * 目的：用松散耦合的方式来更好实现可测试、可维护、可扩展的代码
 * 用法：databaseConfiguration被注入databaseConnection，并获取所需$config，如果没有依赖注入模式，配置将直接创建databaseConnection，这对测试和扩展很不好
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/3
 * Time: 上午10:28
 */
class DatabaseConfiguation
{
    private $host;
    private $port;
    private $username;
    private $password;

    public function __construct($host, $port, $username, $password)
    {
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function getUsername()
    {
        return $this->getUsername();
    }

    public function getPassword()
    {
        return $this->getPassword();
    }
}

class DatabaseConnection
{
    private $configuration;

    public function __construct(DatabaseConfiguation $configuration)
    {
        $this->configuration = $configuration;
    }
    public function getDsn()
    {
        return sprintf(
            '%s:%s@%s:%d',
            $this->configuration->getUsername(),
            $this->configuration->getPassword(),
            $this->configuration->getHost(),
            $this->configuration->getPort()
            );
    }
}

class Test
{
    public function index()
    {
        $config = new DatabaseConfiguation('localhost', 3306, 'zhyunfe', 'zhyunfe');
        $connection = new DatabaseConnection($config);
        $connection->getDsn();
    }
}