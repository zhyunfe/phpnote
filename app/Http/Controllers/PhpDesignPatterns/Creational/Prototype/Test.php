<?php
/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/4
 * Time: 下午2:35
 */
class Test
{
    public function index()
    {
        $fooPrototype = new FooBookPrototype();
        $barPrototype = new BarBookPrototype();

        for ($i = 0; $i < 10; $i++) {
            $book = clone $fooPrototype;
            $book->setTitle('FooBook No' . $i);
        }

        for ($i = 0; $i < 10; $i++) {
            $book = clone $barPrototype;
            $book->setTitle('BarBook No' . $i);
        }

    }
}