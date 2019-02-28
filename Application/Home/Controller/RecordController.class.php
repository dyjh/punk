<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/2 0002
 * Time: 上午 9:45
 */

namespace Home\Controller;
use Think\Tool;
use Think\Builddata;
class RecordController extends CommonController
{
	public function rebate(){
		$data=M('members')->where('num_id="'.session('num_id').'"')->find();
			$money=M('user_coin')->where('num_id="'.session('num_id').'"')->find();
			
			$this->assign('num_id',$data['num_id']);
			$this->assign('money',$money['all_money']);
		$timestamp = time()-24*3600;  
        
        $first_start=strtotime(date('Y-m-d', strtotime("this week Monday", $timestamp)));
        $first_end=strtotime(date('Y-m-d', strtotime("this week Sunday", $timestamp))) + 24 * 3600 - 1;  
        $second_start=strtotime(date('Y-m-d', strtotime("this week Monday", $timestamp)))-7*24*3600;
        $second_end=strtotime(date('Y-m-d', strtotime("this week Sunday", $timestamp))) + 24 * 3600 - 1-7*24*3600;
		$last_start=strtotime(date('Y-m-d', strtotime("this week Monday", $timestamp)))-14*24*3600;
        $last_end=strtotime(date('Y-m-d', strtotime("this week Sunday", $timestamp))) + 24 * 3600 - 1-7*24*3600;
		
		$table_record=M('table_record')->where('name="rebate_commission"')->find();
        $max=$table_record['value'];
        if($max>1){
            $num[0]=$max-1;
            $num[1]=$max;
        }else{
            $num[0]=$max;
        }
		$data_first=array();
		//echo $first_end;
		$money_re=0;
		foreach ($num as $key => $val){
            $case=''.$val.'_rebate_commission';
            $record=M($case)->where('num_id="'.session('num_id').'" AND state=1 AND time>='.$first_start.' AND time<='.$first_end.'')->order('time DESC')->select();
            $money_re+=M($case)->where('num_id="'.session('num_id').'" AND state=0 AND time>='.$first_start.' AND time<='.$first_end.'')->sum('money');
			//echo M()->getlastsql();
            if(empty($record)&&!empty($data_first)){
                $data_first=$data_first;
            }elseif(!empty($record)&&empty($data_first)){
                $data_first=$record;
            }elseif(!empty($record)&&!empty($data_first)){
                $data_first=array_merge($data_first,$record);
            }
			$activ=M('activit_record')->where('num_id="'.session('num_id').'" AND time>='.$first_start.' AND time<='.$first_end.'')->order('time DESC')->select();
			foreach($activ as $k=>$v){
				$activ[$k]['type']=0;
			}
			if(empty($activ)&&!empty($data_first)){
                $data_first=$data_first;
            }elseif(!empty($activ)&&empty($data_first)){
                $data_first=$activ;
            }elseif(!empty($activ)&&!empty($data_first)){
                $data_first=array_merge($activ,$data_first);
            }
        }
		//print_r($data_first);die;
		//die;
		$data_second=array();
		foreach ($num as $key => $val){
            $case=''.$val.'_rebate_commission';
            $record=M($case)->where('num_id="'.session('num_id').'" AND state=1 AND time>='.$second_start.' AND time<='.$second_end.'')->order('time DESC')->select();
			
            if(empty($record)&&!empty($data_second)){
                $data_second=$data_second;
            }elseif(!empty($record)&&empty($data_second)){
                $data_second=$record;
            }elseif(!empty($record)&&!empty($data_second)){
                $data_second=array_merge($data_second,$record);
            }
			$activ=M('activit_record')->where('num_id="'.session('num_id').'" AND time>='.$second_start.' AND time<='.$second_end.'')->order('time DESC')->select();
			foreach($activ as $k=>$v){
				$activ[$k]['type']=0;
			}
			if(empty($activ)&&!empty($data_second)){
                $data_second=$data_second;
            }elseif(!empty($activ)&&empty($data_second)){
                $data_second=$activ;
            }elseif(!empty($activ)&&!empty($data_second)){
                $data_second=array_merge($activ,$data_second);
            }
        }
		
		$data_last=array();
		foreach ($num as $key => $val){
            $case=''.$val.'_rebate_commission';
            $record=M($case)->where('num_id="'.session('num_id').'" AND state=1 AND time>='.$last_start.' AND time<='.$last_end.'')->order('time DESC')->select();
            if(empty($record)&&!empty($data_last)){
                $data_last=$data_last;
            }elseif(!empty($record)&&empty($data_last)){
                $data_last=$record;
            }elseif(!empty($record)&&!empty($data_last)){
                $data_last=array_merge($data_last,$record);
            }
			$activ=M('activit_record')->where('num_id="'.session('num_id').'" AND time>='.$last_start.' AND time<='.$last_end.'')->order('time DESC')->select();
			foreach($activ as $k=>$v){
				$activ[$k]['type']=0;
			}
			if(empty($activ)&&!empty($data_last)){
                $data_last=$data_last;
            }elseif(!empty($activ)&&empty($data_last)){
                $data_last=$activ;
            }elseif(!empty($activ)&&!empty($data_last)){
                $data_last=array_merge($activ,$data_last);
            }
        }
		$this->assign('rebate',$money_re);
		$this->assign('data_first',$data_first);
		$this->assign('data_second',$data_second);
		$this->assign('data_last',$data_last);
		
		$this->display();
	}
	
