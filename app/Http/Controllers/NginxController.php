<?php
/**
 * 开始学习Nginx
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/3/19
 * Time: 上午10:11
 */

namespace App\Http\Controllers;

class NginxController extends Controller
{
    public function index()
    {
        echo phpinfo();
//        return view('nginx/index');
    }
    public function fastcgi()
    {
        $https = isset($_SERVER['HTTPS']) ? $_SERVER['HTTPS'] : '';
        $fastcgi_param = array(
            '$document_root$fastcgi_script_name' => array('desc' => 'SCRIPT_FILENAME脚本文件路径', 'value' => $_SERVER['SCRIPT_FILENAME']),
            '$query_string'     => array('desc' => 'QUERY_STRING请求参数',   'value' => $_SERVER['QUERY_STRING']),
            '$request_method'   => array('desc' => 'REQUEST_METHOD请求方法', 'value' =>  $_SERVER['REQUEST_METHOD']),
            '$content_type'     => array('desc' => 'CONTENT_TYPE文本类型',   'value' => $_SERVER['CONTENT_TYPE']),
            '$content_length'   => array('desc' => 'CONTENT_LENGTH文本长度', 'value' => $_SERVER['CONTENT_LENGTH']),
            '$fastcgi_script_name' => array('desc' => 'SCRIPT_NAME脚本名称',         'value' => $_SERVER['SCRIPT_NAME']),
            '$request_uri'      => array('desc' => 'REQUEST_URI请求',               'value' => $_SERVER['REQUEST_URI']),
            '$document_uri'     => array('desc' => 'DOCUMENT_URI文件uri',           'value' => $_SERVER['DOCUMENT_URI']),
            '$document_root'    => array('desc' => 'DOCUMENT_ROOT文件根路径',         'value' => $_SERVER['DOCUMENT_ROOT']),
            'server_protocol'   => array('desc' => 'SERVER_PROTOCOL服务器请求协议',       'value' => $_SERVER['SERVER_PROTOCOL']),
            '$scheme'           => array('desc' => 'REQUEST_SCHEME HTTP scheme',        'value' => $_SERVER['REQUEST_SCHEME']),
            '$https'            => array('desc' => 'HTTPS是否开启https',                 'value' => $https),
            '$remote_addr'      => array('desc' => 'REMOTE_ADDR远程地址',           'value' => $_SERVER['REMOTE_ADDR']),
            '$remote_port'      => array('desc' => 'REMOTE_PORT远程端口',           'value' => $_SERVER['REMOTE_PORT']),
            '$server_addr'      => array('desc' => 'SERVER_ADDR服务器地址',           'value' => $_SERVER['SERVER_ADDR']),
            '$server_port'      => array('desc' => 'SERVER_PORT服务器端口',           'value' => $_SERVER['SERVER_PORT']),
            '$server_name'      => array('desc' => 'SERVER_NAME域名',           'value' => $_SERVER['SERVER_NAME']),
        );
        return dd($fastcgi_param);
    }
    public function location()
    {
        $location = array(
            'thinkphp' => array('location /' => 'if (!-e $request_filename) {rewrite ^(.*)$ /index.php?s=/$1 last;break;}'),
            'lavavel'  => array('location /' => 'try_file $uri $uri/ /index.php?$query_string'),
            'php'      => array('location ~\.php$' => 'fastcgi_pass 127.0.0.1:9000;'.PHP_EOL.'fastcgi_index index.php;'.PHP_EOL.'fastcgi_param SCRIPT_FILENAME /scripts$fastcgi_script_name;'.PHP_EOL.'include /usr/local/etc/nginx/fastcgi.conf;')
        );
        return dd($location);
    }
    public function xdebug()
    {
        $config = ' zend_extension=/usr/lib64/php/modules/xdebug.so
                    #注意修改路径 lib64 lib32等
                    xdebug.profiler_enable = 1
                    xdebug.profiler_enable_trigger = 1
                    #通过在URL中传递参数XDEBUG_PROFILE来激活profiling，比如index.php?XDEBUG_PROFILE
                    xdebug.profiler_output_dir=/tmp/xdebug/
                    #确保文件夹存在，该位置是profiler输出文件的位置。
                    #xdebug会生成名为cachegrind.out.xxx类型的文件，该文件可以用相应的工具打开来查看程序的profiling。
                    ';
    }
}