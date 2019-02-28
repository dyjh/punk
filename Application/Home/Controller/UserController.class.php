<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/28 0028
 * Time: 下午 7:27
 */

namespace Home\Controller;
use Think\Account;
use Think\Smsapi;
use Think\Tool;
use Think\Builddata;

class UserController extends CommonController
{
    public function per_center(){
        $num_id=session('num_id');
        $record=M('table_record')->where('name="matching"')->find();
		$record_team=M('recommend_relation')->where('num_id="'.$num_id.'"')->find();
        $max=$record['value'];
        if($max>1){
            $num[0]=$max-1;
            $num[1]=$max;
        }else{
            $num[0]=$max;
        }
        $sum_principal=0;
        $count=0;
        foreach($num as $key => $val){
            $case=M(''.$val.'_matching');
            $sum_principal+=$case->where('num_id="'.$num_id.'" AND state=0')->sum('principal');
            $count+=$case->where('num_id="'.$num_id.'" AND state=0')->count();
        }
		//print_r($sum_principal);die;
        $data=M('members')->where('num_id="'.session('num_id').'"')->find();
		if($data['activation']==1){
			$data['state']='已激活';
			$data['state_c']='green';
		}else{
			$data['state']='未激活';
			$data['state_c']='red';
		}
        $money=M('user_coin')->where('num_id="'.session('num_id').'"')->find();
		if(!empty($data['level'])){
			$data['name']=$data['name'].'('.$data['level'].')';
		}
		//print_r($data);die;
		$this->assign('money',$money['all_money']);
		$this->assign('name',$data['name']);
		$this->assign('state',$data['state']);
		$this->assign('color',$data['state_c']);
		$this->assign('direct',$record_team['direct_num']);
		$this->assign('team',$record_team['team_num']);
		$this->assign('num_id',$data['num_id']);
		$this->assign('sum_principal',$sum_principal);
		$this->assign('count',$count);
		$this->display();
    }
	
	public function team(){
		if(IS_AJAX){
			if($_POST['o']!==null){
                $o =I('post.o',1,'int');
            }else{
                $o =1;
            }
			$direct=M('recommend_relation')->field('num_id')->where('recommend="'.session('num_id').'"')->select();
			foreach($direct as $k=>$v){
				$member=M('members')->field('activation,user')->where('num_id="'.$v['num_id'].'"')->find();
				$direct[$k]['activation']=$member['activation'];
				$direct[$k]['user']=$member['user'];
			}
			//echo $o;die;
			$tool=new Tool();
			
			$data=$tool->Page_arr($direct,8,5,$o);
			$str='';
			foreach($data['data'] as $key => $val){
				if($val['activation']==0){
					$name='未激活';
					$color='red';
				}else{
					$color='green';
					$name='已激活';
				}
				$str.='
					<div class="in-list-box" style="border-top: 1px solid #E3E3E3;">
						<div class="in-list-text in-list-width">'.$val['user'].'</div>
						<div class="in-list-text in-list-width">'.$val['num_id'].'</div> 
						<div class="in-list-text in-list-width" style="color:'.$color.';">'.$name.'</div>		
					</div>
				';
			}
			
			$res['data']=$str;
			$res['o']=$data['o'];
			$res['count']=$data['count'];
			if(empty($data['data'])){
				$res['o']=1;
				$res['count']=1;
			}
			$res=json_encode($res);
			echo $res;
		}else{
			$data=M('members')->where('num_id="'.session('num_id').'"')->find();
			$money=M('user_coin')->where('num_id="'.session('num_id').'"')->find();
			$this->assign('money',$money['all_money']);
			$this->assign('num_id',$data['num_id']);
			$this->display();
		}
	}
	
	public function yzm(){
		if(IS_AJAX){
			//echo 111;die;
			$tel=_safe(I('post.tel'));
			$type=_safe(I('post.type'));
			//echo $tel;die;
			$sms=new Smsapi();
			$sms->produce_verification_code($tel,$type);
		}
	}
	
	
    public function edit_user(){
        if(IS_AJAX){
			$state=_safe(I('post.type'));
			
			switch($state){
				case '1':   //登录密码
					$yzm=_safe(I('post.yzm'));
					$password=_safe(I('post.password'));
					$states=1;
					break;
				case '2':    //交易密码
					$yzm=_safe(I('post.yzm'));
					$trade_password=_safe(I('post.password'));
					$states=1;//
					break;
				case '3':
					$states=2;
					$bank_name=_safe(I('post.bank_name'));
					$bank_number=_safe(I('post.bank_number'));
					$bank_adress=_safe(I('post.bank_adress'));
					$bank_province=_safe(I('post.bank_province'));
					$bank_city=_safe(I('post.bank_city'));
					break;
			}
			if($states==1){
				$key = 'IH^&*%545qg'.session('user');
				//echo $_SESSION['save_code'];
				if($_SESSION['save_code']!=$yzm){
					$datas['msg']='验证码错误';
					$datas['state']=0;
					$datas=json_encode($datas);
					echo $datas;
					exit;
				}
				if($state==1){
					$save['password']=access_md16( $password , $key );
				}elseif($state==2){
					$save['trade_password']=access_md16( $trade_password , $key );
				}
			}else{
				$bank=array('工商银行','农业银行','中国银行','建设银行','邮储银行');
				if(in_array($bank_name,$bank)){
					$save['bank_name']=$bank_name;
					$save['bank_number']=$bank_number;
					$save['bank_adress']=$bank_adress;
					$save['bank_city']=$bank_city;
					$save['bank_province']=$bank_province;
				}else{
					$datas['msg']='该银行不支持';
					$datas['state']=0;
					$datas=json_encode($datas);
					echo $datas;
					exit;
				}
			}
			//print_r($save);die;
			if(M('members')->where('num_id="'.session('num_id').'"')->save($save)!==false){
				$datas['msg']='修改成功,请重新进入该界面';
				$datas['state']=1;
				$datas=json_encode($datas);
				echo $datas;
				exit;
			}else{
				$datas['msg']='修改失败';
				$datas['state']=-1;
				$datas=json_encode($datas);
				echo $datas;
				exit;
			}
		}else{
			
			$Bank_Info[0]['name']="工商银行";
			$Bank_Info[1]['name']="农业银行";
			$Bank_Info[2]['name']="中国银行";
			$Bank_Info[3]['name']="建设银行";
			$Bank_Info[4]['name']="邮储银行";
			$this->assign('Bank_Info',$Bank_Info);
			$data=M('members')->where('num_id="'.session('num_id').'"')->find();
			$money=M('user_coin')->where('num_id="'.session('num_id').'"')->find();
			$this->assign('money',$money['all_money']);
			$this->assign('num_id',$data['num_id']);
			$data=M('members')->where('num_id="'.session('num_id').'"')->find();
			$this->assign('data',$data);
			$this->display();
		}
    }