	public function extract_top(){
		if(IS_AJAX){
			/*$build=new Builddata();
			$build->build_order_list();
			die;*/
			if($_POST['o']!==null){
                $o =I('post.o',1,'int');
            }else{
                $o =1;
            }
			$type=_safe(I('post.type'));
			$table_record=M('table_record')->where('name="order_list"')->find();
			$max=$table_record['value'];
			if($max>1){
				$num[0]=$max-1;
				$num[1]=$max;
			}else{
				$num[0]=$max;
			}
			$data=array();
			//print_r($max);
			foreach ($num as $key => $val){
				$case=''.$val.'_order_list';
				$matching=M($case)->where('user="'.session('user').'" AND cash='.$type.'')->order('submit_time DESC')->select();
				
				if(empty($matching)&&!empty($data)){
					$datas=$data;
				}elseif(!empty($matching)&&empty($data)){
					//echo 1;
					
					$datas=$matching;
					
				}elseif(!empty($matching)&&!empty($data)){
					//echo 2;
					$datas=array_merge($data,$matching);
					//print_r($data);die;
				}
			}
			//echo $o;die;
			$tool=new Tool();
			//print_r($datas);
			$datas=$tool->Page_arr($datas,8,5,$o);
			//print_r($datas);die;
			$str='';
			$conf=M('system_conf')->where('name="cash_withdrawal_com"')->find();
			$odds=$conf['value'];
			$conf_money=M('system_conf')->where('name="exchange_rate"')->find();
			$odds_money=substr($conf_money['value'],2,3);
			foreach($datas['data'] as $key => $val){
				$time=date('m-d',$val['submit_time']);
				if($val['state']==0){
					$name='处理中';
				}else{
					$name='成功';
				}
				
				if($val['cash']==1){
					$hanging='---';
					$money=round($val['money'],2);
					$money_type=' CNY';
				}else{
					$money_type=' USD';
					$money=round($val['money']/$odds_money,2);
					$hanging=round($val['handling']/$odds_money,2).' '.$money_type;
				}
				$str.='
					<div class="in-list-box" style="border-top: 1px solid #E3E3E3;">
						<div class="in-list-text">'.$time.'</div>		
						<div class="in-list-text">'.$money.''.$money_type.'</div>
						<div class="in-list-text">'.$name.'</div>
						<div class="in-list-text">'.$hanging.'</div>
					</div>
				';
			}
			$res['data']=$str;
			$res['o']=$datas['o'];
			$res['count']=$datas['count'];
			//print_r($res);die;
			$res=json_encode($res);
			echo $res;
		}
	}
	
