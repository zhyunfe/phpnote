#### 错误与异常
 * PHP是一个轻异常的语言，当异常产生时，php会尽可能的执行而无视发生的事情，除非是一个严重错误
 * PHP三个最常见的信息类型是error、notice、warning，他们有不同的严重性E_ERROR、E_NOTICE、E_WARNING
 * 另一个在编译期间会报错的信息类型是E_STRICT，这个信息是用来建议修改程序代码以维持最佳的互通性并能与今后的PHP版本兼容
 
 #### 更改PHP错误报告行为
 错误报告可由PHP配置及函数调用改变，使用php内置函数error_reporting()
 行内错误抑制`echo @$foo['bar'];`
 PHP处理使用@的表达式比起不用时的效率会低一些。
 
 #### SPL异常
 
 原生的Exception类并没有提供太多的调试情景给开发员，不过可以通过建立一个特殊的Exception去弥补它，方式就是建立一个继承自原声Exception的一个子类
 
 ```
 class ValidationException extends Exception {}
 ```
 
 #### 密码加盐
 `password_hash('pwd', PASSWORD_DEFAULT)`
 `password_verify('pwd)`
 
 #### Opcode 缓存
 
 当一个PHP文件被解释执行的时候，首先被编译成名为cpcodes的中间代码，然后才被底层的虚拟机执行，如果PHP文件没有被修改过，opcode始终是一样的，这就意味着编译步骤白白浪费了CPU的资源
 
 通过opcpde缓存将opcpde缓存到内存中，可以防止冗余的编译步骤，并且在下次调用执行时得到重用
 
 PHP5.5自带了opcode缓存工具，叫做Zend OPcache，默认一般是开启的。在phpinfo()中检查opcache.enable
 
 #### 对象缓存
 
 最常用的内存对象缓存系统是APCu和Memcached，APCu的局限性表现在它依赖于所在的服务器，另一方面Memcached以独立的服务的形式安装，可以通过网络交互，这意味着你能将数据集中存在一个高速存取的地方，而且许多不通电额系统能从中获取数据
 
 当你以GGI(FastCGI)的形式使用PHP时，每个进程将会有各自的缓存，如说APCu缓存数据无法在多个工作进行中共享，在这种情况下可能就要考虑Memcached了由于它独立与PHP进程
 
 通常APCu在存取速度上比Memcached更快，但是Memcached在扩展上更有优势
 ```
 $data = apc_fetch('expensive_data');
 
 if ($data === false) {
    apc_add('expensive_data', $data = get_expendsive_data());
 }
 ```
 
 #### TDD PHPUnit
 #### 代码注释 PHPDoc
 
 