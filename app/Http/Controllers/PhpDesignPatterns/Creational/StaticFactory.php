<?php
/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/4
 * Time: 下午12:08
 */
final class StaticFactory
{
    public static function factory($type)
    {
        if ($type == 'number') {
            return new FormatNumber();
        }
        if ($type == 'string') {
            return new FormatString();
        }
        return null;
    }
}
interface FormatterInterface
{
    public function create();
}

class FormatString implements FormatterInterface
{
    public function create()
    {
        // TODO: Implement create() method.
        echo "创建了一个string";
    }
}
class FormatNumber implements FormatterInterface
{
    public function create()
    {
        // TODO: Implement create() method.
        echo '创建了一个number';
    }
}

class Test
{
    public function index()
    {
        $string = StaticFactory::factory('string');
        $string->create();
    }
}