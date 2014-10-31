<?php
/*
 * 日志实体类
 * @author zhangjingwei
 * @usage Util_Log::log($msg,$filename)
 * @usage Util_Log::write($data,$filename,$extension,$flag)
 * @time 2014-10-31
 */
class Util_Log{
    
    /*
     * 打log辅助函数,log文件目录在temp/logs/下
     * @param string log主体信息
     * @param string log文件名,默认Y-m-d格式
     *
     * @return NULL
     */
    public static function log($msg='',$filename=NULL){
        if(empty($filename)){
            $filename = date('Y-m-d');
        }
        $filename =Framework::getSystemPath('temp').'/logs/'.$filename.'.log';
        if(! is_file($filename)){
            touch($filename);
            chmod($filename,0644);
        }
        file_put_contents($filename,date('Y-m-d H:i:s')."|$msg".PHP_EOL,FILE_APPEND);
    }

    /*
     * 写文件辅助函数,文件目录在temp/下
     * @param string 文件内容
     * @param string 文件名,默认Y-m-d格式
     * @param string 文件扩展名,默认无
     * @param bool 默认直接覆盖,不追加
     *
     * @return NULL
     */
    public static function write($data='',$filename=NULL,$extension=NULL,$flag=false){
        if(is_null($filename)){
            $filename = date('Y-m-d');
        }
        if(! is_null($extension)){
            $filename .= '.'.$extension;
        }
        $filename = Framework::getSystemPath('temp').'/'.$filename;
        if(! is_file($filename)){
            touch($filename);
            chmod($filename,0644);
        }
        if($flag === true){
            $flag = FILE_APPEND;
        }else{
            $flag = 0;
        }
        file_put_contents($filename,$data,$flag);
    }

}
