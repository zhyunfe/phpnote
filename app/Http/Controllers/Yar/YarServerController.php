<?php
/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/3/26
 * Time: 下午8:55
 */
namespace App\Http\Controllers;

class YarServerController extends Controller
{
    public function api($params, $option = 'foo')
    {
        return $params;
    }
    protected function client_can_not_see()
    {

    }
}