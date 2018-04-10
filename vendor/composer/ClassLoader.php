<?php

/*
 * This file is part of Composer.
 *
 * (c) Nils Adermann <naderman@naderman.de>
 *     Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Composer\Autoload;

/**
 * ClassLoader implements a PSR-0, PSR-4 and classmap class loader.
 *
 *     $loader = new \Composer\Autoload\ClassLoader();
 *
 *     // register classes with namespaces
 *     $loader->add('Symfony\Component', __DIR__.'/component');
 *     $loader->add('Symfony',           __DIR__.'/framework');
 *
 *     // activate the autoloader
 *     $loader->register();
 *
 *     // to enable searching the include path (eg. for PEAR packages)
 *     $loader->setUseIncludePath(true);
 *
 * In this example, if you try to use a class in the Symfony\Component
 * namespace or one of its children (Symfony\Component\Console for instance),
 * the autoloader will first look for the class under the component/
 * directory, and it will then fallback to the framework/ directory if not
 * found before giving up.
 *
 * This class is loosely based on the Symfony UniversalClassLoader.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Jordi Boggiano <j.boggiano@seld.be>
 * @see    http://www.php-fig.org/psr/psr-0/
 * @see    http://www.php-fig.org/psr/psr-4/
 */
class ClassLoader
{
    // PSR-4
    private $prefixLengthsPsr4 = array();
    private $prefixDirsPsr4 = array();
    private $fallbackDirsPsr4 = array();

    // PSR-0
    private $prefixesPsr0 = array();
    private $fallbackDirsPsr0 = array();

    private $useIncludePath = false;
    private $classMap = array();
    private $classMapAuthoritative = false;
    private $missingClasses = array();
    private $apcuPrefix;

    //获取psr0规范前缀
    public function getPrefixes()
    {
        if (!empty($this->prefixesPsr0)) {
            return call_user_func_array('array_merge', $this->prefixesPsr0);
        }

        return array();
    }
    //获取psr4规范前缀
    public function getPrefixesPsr4()
    {
        return $this->prefixDirsPsr4;
    }
    //获取psr0规范路径
    public function getFallbackDirs()
    {
        return $this->fallbackDirsPsr0;
    }
    //获取psr4规范路径
    public function getFallbackDirsPsr4()
    {
        return $this->fallbackDirsPsr4;
    }
    //获取类map
    public function getClassMap()
    {
        return $this->classMap;
    }

    /**
     * 设置私有类名映射
     * @param array $classMap Class to filename map
     */
    public function addClassMap(array $classMap)
    {
        if ($this->classMap) {
            $this->classMap = array_merge($this->classMap, $classMap);
        } else {
            $this->classMap = $classMap;
        }
    }

    /**
     * Registers a set of PSR-0 directories for a given prefix, either
     * appending or prepending to the ones previously set for this prefix.
     * 为一个给定的前缀注册一组PSR-0目录，并且追加和预先设置为前缀的前缀
     * @param string       $prefix  The prefix
     * @param array|string $paths   The PSR-0 root directories
     * @param bool         $prepend Whether to prepend the directories
     */
    public function add($prefix, $paths, $prepend = false)
    {
        if (!$prefix) {
            if ($prepend) {
                //如果$prefix为空且$prepend为true，添加psr0规范文件回调路径，旧的覆盖新的
                $this->fallbackDirsPsr0 = array_merge(
                    (array) $paths,
                    $this->fallbackDirsPsr0
                );
            } else {
                //如果$prefix为空且$prepend为false，添加psr0规范文件回调路径，新的覆盖旧的
                $this->fallbackDirsPsr0 = array_merge(
                    $this->fallbackDirsPsr0,
                    (array) $paths
                );
            }

            return;
        }
        //有前缀
        $first = $prefix[0];
        if (!isset($this->prefixesPsr0[$first][$prefix])) {
            //设置psr0规范文件前缀
            $this->prefixesPsr0[$first][$prefix] = (array) $paths;

            return;
        }
        if ($prepend) {
            //如果$prepend为true，旧的psr0规范文件前缀覆盖新的
            $this->prefixesPsr0[$first][$prefix] = array_merge(
                (array) $paths,
                $this->prefixesPsr0[$first][$prefix]
            );
        } else {
            //如果$prepend为false，新的psr0规范文件覆盖旧的
            $this->prefixesPsr0[$first][$prefix] = array_merge(
                $this->prefixesPsr0[$first][$prefix],
                (array) $paths
            );
        }
    }

