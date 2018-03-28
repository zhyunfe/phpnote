<?php
/**
 * 开始学习PHP源码
 */
namespace App\Http\Controllers;

class SourceCodeController extends Controller
{
    public function index()
    {
        return view('source/index');
    }
    /*
     * 深入理解PHP内存管理之谁动了我的内存
     */
    public function memoey()
    {
        var_dump(memory_get_usage(false));
        $a = 'Demoer';
        var_dump(memory_get_usage(false));
        unset($a);
        var_dump(memory_get_usage(false));
    }
}