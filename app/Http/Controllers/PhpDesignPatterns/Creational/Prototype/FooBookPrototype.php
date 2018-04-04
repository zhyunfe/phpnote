<?php
/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/4
 * Time: 下午2:34
 */
class FooBookPrototype extends BookPrototype
{
    protected $category = 'Foo';

    public function __clone()
    {
        // TODO: Implement __clone() method.
    }
}