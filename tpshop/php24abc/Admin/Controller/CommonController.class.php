<?php
namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller {
	public function __construct(){
		parent::__construct();

		$action = array('index/login','index/code');
		
      $res = !in_array( strtolower( CONTROLLER_NAME.'/'.ACTION_NAME ), $action );
      if( $res  && session('is_login') != 1 ){
        $this->error( '您尚未登录！',U('Admin/index/login') );
      }
	}
}