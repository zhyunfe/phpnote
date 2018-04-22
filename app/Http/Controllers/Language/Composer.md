###Composer文档
####依赖管理
Composer将这样为你解决问题：

- 你有一个项目依赖于若干个库
- 其中一些库依赖于其他库
- 你声明你所依赖的东西
- Composer会找出哪个版本的包需要安装，并安装他们

####声明依赖关系
```
{
    "require":{
         "monolog/monolog":"1.2.*"
    }
}
```
####更新一个依赖
`php composer update monolog/monolog`

`php composer update`更新全部

####下载Composer
`curl -sS https://getcomposer.org/installer | php`

`mv composer.phar /usr/local/bin/composer`

####使用Composer
`composer install`

####自动加载
`require 'vendor/autoload.php`;

####增加自己的autoloader
- 使用psr4,文件会被加载到vendor/composer/autoload_psr4.php中
```
{
    "autoload": {
        "psr4":{"App\\": "src/"}
    }
}
```
composer将注册一个PSR-4autoloader到App命名空间
添加autoload字段后，应该再次运行install命令来生成vendor/autoload.php文件

如果需要为一个相同的前缀在不同的目录下查找，可以这样写
```
{
    "autoload": {
        "psr4":{"App\\": ["src/","lib/"]}
    }
}
```
如果你想查找一个目录，里面的任何的命名空间都可以被查找，可以这样写
```
{
    "autoload": {
        "psr4":{: "src/"}
    }
}
```

- 使用psr0
psr0应用都会被存储到vendor/composer/autoload_namespace.php文件中

```
{
    "autoload": {
        "psr-0": {
            "Monolog\\": "src/",
            "Vendor\\Namespace\\": "src/",
            "Vendor_Namespace_": "src/"
        }
    }
}
```
如果你需要搜索多个目录中一个相同的前缀，你可以将它们指定为一个数组，例：

```
{
    "autoload": {
        "psr-0": { "Monolog\\": ["src/", "lib/"] }
    }
}
```
如果你想设置一个目录作为任何命名空间的备用目录，你可以使用空的前缀，像这样：
```
{
    "autoload": {
        "psr-0": { "": "src/" }
    }
}
```

PSR-0 方式并不仅限于申明命名空间，也可以是精确到类级别的指定。这对于只有一个类在全局命名空间的类库是非常有用的（如果 php 源文件也位于包的根目录）。例如，可以这样申明：
```
{
    "autoload": {
        "psr-0": { "UniqueGlobalClass": "" }
    }
}
```

- Classmap
classmap的所有引用会记录到vendor/composer/autoload_classmap.php文件里，这个map是经过扫描指定目录中所有的.php文件里内置的类而得到的

可以使用classmap生成支持自定义加载的不遵循PSR-0和PSR-4规范的类库，要配置它指向的目录，以便能准确搜索
```
{
    "autoload":{
        "classmap":["src/","lib/","Foo.php"]
    }
}
```
加载src/ 和 lib/下的Foo.php文件

- Files

如果你想要明确的指定，在每次请求时都要载入某些文件，那么你可以使用 'files' autoloading。通常作为函数库的载入方式（而非类库）
```
{
    "autoload" : {
        "files" : ["src/MyLibrary/function.php"]
    }
}
```

#### PSR-4 自动加载规范

此处的「类」泛指所有的「Class类」、「接口」、「traits 可复用代码块」以及其它类似结构。

一个完整的类名需具有以下结构:
\<命名空间>(\<子命名空间>)*\<类名>

- 完整的类名 必须 要有一个顶级命名空间，被称为 “vendor namespace”；
- 完整的类名 可以 有一个或多个子命名空间；
- 完整的类名 必须 有一个最终的类名；
- 完整的类名中任意一部分中的下滑线都是没有特殊含义的；
- 完整的类名 可以 由任意大小写字母组成；
- 所有类名都 必须 是大小写敏感的。
- 当根据完整的类名载入相应的文件
- 完整的类名中，去掉最前面的命名空间分隔符，前面连续的一个或多个命名空间和子命名空间，作为「命名空间前缀」，其必须与至少一个「文件基目录」相对应；
- 紧接命名空间前缀后的子命名空间 必须 与相应的「文件基目录」相匹配，其中的命名空间分隔符将作为目录分隔符。
- 末尾的类名 必须 与对应的以 .php 为后缀的文件同名。
- 自动加载器（autoloader）的实现 一定不可 抛出异常、一定不可 触发任一级别的错误信息以及 不应该 有返回值。

#### PSR-0自动加载规范
- 一个完整的命名空间或类必须拥有以下结构 \<Vendor Name>\(<Namespace>\)*<Class Name>
- 每一个命名空间必须有一个顶级的空间名(‘Vendor Name’)
- 每一个命名空间可以拥有多个子命名空间
- 从文件系统中加载时，命名空间中的分隔符（\）将被转化为文件分隔符
- 类名中的每一个_(下划线)将被转化为文件分隔符。命名空间中的_ 没有特殊含义
- 从文件系统中加载时，完整命名空间或类须以.php作为后缀名
- 开发商名、命名空间和类可以由大小写字母构成（区分大小写）