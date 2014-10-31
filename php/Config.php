<?php
/*
 * 获取常量配置类
 * @author zhangjingwei
 * @time 2014-10-31
 * @usage Util_Config::config('constants.key')
 */
class Util_Config{
    /*
     * 单例的配置文件数组
     */
    private static $_configuration; 
    
    private function __construct(){
        
    }
    /*
     * @keys:由文件名和常量数组的键组成的字符串constants.key
     * @path:默认在temp下
     */
    public static function config($keys,$path='temp'){
        $group = explode('.', $keys,2);
        if (count($group) < 2)
            return NULL;
        $file = $group[0];
        $key = $group[1];
        if (!isset(self::$_configuration[$file])){
            require ($path.'/config/'.$file.'.php');
            if (isset($config) && is_array($config)){
                self::$_configuration[$file] = $config;
            }
        }
        return isset(self::$_configuration[$file][$key]) ? self::$_configuration[$file][$key] : NULL;
    }

}
