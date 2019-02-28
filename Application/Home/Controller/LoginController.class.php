<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/26 0026
 * Time: 上午 11:30
 */

namespace Home\Controller;
use Think\Controller;
use Think\Account;
use Think\Verify;
use Think\Smsapi;
class LoginController extends Controller
{
    public function login(){
        if(IS_AJAX){
//            cookie('user',null);
//            cookie(null);
//            cookie('user', "11111", time()+3600*24*30);
           // print_r($_COOKIE);
//            die;
//print_r($_POST);
            $data['user']=_safe(I('post.user'));
            $remember=_safe(I('post.remember'));
            $remember_p=_safe(I('post.remember_p'));
            $data['password']=_safe(I('post.password'));
            $account=new Account($data);
            $res=$account->login();
            //echo $res;die;
            if( $res == 'success' ){
                $save['login_time']=time();
                M('members')->where('user=%s',array($data['user']))->save($save);
                //session_start();
                switch ($remember){
                    case '1':
                        cookie('user',null);
                        //cookie('password',null);
//                        print_r($data);die;
                        cookie('user', $data['user'], time()+3600*24*30);
                        //cookie('password', $data['password'], time()+3600*24*30);
                        //echo $_COOKIE['user'];die;
                        break;
                    case '0':
                        //echo 111;
//                        echo 222;
                        cookie('user',null);
						//cookie('password',null);
//                        print_r($_COOKIE);
                        break;
                }
				switch ($remember_p){
                    case '1':
                        //cookie('user',null);
                        cookie('password',null);
//                        print_r($data);die;
                        //cookie('user', $data['user'], time()+3600*24*30);
                        cookie('password', $data['password'], time()+3600*24*30);
                        //echo $_COOKIE['user'];die;
                        break;
                    case '0':
                        //echo 111;
//                        echo 222;
                        //cookie('user',null);
						cookie('password',null);
//                        print_r($_COOKIE);
                        break;
                }
				//print_r($_COOKIE);die;
                $datas['msg']='登录成功';
                $datas['state']=1;
            }elseif( $res == 'titles' ){
                $datas['msg']='您已被封号';
                $datas['state']=-1;
            }else{
                //echo $res;die;
                $datas['msg']='账号或密码错误';
                $datas['state']=0;
            }
            $datas=json_encode($datas);
            echo $datas;
            exit;
        }else{
//        unset($_COOKIE['user']);
			//echo $_COOKIE['user'];
            if(!empty($_COOKIE['user'])){
				//echo 1;
                $this->assign('cookiees',$_COOKIE['user']);
            }
			if(!empty($_COOKIE['password'])){
				//echo 1;
                $this->assign('cookiees_p',$_COOKIE['password']);
            }
//            echo $_COOKIE['user'];die;
			$conf=M('system_conf')->where('name="personal_regist"')->find();
			if($conf['value']==1){
				$state=1;
			}else{
				$state=0;
			}
			$this->assign('state',$state);
            $this->display();
        }
    }

    public function forget(){
        if(IS_AJAX){
			$yzm=_safe(I('post.yzm'));
			if($_SESSION['find_code']!=$yzm){
				$datas['msg']='验证码错误';
				$datas['state']=0;
			}
            //print_r($_POST);die;
            $data['user']=_safe(I('post.user'));
            $data['password']=_safe(I('post.password'));
            //echo $data['user'];
            $check=M('members')->where('user="'.$data['user'].'"')->find();
            //echo M('members')->getLastSql();die;
            if(!empty($check)){
                $key = 'IH^&*%545qg'.$data['user'];
                $data['password'] = access_md16( $data['password'] , $key );
                //print_r($data);die;
                if(M('members')->where('user="'.$data['user'].'"')->save($data) !==false){
                    $datas['msg']='修改成功';
                    $datas['state']=1;
                }else{
                    $datas['msg']='信息错误';
                    $datas['state']=0;
                }
            }else{
                $datas['msg']='账号不存在';
                $datas['state']=-1;
            }
            $datas=json_encode($datas);
            echo $datas;
            exit;
        }else{
            $this->display();
        }
    }

    public function regist(){
        if(IS_POST){
            //echo 111;die;

			
            $data['password']=_safe(I('post.password'));
            $data['trade_password']=_safe(I('post.trade_password'));
            $code=I('post.verify');
//            echo $code;die;
            $verify = new \Think\Verify();
            if($res = $verify->check($code)==false){
                $datas['msg']= '验证码错误';
                $datas['state']=2;
                $datas=json_encode($datas);
                echo $datas;//
                exit;
            }
            $data['user']=_safe(I('post.user'));
            $data['name']=_safe(I('post.name'));
            //$data['bank_name']=_safe(I('post.bank_name'));
            //$data['bank_adress']=_safe(I('post.bank_adress'));
            //$data['bank_number']=_safe(I('post.bank_number'));
            $data['referrer']=_safe(I('post.referrer'));
            $data['state']= 0;
            $account = new Account($data);
            if( $account->regist() == 'success'){
                $datas['msg']='注册成功';
                $datas['state']=1;
            }elseif( $account->regist() == 'already'){
                $datas['msg']= '账号已注册';
                $datas['state']=0;
            }else{
                $datas['msg']= '注册超时';
                $datas['state']=-1;
            }
            $datas=json_encode($datas);
            echo $datas;
            exit;
        }else{
			//echo phpinfo();die;
			//print_r($_SERVER['HTTP_REFERER']);die;
			$conf=M('system_conf')->where('name="personal_regist"')->find();
			
			$model=explode('/',$_SERVER['HTTP_REFERER']);
			//print_r($model[count($model)-1]);die;
			if($model[count($model)-1]!='per_center'){
				$url=U('Login/login');
				$name='返回登录页面';
				if($conf['value']==0){
					$this->redirect('Login/login');
				}
			}else{///
				$num=_safe(I('get.num'));
				$this->assign('num',$num);
				$url=U('User/per_center');
				$name='返回用户中心';
			}
			$this->assign('url',$url);
			$this->assign('name',$name);
			//echo 33;
			//print_r($num);die;
			$referrer=_safe(I('get.referrer'));
			$this->assign('referrer',$num);
            $this->display();
        }
    }
	
	public function login_out(){
		if(IS_AJAX){
			session_start();
			session_unset();//free all session variable
			session_destroy();//销毁一个会话中的全部数据
			setcookie(session_name(),'',time()-3600);//销毁与客户端的卡号
			echo 1;
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
	
    public function verify(){

         $Verify = new Verify();
         $Verify->entry();
    }
}