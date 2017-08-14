<?php
namespace app\ctrl;
use core\lib\model;

class indexCtrl extends \core\imooc
{
    public function index()
    {
     $this->assign('','');
     $this->display('index.html');
    }

    public function add()
    {
        $this->assign('','');
        $this->display('add.html');
    }

    public function save()
    {

    }
}