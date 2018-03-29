<?php
/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/3/23
 * Time: 上午9:27
 */
namespace App\Http\Controllers\Language;

use App\Http\Controllers\Controller;

class FileSystemController extends Controller
{
    public function index()
    {
        return view('language/filesystem/index');
    }
    public function upload()
    {
        var_dump($_FILES);
    }
}