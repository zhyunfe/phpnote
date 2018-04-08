<?php
/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/8
 * Time: 下午3:53
 */

/**
 * 用于设计模式中的中介者模式实体
 * 通过协调三个不同的类去完成相应的动作
 * Class Mediator
 */
class Mediator implements MediatorInterface
{
    private $server;

    private $database;

    private $client;

    public function __construct($databases, $client, $server)
    {
        $this->server = $server;
        $this->database = $databases;
        $this->client = $client;

        $this->database->setMediator($this);
        $this->server->setMediator($this);
        $this->client->setMediator($this);
    }

    public function makeRequest()
    {
        // TODO: Implement makeRequest() method.
        $this->server->process();
    }

    public function queryDb()
    {
        // TODO: Implement queryDb() method.
        $this->database->getData();
    }

    public function sendResponse($content)
    {
        // TODO: Implement sendResponse() method.
        $this->client->output($content);
    }
}