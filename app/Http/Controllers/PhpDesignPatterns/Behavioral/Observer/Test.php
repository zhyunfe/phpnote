<?php

/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/4
 * Time: 下午3:02
 */
class Test
{
    public function testChangeInUserLeadsToUserObserverBeingNofied()
    {
        $observer = new UserObserver();
        $user = new User();
        $user->attach($observer);

        $user->changeEmail('foo@bar.com');
        $observer->getChangeUsers();
    }
}