<?php
namespace Admin\Controller;
use Think\Controller;

class CommonController extends Controller {
    
	// 自动登录
	public function _initialize(){
        //判断用户是否已经登录
        if (!isset($_SESSION['admin'])) {
            $this->error('对不起,您还没有登录!请先登录', U('Index/login'), 1);
        }
    }
	
}