<?php

/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/8
 * Time: 下午3:56
 */

/**
 * Class Colleague
 * Colleague是一个抽象类，该类对象虽彼此协同却不知彼此，只知中介者Mediator类
 */
class Colleague
{
    /**
     * @var
     * 确保子类不变化
     */
    protected $mediator;

    public function setMediator(MediatorInterface $mediator)
    {
        $this->mediator = $mediator;
    }
}