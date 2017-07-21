<?php
  namespace Admin\Model;
  use Think\Model;
  class AuthModel extends Model{

    // 获取权限
    public function getAuth($where='auth_pid=0'){
      // auth_pid 为0的才是顶级权限
      return $this->where($where)->select();
    }
  }