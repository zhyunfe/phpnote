<?php

/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/3
 * Time: 下午2:55
 */
namespace App\Http\Controllers\PhpDesignPatterns\Structual\Bridge;

class HtmlFormatter implements FormatterInterface
{
    public function format($text)
    {
        // TODO: Implement format() method.
        return sprintf('<p>%s</p>', $text);
    }
}