	/*public function accounts(){
		if(IS_AJAX){
			if($_POST['o']!==null){
                $o =I('post.o',1,'int');
            }else{
                $o =1;
            }
			$table_record=M('table_record')->where('name="trans_record"')->find();
			$max=$table_record['value'];
			if($max>1){
				$num[0]=$max-1;
				$num[1]=$max;
			}else{
				$num[0]=$max;
			}
			$data=array();
			foreach ($num as $key => $val){
				$case=''.$max.'_trans_record';
				$matching=M($case)->where('from_id="'.session('num_id').'"')->select();
				if(empty($matching)&&!empty($data)){
					$data=$data;
				}elseif(!empty($matching)&&empty($data)){
					$data=$matching;
				}elseif(!empty($matching)&&!empty($data)){
					$data=array_merge($data,$matching);
				}
			}
			//echo $o;die;
			$tool=new Tool();
			
			$data=$tool->Page_arr($data,8,5,$o);
			//print_r($data);
			$str='';
			foreach($data['data'] as $key => $val){
				$time=date('Y-m-d H:i',$val['time']);
				$str.='
					<div class="in-list-box" style="border-top: 1px solid #E3E3E3;">
						<div class="in-list-text in-list-width">'.$time.'</div>		
						<div class="in-list-text in-list-width">'.$val['money'].'</div>
						<div class="in-list-text in-list-width">'.$val['get_id'].'</div> 
					</div>
				';
			}
			$res['data']=$str;
			$res['o']=$data['o'];
			$res['count']=$data['count'];
			if(empty($data['data'])){
				$res['o']=1;
				$res['count']=1;
			}
			$res=json_encode($res);
			echo $res;
		}else{
			$data=M('members')->where('num_id="'.session('num_id').'"')->find();
			$money=M('user_coin')->where('num_id="'.session('num_id').'"')->find();
			$this->assign('money',$money['all_money']);
			$this->assign('num_id',$data['num_id']);
			$this->display();
		}
		
	}*/
	
	public function check(){
		if(IS_AJAX){
			$num_id=_safe(I('post.num_id'));
			if($num_id==session('num_id')){
				$data['state']=0;
				$data['msg']='自己不能给自己转账';
				$data=json_encode($data);
				echo $data;
				exit;
			}
			$data=M('members')->field('name')->where('num_id="'.$num_id.'"')->find();
			$data['state']=1;
			$data=json_encode($data);
			echo $data;
			exit;
		}
	}
	
	public function account_trade(){
		if(IS_AJAX){
			//print_r($_POST);
			$money=_safe(I('post.money'));
			$num_id=_safe(I('post.num_id'));
			$trade_password=_safe(I('post.password'));
			$check_money=M('user_coin')->where('num_id="'.session('num_id').'"')->find();
			if($check_money['all_money']<$money){
				$res['msg']='当前余额不足';
				$res=json_encode($res);
				echo $res;
				exit;
			}
			$data=M('members')->where('num_id="'.session('num_id').'"')->find();
			
			$key = 'IH^&*%545qg'.$data['user'];
			$pass = access_md16( $trade_password , $key );
			//echo $pass;die;
			if($pass!=$data['trade_password']){
				$res['msg']='二级密码错误';
				$res=json_encode($res);
				echo $res;
				exit;
			}
			M()->startTrans();
			$save_de['all_money']=array('exp','all_money-'.$money);
			if(M('user_coin')->where('num_id="'.session('num_id').'"')->save($save_de)!==false){
				$save_ad['all_money']=array('exp','all_money+'.$money);
				$build=new Builddata();
				$build->build_trans_record();
				if(M('user_coin')->where('num_id="'.$num_id.'"')->save($save_ad)!==false){
					$add['get_id']=$num_id;
					$add['from_id']=session('num_id');
					$add['money']=$money;
					$add['time']=time();
					$record=M('table_record')->where('name="trans_record"')->find();
					if(M(''.$record['value'].'_trans_record')->add($add)){
						M()->commit();
						$res['msg']='操作成功';
						$res=json_encode($res);
						echo $res;
						exit;
					}else{
						M()->rollback();
						$res['msg']='信息错误';
						$res=json_encode($res);
						echo $res;
						exit;
					}
				}else{
					M()->rollback();
					$res['msg']='信息错误';
					$res=json_encode($res);
					echo $res;
					exit;
				}
			}else{
				M()->rollback();
				$res['msg']='信息错误';
				$res=json_encode($res);
				echo $res;
				exit;
			}
		}
	}
}