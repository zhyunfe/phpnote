<?php

/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/3
 * Time: 下午4:16
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