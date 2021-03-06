<?php

/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/3
 * Time: 上午10:29
 * 流接口模式
 * 用来编写易于阅读的代码，就像自然语言一样
 */
class Sql
{
    private $fileds = [];

    private $from = [];

    private $where = [];

    public function select($fileds)
    {
        $this->fileds = $fileds;
        return $this;
    }

    public function from($table, $alias)
    {
        $this->from[] = $table . 'AS' .$alias;
        return $this;
    }

    public function where($condition)
    {
        $this->where[] = $condition;
        return $this;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return sprintf('SELECT %s FROM %s WHERE %s',
            join(',', $this->fileds),
            join(',', $this->from),
            join(' AND ', $this->where));
    }
}

class Test
{
    public function index()
    {
        $query = (new Sql())->select(['Foo','bar'])->from('foobar','f')->where('f.bar = ?');
        echo $query;
    }
}