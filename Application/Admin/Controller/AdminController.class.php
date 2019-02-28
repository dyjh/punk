<?php
namespace Admin\Controller;
use Think\Controller;
class AdminController extends CommonController {
    public function index(){
		    //当日注册人数
			$cur_date = strtotime(date('Y-m-d'));
		    $Today = M('members')->where("regist_time >= '{$cur_date}'")->select();
			
			//历史注册人数
			$History = M('members')->select();
			
			//当前投注人数&历史投注人数&当日投注金额&历史投注金额
			$Model = M('table_record');
			$rebate = $Model->where('name="matching"')->find();
			$f = $rebate['value'];
			for ($i=0;$i<$rebate['value'];$i++){
			$reba = $f.'_matching';
			$prin = M($reba)->where('state=0')->select();
			$prin_num = M($reba)->where('state=1')->select();
			$p[$i] = $prin;
			$pr[$i] = $prin_num;
			$f--;
			 }
			 
			foreach($p as $key=>$val) {
				for ($s=0;$s<count($val);$s++){
				$principal += $val[$s]['principal'];
				}
			}
			
			foreach($pr as $ke=>$va) {
			for ($x=0;$x<count($va);$x++){
				$principal_num += $va[$x]['principal'];
				}
			}
			
			//当日提现金额&历史提现金额
			$order_list = $Model->where('name="order_list"')->find();
			$j = $order_list['value'];
			for ($h=0;$h<$order_list['value'];$h++){
			$orde = $j.'_order_list';
			$order = M($orde)->where("confirm_time >= '{$cur_date}' AND state=1 AND cash=0")->select();
			$order_num = M($orde)->where("state=1 AND cash=0")->select();
			$o[$h] = $order;
			$or[$h] = $order_num;
			$j--;
			 }
			foreach($o as $k=>$v) {
			for ($w=0;$w<count($v);$w++){
				$money += $v[$w]['money'];
				}
			}
			
			foreach($or as $y=>$l) {
			for ($t=0;$t<count($l);$t++){
				$money_num += $l[$t]['money'];
				}
			}
			
			$start_time    =  empty($_GET['start_time'])  ? strtotime(date('Y-m-d 00:00:00', time()))  : strtotime($_GET['start_time']);
			$end_time  	   =  empty($_GET['end_time'])    ? strtotime(date('Y-m-d 00:00:00', time()))+24*3600  : strtotime($_GET['end_time']);
		
		
		
		
			
			$arr['Today'] = count($Today);
			$arr['History'] = count($History);
			$arr['bate'] = count($prin);
			$arr['bate_num'] = count($prin_num);
			$arr['principal'] = $principal;
			$arr['principal_num'] = $principal_num;
			$arr['money'] = $money;
			$arr['money_num'] = $money_num;
			session('arr',$arr);
			$this->assign('arr',$arr);
			$this->assign('start_time',$start_time);
			$this->assign('end_time',$end_time);
			$this->display();
        
    }
	
	public function index_stat(){
		    $start_time = empty($_GET['start_time'])  ? strtotime(date('Y-m-d 00:00:00', time()))  : strtotime($_GET['start_time']);
		    $end_time = empty($_GET['end_time'])    ? strtotime(date('Y-m-d 00:00:00', time()))+24*3600  : strtotime($_GET['end_time']);
			$all = array();
			$game_list = M('game_list')->where('time>="'.$start_time.'" and time<="'.$end_time.'" and type=2 and is_show=1')->select();
			foreach($game_list as $key=>$val){
				$fox = M('table_record')->where('name="matching"')->find();
				$f = $fox['value'];
				
				for ($i=0;$i<$fox['value'];$i++){
					$reba = $f.'_matching';
					$prin = M($reba)->where('game_id='.$val['id'])->order('add_time desc')->select();
					//$all[$val['id']] = array_merge($all , (array)$prin);
					$all[$val['id']] = $prin;
					$f--;
				}
				
			} 
			foreach($all as $k=>$v){
						$row[$k]['num'] = count($v);
				foreach($v as $a=>$s){
					if($s['state'] == 2){
						continue;
					}else{
						if(($s['interest'] == '0.00') && ($s['state'] !== 2)){
							$row[$k]['profit'] += $s['principal'];//盈利
						}else{
							$row[$k]['interest'] += $s['interest']; //结算
							$row[$k]['principal'] += $s['principal']; //投注量金额
							$row[$k]['lose'] += ($s['interest']-$s['principal']); //亏损
						}
					}
				}
				$row[$k]['lose'] = round($row[$k]['lose'],2);
			}
			
			foreach($game_list as $t=>$u){
				$game_list[$t]['row'] = $row[$u['id']];
			}
			//print_r($game_list);
			$profit = 0;
			$lose = 0;
			for($q=0;$q<count($game_list);$q++){
				if($game_list[$q]['state'] == 5){
						$profit += $game_list[$q]['row']['profit'] ;//盈利
				}
				$lose +=  $game_list[$q]['row']['lose'] ;//亏损
			}
			
			$jl = $profit-$lose;
			
			$this->assign('jl',$jl);
			$this->assign('profit',$profit);
			$this->assign('lose',$lose);
			$this->assign('start_time',$start_time);
			$this->assign('end_time',$end_time);
			$this->assign('res',$game_list);
			$this->assign('arr',$_SESSION['arr']);
			$this->display();
        
    }
}