<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/26 0026
 * Time: 上午 11:05
 */

namespace Pc\Controller;

use Think\Controller;

class CommonController extends Controller
{
    public function __construct(){
        parent::__construct();
        static $is_robot = null;
        if(null == $is_robot){
            $is_robot = false;
            $robotlist = 'bot|spider|crawl|nutch|lycos|robozilla|slurp|search|seek|archive';
            if( isset($_SERVER['HTTP_USER_AGENT']) && preg_match("/{$robotlist}/i", $_SERVER['HTTP_USER_AGENT']) ){
                $is_robot = true;
            }
        }

        if($is_robot){
            $this->display('Empty/404');
        }
    }

    public function _empty()
    {
        //可以自己处理，跳转到相应链接//
        $this->display('Empty/404');
    }
	
	public function _initialize(){//
        session_start();
        if(!isset($_SESSION['user'])){
			
            echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
            echo "<script> error('请您先登录',3500)</script>";
            echo "<script> window.location.href='".U('Login/login')."';</script>";
            exit();
        }else{
			$check=M('members')->where('user="'.$_SESSION['user'].'"')->find();
			if(empty($check)){
				session_start();
				session_unset();//free all session variable
				session_destroy();//销毁一个会话中的全部数据
				setcookie(session_name(),'',time()-3600);//销毁与客户端的卡号
				echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
				echo "<script> error('用户不存在',3500)</script>";
				echo "<script> window.location.href='".U('Login/login')."';</script>";
				exit();
			}else{
				$login_time=$check['login_time'];
				$dec_time=time()-$login_time;
				if($dec_time>30*60){
					session_start();
					session_unset();//free all session variable
					session_destroy();//销毁一个会话中的全部数据
					setcookie(session_name(),'',time()-3600);//销毁与客户端的卡号
					echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
					echo "<script> error('您长时间无动作，请重新登录',3500)</script>";
					echo "<script> window.location.href='".U('Login/login')."';</script>";
					exit();
				}
			}
		}
    }
}