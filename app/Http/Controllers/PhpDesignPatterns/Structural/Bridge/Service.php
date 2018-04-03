<?php
/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/3
 * Time: 下午2:57
 */
namespace App\Http\Controllers\PhpDesignPatterns\Structual\Bridge;
abstract class Service
{
    /**
     * @var FormatterInterface
     * 定义实现属性
     */
    protected $implementation;

    /**
     * Service constructor.
     * @param FormatterInterface $printer
     * 传入FormatterInterface实现类对象
     */
    public function __construct(FormatterInterface $printer)
    {
        $this->implementation = $printer;
    }

    /**
     * @param FormatterInterface $printer
     * 和构造方法的作用相同
     */
    public function setImplementation(FormatterInterface $printer)
    {
        $this->implementation = $printer;
    }

    /**
     * @return mixed
     * 创建抽象方法
     */
    abstract public function get();
}