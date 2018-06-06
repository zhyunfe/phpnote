<?php
/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/1
 * Time: 下午5:14
 */
class SocketController
{
    public static function sendSocket()
    {
//        function fsockopen ($hostname, $port = null, &$errno = null, &$errstr = null, $timeout = null) {}
        $sock = fsockopen('192.168.0.1', '8001', $errno, $errstr, 1);
        if (!$sock) {
            echo $errstr;
        } else {
//            function socket_set_blocking ($socket, $mode) {}
            socket_set_blocking($sock, false);
            //数据末尾需要加上"\r\n"提交此请求数据，否则可能将无法获取服务器端的回应，即使刷新缓冲也无效，这样就只有使用end命令终止此客户端连接
            fwrite($sock, "send data...\r\n");
            fwrite($sock, "end \r\n");
            while (!feof($sock)) {
                echo fread($sock, 128);
                flush();
                ob_flush();
                sleep(1);
            }
            fclose($sock);
        }
    }

    public static function http_tesp()
    {
        $html = file_get_contents('http://www.baidu.com');
//        var_dump($http_response_header);

        $fp = fopen('http://www.baidu.com', 'r');
        print_r(stream_get_meta_data($fp));
    }

    public static function create_socket()
    {
        $host = '127.0.0.1';
        $port = '8888';
        set_time_limit(0);
        /*创建socket资源
         *第一个参数:AF_INET ipv4 AF_INET6 ipv6 AF_UNIX UNIX本地通信协议
         *第二个参数:SOCK_STREAM 可靠的全双工连接，支持TCP
         *          SOCK_DGRAM 自动寻址信息功能，支持UDP
         *          SOCK_SEQPACKET 定序分组套接字
         *          SOCK_RAW        构建传输层和网络层的原始套接字
         *          SOCK_RDM        提供可信赖的数据包连接
         */
        $socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
        //绑定socket到指定地址和端口
        $result = socket_bind($socket, $host, $port) or die("Could not bind to socket\n");
        //开始监听连接
        $resule = socket_listen($socket, 3) or die();
        //接收连接请求并调用另一个Socket处理客户端--服务器间的信息
        $spawn = socket_accept($socket) or die();
        //读取客户端输入
        $input = socket_read($spawn, 1024);
        $input = trim($input);
        //反转客户端输入数据，返回服务端
        $output = strrev($input) . "\n";
        socket_write($spawn, $output, strlen($output)) or die();

        //关闭socket
        socket_close($spawn);
        socket_close($socket);
    }

    public static function create_curl()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://www.baidu.com');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //设置post
//        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, array('name'=>'zhyunfe'));
        curl_setopt($ch, CURLOPT_HEADER, 1);
        $out = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        var_dump($info);
    }
}
//SocketController::sendSocket();
//SocketController::http_tesp();
SocketController::create_curl();