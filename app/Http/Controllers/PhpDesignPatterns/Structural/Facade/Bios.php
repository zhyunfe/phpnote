<?php
/**
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/4/3
 * Time: 上午11:24
 */
class Bios implements BiosInterface
{
    public function execute()
    {
        // TODO: Implement execute() method.
        echo '正在开机';
    }

    public function waitForKeyPress()
    {
        // TODO: Implement waitForKeyPress() method.
        echo '请求输入密码';
    }

    public function launch(OsInterface $os)
    {
        // TODO: Implement launch() method.
        echo '正在启动要启动的os:windows or macos';
    }

    public function powerDown()
    {
        // TODO: Implement powerDown() method.
        echo '关机';
    }
}