<?php
/*
 * Memcache实体类
 * @author zhangjingwei
 * @time 2014-10-31
 * @usage Util_MemCache::instance()获得单例的memcache对象
 *
 */
class Util_MemCache{
    /*
     * 单例的memcache对象
     */
    private static $_memcache = NULL; 
    
    private function __construct(){
        
    }
    public static function getMemcache(){
        if( ! extension_loaded('memcache') ){
            Util_log::log('type=error|msg=系统缺少memcache扩展|file='.__FILE__.'|line='.__LINE__.'|uri='.$_SERVER['REQUEST_URI']);
        }
        $mem = new Memcache;
        $servers = self::getServers();
        if( ! $servers ){
            Util_log::log('type=error|msg=web.xml缺少memcache server配置|file='.__FILE__.'|line='.__LINE__.'|uri='.$_SERVER['REQUEST_URI']);
        }
        foreach($servers as $server){
            if( ! $mem->addServer($server['host'], $server['port'], $server['persistent'], $server['weight'])){
                Util_log::log("type=error|msg=memcache{$server['host']}:{$server['port']}连接失败|file=".__FILE__.'|line='.__LINE__.'|uri='.$_SERVER['REQUEST_URI']);
            }
        }
        return $mem;
    }
    /*
     * 获得单例的memcache对象
     */
    public static function instance(){
        if( is_null(self::$_memcache) ){
            self::$_memcache = self::getMemcache();
        }
        return self::$_memcache;
    }

    public static function getServers(){
        $memcache_servers = Frameworks::getConfigParam('memcache_servers');
        $arr = array_values(array_filter(explode(';',$memcache_servers)));
        $servers = array();
        foreach($arr as $v){
            $item = array_values(array_filter(explode(':',$v)));
            $server['host'] = isset($item[0]) ? $item[0] : 'localhost';
            $server['port'] = isset($item[1]) ? $item[1] : 11211;
            $server['persistent'] = isset($item[2]) ? $item[2] : FALSE;
            $server['weight'] = isset($item[3]) ? $item[3] : 1;
            $servers[] = $server;
        }
        return $servers;
    }

}
