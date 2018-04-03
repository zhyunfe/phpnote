<?php

/**
 * 数据访问对象模式
 *
 * 就是我们的MVC中的Model层的实现方式
 * Created by PhpStorm.
 * User: zhyunfe
 * Date: 2018/3/28
 * Time: 上午9:09
 */
define('DB_USER','zhyunfe');
define('DB_PWD','zhyunfe');
define('DB_HOST','zhyunfe');
define('DB_DATABASE','zhyunfe');
abstract class baseDAO
{

    private $_connection;
    public function __construct()
    {
        $this->_connectToBD(DB_USER, DB_PWD, DB_HOST, DB_DATABASE);
    }

    private function _connectToBD($user, $pwd, $host, $database)
    {
        $this->_connection = mysqli_connect($host, $user, $pwd, $database);
    }

    public function fetch($value, $key=null)
    {
        return 1;
    }
    public function update($keyedArray)
    {
        return 1;
    }
    public function delete($keyedArray)
    {
        return 1;
    }
}
class userDAO extends baseDAO
{
    protected $_tableName = 'userTable';
    protected $_primaryKey = 'id';

    public function getUserByFirstName($name)
    {
        $result = $this->fetch($name, 'firstName');
        return $result;
    }
}

$user = new userDAO();
$userDetailArrar = $user->fetch(1);
$update = $user->update(array('id'=>1, 'firstName' => 'demor' ));