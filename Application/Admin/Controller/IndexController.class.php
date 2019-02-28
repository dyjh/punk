<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Smsapi;
class IndexController extends Controller {
	
	public function login(){
		$this->display('index');
	}
	
    public function index(){
		if(IS_POST){
			$yzm=_safe(I('post.yzm'));
			/*if($_SESSION['admin_code']!=$yzm){
				$this->error('验证码错误',U('Admin/index'));
			}*/
			$data['admin']=_safe(I('post.user'));
            $data['password']=_safe(I('post.password'));
			$key = 'IH^&*%56&ll'.$data['admin'];
			$data['password'] = access_md16( $data['password'] , $key );		
			$check=M('admin')->where('admin="'.$data['admin'].'"')->find();
            if($check['password']==$data['password']){
				session('admin',$check);
                $this->success('登陆成功',U('Admin/index'));
            }else{
                $this->error('信息错误',U('Index/index'));
            }
			
		}else{
			$this->display();
		}
	}
	
	public function yzm(){
		if(IS_AJAX){
			
			//echo 111;die;
			$tel=_safe(I('post.tel'));
			$type=_safe(I('post.type'));
			//echo $type;die;
			$sms=new Smsapi();
			$sms->produce_verification_code($tel,$type);
		}
	}
	
	
	
	/*退出*/
	public function logout(){
		session('admin', null);
        $this->success('退出成功！', U('Index/login'));
        exit;
	}
}