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
}
SocketController::sendSocket();