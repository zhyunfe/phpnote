<?php

/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/3
 * Time: 下午2:54
 */
namespace App\Http\Controllers\PhpDesignPatterns\Structual\Bridge;
class PlainTextFormatter implements FormatterInterface
{
    public function format($text)
    {
        // TODO: Implement format() method.
        return $text;
    }
}