    /**
     * Registers a set of PSR-4 directories for a given namespace, either
     * appending or prepending to the ones previously set for this namespace.
     *
     * @param string       $prefix  The prefix/namespace, with trailing '\\'
     * @param array|string $paths   The PSR-4 base directories
     * @param bool         $prepend Whether to prepend the directories
     *
     * @throws \InvalidArgumentException
     */
    public function addPsr4($prefix, $paths, $prepend = false)
    {
        if (!$prefix) {
            // Register directories for the root namespace.
            //为根命名空间注册路径
            if ($prepend) {
                //如果$prefix为空且$prepend为true添加psr4规范文件回调路径，$this->fallbackDirsPsr4覆盖$paths
                $this->fallbackDirsPsr4 = array_merge(
                    (array) $paths,
                    $this->fallbackDirsPsr4
                );
            } else {
                //如果$prefix为空且$prepend为true添加psr4规范文件回调路径，新的覆盖新的
                $this->fallbackDirsPsr4 = array_merge(
                    $this->fallbackDirsPsr4,
                    (array) $paths
                );
            }
        } elseif (!isset($this->prefixDirsPsr4[$prefix])) {
            // Register directories for a new namespace.
            //如果尚未设置该psr4规范
            //为新命名空间注册路径

            //获取前缀长度
            $length = strlen($prefix);
            if ('\\' !== $prefix[$length - 1]) {
                //如果前缀不是以\结束，抛出错误
                throw new \InvalidArgumentException("A non-empty PSR-4 prefix must end with a namespace separator.");
            }
            //获取psr4规范前缀长度
            $this->prefixLengthsPsr4[$prefix[0]][$prefix] = $length;
            //获取psr4规范前缀路径
            $this->prefixDirsPsr4[$prefix] = (array) $paths;
        } elseif ($prepend) {
            //如果已经设置了psr4规范
            // Prepend directories for an already registered namespace.
            //为已经注册的命名空间预加载路径prefixDirsPsr4[$prefix]覆盖$paths
            $this->prefixDirsPsr4[$prefix] = array_merge(
                (array) $paths,
                $this->prefixDirsPsr4[$prefix]
            );
        } else {
            // Append directories for an already registered namespace.
            //为已经注册的命名空间追加一个路径
            $this->prefixDirsPsr4[$prefix] = array_merge(
                $this->prefixDirsPsr4[$prefix],
                (array) $paths
            );
        }
    }

    /**
     * Registers a set of PSR-0 directories for a given prefix,
     * replacing any others previously set for this prefix.
     *
     * @param string       $prefix The prefix
     * @param array|string $paths  The PSR-0 base directories
     */
    public function set($prefix, $paths)
    {
        if (!$prefix) {
            $this->fallbackDirsPsr0 = (array) $paths;
        } else {
            $this->prefixesPsr0[$prefix[0]][$prefix] = (array) $paths;
        }
    }

    /**
     * Registers a set of PSR-4 directories for a given namespace,
     * replacing any others previously set for this namespace.
     *
     * @param string       $prefix The prefix/namespace, with trailing '\\'
     * @param array|string $paths  The PSR-4 base directories
     *
     * @throws \InvalidArgumentException
     */
    public function setPsr4($prefix, $paths)
    {
        if (!$prefix) {
            $this->fallbackDirsPsr4 = (array) $paths;
        } else {
            $length = strlen($prefix);
            if ('\\' !== $prefix[$length - 1]) {
                throw new \InvalidArgumentException("A non-empty PSR-4 prefix must end with a namespace separator.");
            }
            $this->prefixLengthsPsr4[$prefix[0]][$prefix] = $length;
            $this->prefixDirsPsr4[$prefix] = (array) $paths;
        }
    }

    /**
     * Turns on searching the include path for class files.
     *
     * @param bool $useIncludePath
     */
    public function setUseIncludePath($useIncludePath)
    {
        $this->useIncludePath = $useIncludePath;
    }

    /**
     * Can be used to check if the autoloader uses the include path to check
     * for classes.
     *
     * @return bool
     */
    public function getUseIncludePath()
    {
        return $this->useIncludePath;
    }

    /**
     * Turns off searching the prefix and fallback directories for classes
     * that have not been registered with the class map.
     *
     * @param bool $classMapAuthoritative
     */
    public function setClassMapAuthoritative($classMapAuthoritative)
    {
        $this->classMapAuthoritative = $classMapAuthoritative;
    }

    /**
     * Should class lookup fail if not found in the current class map?
     *
     * @return bool
     */
    public function isClassMapAuthoritative()
    {
        return $this->classMapAuthoritative;
    }

    /**
     * APCu prefix to use to cache found/not-found classes, if the extension is enabled.
     *
     * @param string|null $apcuPrefix
     */
    public function setApcuPrefix($apcuPrefix)
    {
        $this->apcuPrefix = function_exists('apcu_fetch') && ini_get('apc.enabled') ? $apcuPrefix : null;
    }

    /**
     * The APCu prefix in use, or null if APCu caching is not enabled.
     *
     * @return string|null
     */
    public function getApcuPrefix()
    {
        return $this->apcuPrefix;
    }

    /**
     * Registers this instance as an autoloader.
     *
     * @param bool $prepend Whether to prepend the autoloader or not
     */
    public function register($prepend = false)
    {
        spl_autoload_register(array($this, 'loadClass'), true, $prepend);
    }

