<?php
namespace app\ctrl;
use core\lib\model;

class indexCtrl extends \core\imooc
{
    public function index()
    {
     $model = new \app\model\cModel();
     $data = array(
         'name'=>'Test',
         'passwd'=>"abc"
     );
     $ret = $model->delOne(6);
     dump($ret);
    }
}