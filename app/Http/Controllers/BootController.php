<?php
/**
 * 开始学习bootstrap
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/3/19
 * Time: 上午10:02
 */
namespace App\Http\Controllers;

class BootController extends Controller
{
    public function index()
    {
        return view('boot/index');
    }
}