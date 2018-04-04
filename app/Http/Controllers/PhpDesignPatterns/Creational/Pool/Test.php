<?php

/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/4
 * Time: 下午2:56
 */
class Test
{
    public function testCanGetNewInstanceWithGet()
    {
        $pool = new WorkPool();
        $worker1 = $pool->get();
        $pool->dispose($worker1);
        $worker2 = $pool->get();
    }
}