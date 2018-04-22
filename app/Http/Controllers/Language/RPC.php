<?php
class RPC {

    private $url;
    private $proxy;
    private $className;

    function __construct($url, $proxy, $className) {
        $this->url = $url;
        $this->proxy = $proxy;
        $this->className = $className;
    }


    function __call($name, $arguments) {

        $invokeParam = array('class' => $this->className, 'method' => $name, 'arguments' => $arguments);
        $invokeResult = $this->invoke($invokeParam);
        if ($invokeResult && is_array($invokeResult)
            && array_key_exists('stdout', $invokeResult)
            && array_key_exists('success', $invokeResult)
            && array_key_exists('result', $invokeResult)
            && array_key_exists('exception', $invokeResult)
        ) {
            if ($invokeResult['stdout']) echo $invokeResult['stdout'];
            if ($invokeResult['success']) {
                return $invokeResult['result'];
            } else {
                if ($invokeResult['exception']) throw new Exception($invokeResult['exception']);
            }
        }

    }

    private function invoke($invokeParam) {

        $invokeInfo = serialize($invokeParam);
        //初始化curl
        $curl = curl_init();
        if ($this->proxy) {
            $proxy = "http://" . $this->proxy;
            curl_setopt($curl, CURLOPT_PROXY, $proxy);
        }
        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: text/plain", "Content-length: " . strlen($invokeInfo)));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $invokeInfo);
        $content = curl_exec($curl);
        curl_close($curl);

        return unserialize($content);

    }
}
$rpc = new RPC('http://my.gm99.com','','Payment');
$result0 = $rpc->test();
$rpc = new RPC('http://my.gm99.com','','PaymentApi');
$result1 = $rpc->test();

var_dump($result1);