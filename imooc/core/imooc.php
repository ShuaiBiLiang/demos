<?php
namespace core;

class imooc
{
    public static $classMap = array();
    public $assign;

    static public function run()
    {
        \core\lib\log::init();
        $route = new \core\lib\route();
        $ctrlClass = $route->ctrl;
        $action = $route->action;

        $ctrlfile = APP.'/ctrl/'.$ctrlClass.'Ctrl.php';
        $cltrClass = '\\' .MODULE . '\ctrl\\'.$ctrlClass.'Ctrl';

        if( is_file($ctrlfile) )
        {
            include $ctrlfile;
            $ctrl = new $cltrClass();
            $ctrl->$action();

            \core\lib\log::log('ctrl:'.$ctrlClass.'     '.'action:'.$action);

        }else{
            throw new \Exception('not found this '.$ctrlClass);
        }
    }

    static public function load($class)
    {
        $class = str_replace('\\','/',$class);
        if( isset($classMap[$class]) )
        {
            return true;
        }else{
            $class = str_replace('\\','/',$class);
            $file = IMOOC.'/'.$class.'.php';
            if( is_file($file) )
            {
                include $file;
                self::$classMap[$class] = $class;
            }else{
                return false;
            }
        }
    }

    public function assign($name, $value)
    {
        $this->assign[$name] = $value;
    }

    public function display($file)
    {
        $file = APP.'/views/'.$file;
        if( is_file($file) )
        {
            \Twig_Autoloader::register();
            $loader = new \Twig_Loader_Filesystem(APP.'/views');
            $twig = new \Twig_Environment($loader, array(
                 'cache' => IMOOC.'/log/twig/',
                 'debug' => DEBUG
            ));
            $template = $twig->loadTemplate('index.html');
            $template->display($this->assign?$this->assign:'');
        }
    }
}