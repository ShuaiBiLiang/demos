<?php
  namespace Admin\Model;
  use Think\Model;
  class AdminModel extends Model{
    protected $_auto = array(
      array('password','mypassword',3,'callback'),
    );

    // 密码的加密
    protected function mypassword( $data ){
      return password($data, $_POST['salt'] );
    }

  }