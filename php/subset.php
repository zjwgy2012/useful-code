<?php

$input = array('a','b','c');
getAllSubsets($input);
/**
 * 打印n个元素的集合的子集
 * 一个有n个元素的集合的子集和一个n位的二进制数有一一对应的关系
 * */
function getAllSubsets($input){
    $n = count($input);
    //初始化
    for($i=0; $i < $n ;$i++){
        $set[$i] = 0;
    }
    while(1){
        for($i=0; $i<$n && $set[$i]==1; $set[$i]=0,$i++);
        if($i == $n){
            break;
        }else{
            $set[$i] = 1;
        }
        $output = array();
        for($i=0; $i < $n; $i++){
            if($set[$i] == 1){
                $output[] = $input[$i];
            }
        }
        echo '{' . implode(',' , $output) . '}';
    }
}
