<?php
/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/4
 * Time: 下午3:01
 */
class UserObserver implements SplObserver
{
    private $changedUsrs = [];

    public function update(SplSubject $subject)
    {
        // TODO: Implement update() method.
        $this->changedUsrs[] = clone $subject;
    }

    public function getChangeUsers()
    {
        return $this->changedUsrs;
    }
}