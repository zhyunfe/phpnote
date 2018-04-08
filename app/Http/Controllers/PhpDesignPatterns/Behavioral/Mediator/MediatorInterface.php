<?php

/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/8
 * Time: 下午3:52
 */

/**
 * 为Mediator类建立契约
 * 该接口虽非强制，但优于Liskov替换原则
 * Interface MediatorInterface
 */
interface MediatorInterface
{

    /**
     * @param $content
     * @return mixed
     * 发出响应
     */
    public function sendResponse($content);

    /**
     * @return mixed
     * 做出请求
     */
    public function makeRequest();

    /**
     * @return mixed
     * 查询数据库
     */
    public function queryDb();
}