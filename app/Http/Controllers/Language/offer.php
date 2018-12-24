<?php
/**
 * Created by PhpStorm.
 * User: demorzhao
 * Date: 2018/10/18
 * Time: 下午8:59
 */
/*
面试3 二位数组的查找
在一个二位数组中
每一行都按照从做到右递增的顺序排序
每一列都按照从上到下递增的顺序排序
请完成一个二维数组和一个整数
判断数组中是否含有该整数

1 2 8  9
2 4 9  12
4 7 10 13
6 8 11 15

解题思路：
比如我们要找到7从数组右上角的9开始对比，如果 右上角的数字大于要找的数字，就把右上角这一列去掉
然后找到了以2为右上角的列，2 < 7 现在开始分析行
因为列是递减的，所以把2所在的行剔除，找到了4
4 < 7 把4所在的行剔除 找到了7
*/

function find($arr, $rows, $columns, $num)
{
    $found = false;
    if (is_array($arr) && $rows > 0 && $columns > 0) {
        $row = 0;
        $column = $columns - 1;
        while ($row < $rows && $column > 0) {
            if ($arr[$rows][$column] == $num) {
                $found = true;
            } elseif ($arr[$rows[$column]] > $num) {
                $column --;
            } else {
                $row ++;
            }
        }
    }
    return $found;
}

function step($n)
{
    if (is_numeric($n) == false) {
        return false;
    }
    return ($n * ($n - 1)) / 2 + 1;
}