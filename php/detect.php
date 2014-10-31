<?php 
if (!isset($argv[1])) 
{
	die('请输入目标文件');
}elseif (!isset($argv[2])) 
{
	die('请输入源文件');
}elseif (!isset($argv[3])) 
{
	$argv[3] = 200000;//默认间隔时间为0.2秒
}
$fhr = @fopen($argv[2], 'r+') or die('文件打开失败或文件不存在');
$fhw = @fopen($argv[1], 'w+') or die('文件打开失败');

$time_start = microtime(true);
while ($line = fgets($fhr)) 
{
	$line = trim($line);
	$arr = explode("\t", $line);
	if (!isset($arr[2])) 
	{
		continue;
	}
	$site = trim($arr[2]);
	usleep($argv[3]);
	$baidu = @file_get_contents("http://www.baidu.com/s?wd={$site}&ie=utf-8");
	$flag = 'no';
	if ($baidu === false) 
	{
		$flag = 'failed';
		if(fputs($fhw,"{$line}\t{$flag}".PHP_EOL) === false)
		{
			echo $site.'写入失败'.PHP_EOL;
		}else
		{
			echo $site.'检测成功'.PHP_EOL;
		}
	}else
	{
		if (strpos($baidu, '百度为您找到相关结果') !== false) 
		{
			if (strpos($baidu, '没有找到该URL') === false) 
			{
				$flag = 'yes';
			}
		}
		if (strpos($baidu, '请输入以下验证码') !== false) 
		{
			$flag = 'verify';
		}
		if(fputs($fhw,"{$line}\t{$flag}".PHP_EOL) === false)
		{
			echo $site.'写入失败'.PHP_EOL;
		}else
		{
			echo $site.'检测成功'.PHP_EOL;
		}
	}
}
$time_end = microtime(true);
$time = round($time_end - $time_start,1);
echo $time."\n";
echo '内存使用:'.round(memory_get_usage()/1024).'KB';
fclose($fhr);
fclose($fhw);
 ?>
