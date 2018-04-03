<?php

/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/3
 * Time: 下午4:16
 */
class Test
{
    public function index()
    {
        $query = (new Sql())->select(['Foo','bar'])->from('foobar','f')->where('f.bar = ?');
        //SELECT foo,bar FROM foobar AS f WHERE f.bar = ?
        echo $query;
    }
}