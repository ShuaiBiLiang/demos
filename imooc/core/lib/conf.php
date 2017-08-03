<?php
namespace core\lib;

class conf
{
    static public $conf = array();
    static public function get($name,$file)
    {
        /**
         * 1.判断配置文件是否存在
         * 2.判断配置是否存在
         * 3.缓存配置
         */

        if( isset(self::$conf[$file]) )
        {
            return self::$conf[$file][$name];
        }else{
            $file = IMOOC.'/core/config/'.$file.'.php';
            if( is_file($file) )
            {
                $conf = include $file;
                if( isset($conf[$name]) )
                {
                    self::$conf[$file] = $conf;
                    return $conf[$name];
                }else{
                    throw new \Exception('找不到配置'.$file);
                }
            }else{
                throw new \Exception('找不到配置'.$file);
            }
        }
    }

    static public function all($file)
    {
        if( isset(self::$conf[$file]) )
        {
            return self::$conf[$file];
        }else{
            $path = IMOOC.'/core/config/'.$file.'.php';
            if( is_file($path) )
            {
                $conf = include $path;
                self::$conf[$path] = $conf;
                return $conf;
            }else{
                throw new \Exception('找不到配置'.$path);
            }
        }
    }
}