    /**
     * Unregisters this instance as an autoloader.
     */
    public function unregister()
    {
        spl_autoload_unregister(array($this, 'loadClass'));
    }

    /**
     * Loads the given class or interface.
     *
     * @param  string    $class The name of the class
     * @return bool|null True if loaded, null otherwise
     */
    public function loadClass($class)
    {
        if ($file = $this->findFile($class)) {
            includeFile($file);

            return true;
        }
    }

    /**
     * Finds the path to the file where the class is defined.
     *
     * @param string $class The name of the class
     *
     * @return string|false The path if found, false otherwise
     */
    public function findFile($class)
    {
        // class map lookup查找类，找到返回路径
        if (isset($this->classMap[$class])) {
            return $this->classMap[$class];
        }
        //判断该类是否已经注册或者已经设置指定类为忽略类，如果是，返回false
        if ($this->classMapAuthoritative || isset($this->missingClasses[$class])) {
            return false;
        }
        //如果指定类的apcu前缀不为空
        if (null !== $this->apcuPrefix) {
            //对比指定类的apcu前缀和apcu缓存中的类的前缀，返回$hit success或者false
            $file = apcu_fetch($this->apcuPrefix.$class, $hit);
            //如果一致，返回该文件
            if ($hit) {
                return $file;
            }
        }
        //寻找指定类扩展的类
        $file = $this->findFileWithExtension($class, '.php');

        // Search for Hack files if we are running on HHVM
        //如果没有找打该文件并且在HHVM引擎上
        if (false === $file && defined('HHVM_VERSION')) {
            //寻找以hh结尾的文件
            $file = $this->findFileWithExtension($class, '.hh');
        }
        //如果指定类apcu前缀不为空
        if (null !== $this->apcuPrefix) {
            //apcu缓存添加指定变量(指定类apcu前缀+指定类名)为指定类扩展
            apcu_add($this->apcuPrefix.$class, $file);
        }
        //如果没有文件
        if (false === $file) {
            // Remember that this class does not exist.
            //记录下来，这个类不存在
            $this->missingClasses[$class] = true;
        }

        return $file;
    }

    private function findFileWithExtension($class, $ext)
    {
        // PSR-4 lookup
        // 替换\为/
        $logicalPathPsr4 = strtr($class, '\\', DIRECTORY_SEPARATOR) . $ext;
        //找到类前缀
        $first = $class[0];
        //判断是不是符合psr4规范的类
        if (isset($this->prefixLengthsPsr4[$first])) {
            //获取类路径
            $subPath = $class;
            //当渠道有\的类路径
            while (false !== $lastPos = strrpos($subPath, '\\')) {
                //提取\前的字符串
                $subPath = substr($subPath, 0, $lastPos);
                //添加\\
                $search = $subPath.'\\';
                //判断是否已经注册类命名空间
                if (isset($this->prefixDirsPsr4[$search])) {

                    $pathEnd = DIRECTORY_SEPARATOR . substr($logicalPathPsr4, $lastPos + 1);
                    foreach ($this->prefixDirsPsr4[$search] as $dir) {
                        //循环查找，找到就返回
                        if (file_exists($file = $dir . $pathEnd)) {
                            return $file;
                        }
                    }
                }
            }
        }

        // PSR-4 fallback dirs
        foreach ($this->fallbackDirsPsr4 as $dir) {
            if (file_exists($file = $dir . DIRECTORY_SEPARATOR . $logicalPathPsr4)) {
                return $file;
            }
        }

        // PSR-0 lookup
        if (false !== $pos = strrpos($class, '\\')) {
            // namespaced class name
            $logicalPathPsr0 = substr($logicalPathPsr4, 0, $pos + 1)
                . strtr(substr($logicalPathPsr4, $pos + 1), '_', DIRECTORY_SEPARATOR);
        } else {
            // PEAR-like class name
            $logicalPathPsr0 = strtr($class, '_', DIRECTORY_SEPARATOR) . $ext;
        }

        if (isset($this->prefixesPsr0[$first])) {
            foreach ($this->prefixesPsr0[$first] as $prefix => $dirs) {
                if (0 === strpos($class, $prefix)) {
                    foreach ($dirs as $dir) {
                        if (file_exists($file = $dir . DIRECTORY_SEPARATOR . $logicalPathPsr0)) {
                            return $file;
                        }
                    }
                }
            }
        }

        // PSR-0 fallback dirs
        foreach ($this->fallbackDirsPsr0 as $dir) {
            if (file_exists($file = $dir . DIRECTORY_SEPARATOR . $logicalPathPsr0)) {
                return $file;
            }
        }

        // PSR-0 include paths.
        if ($this->useIncludePath && $file = stream_resolve_include_path($logicalPathPsr0)) {
            return $file;
        }

        return false;
    }
}

/**
 * Scope isolated include.
 *
 * Prevents access to $this/self from included files.
 */
function includeFile($file)
{
    include $file;
}
