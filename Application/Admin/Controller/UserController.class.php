<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Account;
class UserController extends CommonController {
    public function index(){
		$Model = D('User');
		$res = $Model->select();
		for ($i=0;$i<count($res);$i++){
			$map['direct_num']  = array('ELT',$res[$i]['direct_num']);
			$map['team_num']  = array('ELT',$res[$i]['team_num']);
			$res_map = M('rebate_conf')->where($map)->order('id desc')->select();
			if(empty($res_map)){
				$res[$i]['rebate'] = '无';
			}else{
				$res[$i]['rebate'] = $res_map[0]['name'];
			}
			$table_record=M('table_record')->where('name="matching"')->find();
			$max=$table_record['value'];
			if($max>1){
				$num[0]=$max-1;
				$num[1]=$max;
			}else{
				$num[0]=$max;
			}
			$data=array();
			$profit=0;
			foreach ($num as $key => $val){
				$case=''.$val.'_matching';
				$matching=M($case)->where('num_id="'.$res[$i]['num_id'].'" AND state>0')->order('add_time DESC')->select();
				foreach($matching as $k => $v){
					
					//$score=M('game_odds')->where('game_id='.$v['game_id'].' AND score="'.$v['score'].'"')->find();
					$game=M('game_list')->where('id='.$v['game_id'].'')->find();
					$matching[$k]['forecast']=round(($v['interest']-$v['principal']),2);
					switch($v['end_state']){
						case '2':
							if($v['type']==2&&$game['score']=='4-4'){
							}else{
								$profit-=$v['principal'];
							}
							break;
						case '1':
							$profit+=$matching[$k]['forecast'];
							break;
					}
				}
			}
			if($profit>0){
				$profit='+'.$profit;
			}elseif($profit<0){//
				$profit=$profit;
			}
			$res[$i]['profit']=$profit;
		}
		$this->assign('res',$res);
		$this->display();
        
    }
	
	//顶级用户注册
	public function add(){
		if(IS_POST){
			$Acc = I('post.');
			$Account = new Account($Acc);
			$res = $Account->regist();
			if($res == 'success'){
				$this->success('注册成功！', U('User/index'));
			}else{
				$this->error('操作有误！');
			}
		}else{
			$this->display();	
		}	
		
    }
	
	public function edit(){
		if(IS_POST){
			$svav = I('post.');
			$Model = D('User');
			$where['num_id'] = $svav['num_id'];
			$sd['name'] = $svav['name'];
			$sd['all_money'] = $svav['all_money'];
			$sd['bank_name'] = $svav['bank_name'];
			$sd['bank_adress'] = $svav['bank_adress'];
			$sd['bank_number'] = $svav['bank_number'];
			$sd['user_titles'] = $svav['user_titles'];
			if($Model->where($where)->save($sd)){
				$this->success('修改成功！', U('User/index'));
			}else{
				$this->error('操作有误！');
			}
		}else{
			$id = I('get.admin_id',0);
			$Model = D('User');
			$where['num_id'] = $id;
			$res = $Model->where($where)->find();
			$this->assign('res',$res);
			$this->display();	
		}
    }
	
	public function team(){
		
			$id = I('get.admin_id',0);
			$Model = D('User');
			$where['num_id'] = $id;
			$res = $Model->where($where)->find();
			
			//直推
			$red = M('recommend_relation')->where('recommend="'.$res['num_id'].'"')->select();
			for($i=0;$i<count($red);$i++){
				$we['num_id'] = $red[$i]['num_id'];
				$red[$i]['row'] = M('members')->where($we)->find();
			}
			
			
			$rdc = M('recommend_relation')->where('team regexp "[[:<:]]'.$id.'[[:>:]]"')->select();
			$array = array();
			for($c=0;$c<count($rdc);$c++){
				if($rdc[$c]['recommend'] == $id){
					continue;
				}else{
					$wes['num_id'] = $rdc[$c]['num_id'];
					$array[$c] = $rdc[$c];
					$array[$c]['row'] = M('members')->where($wes)->find();
				}
				
			}
			$dd = count($array)+count($red);
			$this->assign('dd',$dd);
			$this->assign('array_num',count($array));
			$this->assign('array',$array);
			$this->assign('res',$res);
			$this->assign('res_num',count($red));
			$this->assign('red',$red);
			$this->display();	
		
    }
}