	public function back(){
		if(IS_AJAX){
			$str=_safe(I('post.id'));
			//$score=_safe(I('post.score'));
			$data_str=explode('-',$str);
			$id=$data_str[0];
			//$id=49;
			$num=$data_str[1];
			//$num=1;
			$case=''.$num.'_matching';
			$matching=M($case)->where('id='.$id.' AND state=0')->find();//
			//print_r($matching);die;
			$dec=time()-$matching['add_time'];
			//echo $dec.'-'.time().'a-'.$mathcing['add_time'].'<br/>';
			//print_r($dec);die;//
			if($dec>=300){
				$res['msg']='下单已超过5分钟，无法撤销';
				$res['state']=0;
				$res=json_encode($res);
				echo $res;exit;
			}
			$game=M('game_list')->where('id='.$matching['game_id'].'')->find();
			if(time()>$game['time']){
				$res['msg']='比赛已封盘，无法撤销';
				$res['state']=0;
				$res=json_encode($res);
				echo $res;exit;
			}
			$money=$matching['principal'];
			$save['state']=2;
			M()->startTrans();
			$save_odds['max_money']=array('exp','max_money+'.$money);
			$save_odds['bet_money']=array('exp','bet_money-'.$money);
			//$save_odds['num']=array('exp','num-1');/////
			$save_money['all_money']=array('exp','all_money +'.$money);
			if(M('user_coin')->where('num_id="'.session('num_id').'"')->save($save_money)!==false){
				if(M($case)->where('id="'.$id.'" AND state=0')->save($save)!==false){
					//echo M('user_coin')->getlastsql();die;//
					if(M('game_odds')->where('game_id='.$matching['game_id'].' AND score="'.$matching['score'].'"')->save($save_odds)!==false){
						M()->commit();
						$res['msg']='撤销成功，请刷新';
						$res['state']=1;
						$res['id']=$id;
						$res=json_encode($res);
						echo $res;exit;
					}else{
						M()->rollback();
						$res['msg']='撤销失败';
						$res['state']=0;
						$res=json_encode($res);
						echo $res;exit;
					}
				}else{
					M()->rollback();
					$res['msg']='撤销失败';
					$res['state']=0;
					$res=json_encode($res);
					echo $res;exit;
				}
			}else{
				M()->rollback();
				$res['msg']='撤销失败';
				$res['state']=0;
				$res=json_encode($res);
				echo $res;exit;
			}
		}
	}
	
	public function trade(){
		$conf_data=M('system_conf')->where('name="trade_com"')->find();
		$conf=$conf_data['value'];
		$data=M('members')->where('num_id="'.session('num_id').'"')->find();
		$money=M('user_coin')->where('num_id="'.session('num_id').'"')->find();
		$this->assign('num_id',$data['num_id']);
		$this->assign('money',$money['all_money']);
		
		
		
		$table_record=M('table_record')->where('name="matching"')->find();
        $max=$table_record['value'];
        if($max>1){
            $num[0]=$max-1;
            $num[1]=$max;
        }else{
            $num[0]=$max;
        }
        $data=array();
        $forecast=0;
        $invest=0;
        foreach ($num as $key => $val){
            $case=''.$val.'_matching';
            $matching=M($case)->where('num_id="'.session('num_id').'" AND state=0')->select();
			
			foreach($matching as $k => $v){
				if($v['type']!=2){
					if($v['type']==1||$v['score']=='其他比分'){
						$matching[$k]['score']=$v['score'];
					}else{
						$matching[$k]['score']=substr($v['score'],0,1).' - '.substr($v['score'],2,3);
					}
				}
				$score=M('game_odds')->where('game_id='.$v['game_id'].' AND score="'.$v['score'].'" AND type='.$v['type'].'')->find();
				$game=M('game_list')->where('id='.$v['game_id'].'')->find();
				$matching[$k]['forecast']=$score['odds']*$v['principal']*(1-$conf);
				$matching[$k]['forecast']=round($matching[$k]['forecast'],2);
				$matching[$k]['area']=$game['area'];
				$matching[$k]['start_time']=$game['time'];
				$matching[$k]['team_first']=$game['team_first'];
				$matching[$k]['team_second']=$game['team_second'];
				$matching[$k]['case']=$val;
				$forecast+=$matching[$k]['forecast'];
			}
            $invest+=M($case)->where('num_id="'.session('num_id').'" AND state=0')->sum('principal');
            
            if(empty($matching)&&!empty($data)){
                $data=$data;
            }elseif(!empty($matching)&&empty($data)){
                $data=$matching;
            }elseif(!empty($matching)&&!empty($data)){
                $data=array_merge($data,$matching);
            }
        }
		//print_r($data);die;
		$this->assign('data',$data);
		$this->assign('forecast',$forecast);
		$this->assign('invest',$invest);
		$this->display();
	}
	
