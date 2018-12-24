<?php
/**
 * Created by PhpStorm.
 * User: demorzhao
 * Date: 2018/10/14
 * Time: 上午10:53
 */

function sort_with_keyName($arr,$orderby='desc'){
    $new_array = array();
    $new_sort = array();
    foreach($arr as $key => $value){
        $new_array[] = $value;
    }
    if($orderby=='asc'){
        asort($new_array);
    }else{
        arsort($new_array);
    }
    foreach($new_array as $k => $v){
        foreach($arr as $key => $value){
            if($v==$value){
                $new_sort[$key] = $value;
                unset($arr[$key]);
                break;
            }
        }
    }
    return $new_sort;
}
// 排序算法
$list = [];

for($i = 0; $i < 10000; $i ++) {
    $array[] = rand(1, 100000);
}

$start = microtime();
sort($array);
$end = microtime();
$list['sort'] = floatval($end - $start);
echo 'sort函数:' . floatval($end - $start) . PHP_EOL;
$count = count($array);
// 冒泡算法
$start = microtime();
for($i = 0; $i < $count; $i ++) {
    for ($j = 0; $j < $i + 1; $j ++) {
        if ($array[$i] < $array[$j]) {
            $tmp = $array[$j];
            $array[$j] = $array[$i];
            $array[$i] = $tmp;
        }
    }
}
$end = microtime();
$list['m1'] = floatval($end - $start);
echo '冒泡第三方变量交换: ' . floatval($end - $start) . PHP_EOL;
// 效率最高
$start = microtime();
for($i = 0; $i < $count; $i ++) {
    for ($j = 0; $j < $i + 1; $j ++) {
        if ($array[$i] < $array[$j]) {
            $array[$i] = $array[$i] + $array[$j];
            $array[$j] = $array[$i] - $array[$j];
            $array[$i] = $array[$i] - $array[$j];
        }
    }
}
$end = microtime();
$list['m2'] = floatval($end - $start);
echo '冒泡无第三方参数交换:' . floatval($end - $start) . PHP_EOL;
// 效率最差
$start = microtime();
for($i = 0; $i < $count; $i ++) {
    for ($j = 0; $j < $i + 1; $j ++) {
        list($array[$i], $array[$j]) = ($array[$i] < $array[$j]) ? [$array[$j], $array[$i]] : [$array[$i], $array[$j]];

    }
}
$end = microtime();
$list['m3'] = floatval($end - $start);
echo '冒泡list交换： ' . floatval($end - $start) . PHP_EOL;

// 选择排序
$start = microtime();
$min = 0;
$k   = [];
for($i = 0; $i < $count; $i ++) {
    $min = $array[$i];
    for($j = $i + 1; $j < $count; $j ++) {
        if ($array[$j] < $min) {
            $min = $array[$j];
        }
    }
    $k[] = $min;
}
$end = microtime();
$list['choice'] = floatval($end - $start);
echo '选择排序：' . floatval($end - $start) . PHP_EOL;

// 插入排序
$start = microtime();
for ($i =1; $i < $count; $i ++) {
    if ($array[$i] < $array[$i - 1]) {
        $tmp = $array[$i];
       for($j = $i; $array[$j - 1] > $tmp; $j --) {
           $array[$j] = $array[$j - 1];
       }
       $array[$j] = $tmp;
    }
}
$end = microtime();
$list['insert'] = floatval($end - $start);
echo '插入排序：' . floatval($end - $start) . PHP_EOL;
var_dump(sort_with_keyName($list));