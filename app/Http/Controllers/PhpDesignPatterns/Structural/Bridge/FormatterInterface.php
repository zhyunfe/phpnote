<?php

/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/3
 * Time: 下午2:53
 */
namespace App\Http\Controllers\PhpDesignPatterns\Structual\Bridge;

interface FormatterInterface
{
    public function format($text);
}