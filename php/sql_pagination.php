<?php
//A数据库
/*
$db_config = array(
            'host'=>"",
            'user'=>"",
            'pass'=>"",
            'db'=>"",
        );
*/
//B数据库
/*
$db_config = array(
            'host'=>"",
            'user'=>"",
            'pass'=>"",
            'db'=>"",
        );
*/
//分页大小
const PAGE_SIZE = 1000;
$con = mysql_connect($db_config['host'],$db_config['user'],$db_config['pass']);
if(!$con){
    die('Could not connect: ' . mysql_error());
}
mysql_select_db($db_config['db'],$con);
mysql_query("set names utf8");
$result = mysql_query('select count(*) from videos');
if(!$result){
    die('Invalid query: ' . mysql_error());
}
$allnumbers = array_shift(mysql_fetch_row($result));
$pages = ceil($allnumbers/PAGE_SIZE);
for($page=1;$page<=$pages;$page++){
    $m = ($page-1)*PAGE_SIZE;
    $n = PAGE_SIZE;
    $result = mysql_query("select * from videos limit {$m},{$n}");
    if(!$result){
        die('Invalid query: ' . mysql_error());
    }
    while($row = mysql_fetch_assoc($result)){
        $id = $row['id'];
        if($infolink == ''){
            $infolink = $row['infolink'];
            $infolinkmd5 = md5($row['infolink']);
        }
        $result = mysql_query("update videos set infolink = '{$infolink}',infolinkmd5 = '{$infolinkmd5}'  where id = {$id}");
        if(!$result){
            die('Invalid query: ' . mysql_error());
        }
    }
}
mysql_close();
?>
