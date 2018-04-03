<?php
/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/3
 * Time: 下午3:02
 */
namespace App\Http\Controllers\PhpDesignPatterns\Structual\Bridge;
use  App\Http\Controllers\PhpDesignPatterns\Structual\Bridge\HelloWorldService;
use  App\Http\Controllers\PhpDesignPatterns\Structual\Bridge\PlainTextFormatter;
use  App\Http\Controllers\PhpDesignPatterns\Structual\Bridge\HtmlFormatter;

class Test
{
    public static function printUsingThePlainTextPrinter()
    {
        $service = new HelloWorldService(new PlainTextFormatter());
        $service->get();

        $service2 = new HelloWorldService(new HtmlFormatter());
        $service2->get();
    }
}
Test::printUsingThePlainTextPrinter();