	public function bill(){
		$start=time()-14*24*3600;
		$end=time();
		$conf_data=M('system_conf')->where('name="trade_com"')->find();
		$conf=$conf_data['value'];
		$data=M('members')->where('num_id="'.session('num_id').'"')->find();
		$money=M('user_coin')->where('num_id="'.session('num_id').'"')->find();
		$this->assign('num_id',$data['num_id']);
		$this->assign('money',$money['all_money']);
		
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
        $invest=0;
        foreach ($num as $key => $val){
			$case=''.$val.'_matching';
            $matching=M($case)->where('num_id="'.session('num_id').'" AND state>0 AND add_time>='.$start.' AND add_time<='.$end.'')->order('add_time DESC')->select();
			
			foreach($matching as $k => $v){
				
				
				$score=M('game_odds')->where('game_id='.$v['game_id'].' AND score="'.$v['score'].'" AND type='.$v['type'].'')->find();
				$game=M('game_list')->where('id='.$v['game_id'].'')->find();
				$matching[$k]['forecast']=round(($v['interest']-$v['principal']),2);
				$matching[$k]['odds']=$score['odds']*100;
				$matching[$k]['area']=$game['area'];
				
				$matching[$k]['start_time']=$game['time'];
				$matching[$k]['team_first']=$game['team_first'];
				$matching[$k]['team_second']=$game['team_second'];
				
				switch($v['type']){
					case '2':
						$data_score=explode('-',$game['score']);
						$ma_score=$data_score[0]+$data_score[1];
						$matching[$k]['score_game']=$ma_score;
						$matching[$k]['score_name']='进球数波胆';
						break;
					case '0':
						$matching[$k]['score_game']=$game['score'];
						$matching[$k]['score_name']='全场反波胆';
						break;
					case '1':
						$matching[$k]['score_game']=$game['half'];
						$matching[$k]['score_name']='半场反波胆';
						break;
				}
				
				switch($v['end_state']){
					case '2':
						if($v['type']==2&&$game['score']=='4-4'){
							$matching[$k]['forecast']='平 0 USD';
						}else{
							$profit-=$v['principal'];
							$matching[$k]['forecast']='亏损 '.$v['principal'].' USD';
						}
						break;
					case '1':
						$profit+=$matching[$k]['forecast'];
						$matching[$k]['forecast']='盈利 '.round(($v['interest']-$v['principal']),2).' USD';
						break;
				}
			}
			//print_r($game);die;
            $invest+=M($case)->where('num_id="'.session('num_id').'" AND state=1')->sum('principal');
            
            if(empty($matching)&&!empty($data)){
                $data=$data;
            }elseif(!empty($matching)&&empty($data)){//
                $data=$matching;
            }elseif(!empty($matching)&&!empty($data)){
                $data=array_merge($data,$matching);
            }
		}
		if($profit>0){
			$profit='+'.$profit;
		}elseif($profit<0){//
			$profit=$profit;
		}
		$this->assign('data',$data);
		$this->assign('profit',$profit);
		$this->assign('invest',$invest);
		$this->display();
	}
	
	/*public function pay(){
		if(IS_AJAX){
			//
		}
	}*/
}