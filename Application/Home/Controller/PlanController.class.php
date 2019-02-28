<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/27 0027
 * Time: 上午 11:43
 */

namespace Home\Controller;
use Think\Dataapi;
use Think\Builddata;
header("Content-type:text/html;charset=utf-8");
//
class PlanController
{
	public function activity(){
		$conf_data=M('system_conf')->where('name="order_num" or name="ac_money" or name="is_use" or name="max_user_num" or name="user_num" or name="ac_start" or name="ac_end"')->select();
		foreach($conf_data as $kc=>$vc){
			switch($vc['name']){
				case 'order_num':
					$conf['order_num']=$vc['value'];
					break;
				case 'ac_money':
					$conf['money']=$vc['value'];
					break;
				case 'is_use':
					$conf['is_use']=$vc['value'];
					break;
				case 'max_user_num':
					$conf['max_user_num']=$vc['value'];
					break;
				case 'user_num':
					$conf['user_num']=$vc['value'];
					break;
				case 'ac_start':
					$start=$vc['value'];
					$start=explode('-',$start);
					//print_r($start);
					$conf['start']=mktime(0,0,0,$start[1],$start[2],$start[0]);
					break;
				case 'ac_end':
					$end=$vc['value'];
					$end=explode('-',$end);
					//print_r($end);
					$conf['end']=mktime(0,0,0,$end[1],$end[2],$end[0]);
					break;
			}
		}
		//print_r($conf);die;
		$BeginDate=date('Y-m-01 0:00:00', strtotime(date("Y-m-d")));
        $last_begin=strtotime(date('Y-m-d 0:00:00', strtotime("$BeginDate +1 month")));
		if(time()>=$last_begin){
			$save_re['user_num']=$conf['max_user_num'];
			M('system_conf')->where('name="user_num"')->save($save_re);
		}

		if($conf['user_num']!=0&&$conf['is_use']==1){
			M()->startTrans();
			$str='start';
			file_put_contents('./log/activity.log',$str.PHP_EOL."\n",FILE_APPEND); 
			$data_member=M('members')->where('regist_time>='.$conf['start'].' and regist_time<='.$conf['end'].' and activity_state=0 and activation=1')->select();
			//print_r($data_member);die;
			$less=0;
			foreach($data_member as $key=>$val){
				$win=0;
				$table_record=M('table_record')->where('name="matching"')->find();
				$max=$table_record['value'];
				if($max>1){
					$num[0]=$max-1;
					$num[1]=$max;
				}else{
					$num[0]=$max;
				}
				foreach ($num as $k => $v){
					$case=''.$v.'_matching';
					$matching=M($case)->where('num_id="'.$val['num_id'].'" AND end_state=1')->select();
					foreach($matching as $ka => $va){
						if(($va['principal']+0.01)<=$va['interest']){
							$win++;
						}
					}
				}
				//echo $win;die;
				if($win>=$conf['order_num']){
					$referer=M('recommend_relation')->where('num_id="'.$val['num_id'].'"')->find();
					if(!empty($referer)){
						$commer=$referer['recommend'];
						$save['all_money']=array('exp','all_money+'.$conf['money']);
						if(M('user_coin')->where('num_id="'.$commer.'"')->save($save)!==false){
							$save_member['activity_state']=1;
							if(M('members')->where('num_id="'.$val['num_id'].'"')->save($save_member)!==false){
								$str='用户：'.$commer.'奖励：'.$conf['money'].'时间：'.date('Y-m-d H:i:s',time());
								file_put_contents('./log/activity.log',$str.PHP_EOL."\n",FILE_APPEND); 
								$add['num_id']=$commer;
								$add['money']=$conf['money'];
								$add['time']=time();
								$add['from']=$val['num_id'];
								M('activit_record')->add($add);
								$less++;
							}else{
								M()->rollback();
								exit();
							}
						}else{
							M()->rollback();
							exit();
						}
					}
				}
			}
			$save_conf['value']=array('exp','value-'.$less);
			if(M('system_conf')->where('name="user_num"')->save($save_conf)!==false){
				echo 'success:'.$less;
				M()->commit();
				$str='end';
				file_put_contents('./log/activity.log',$str.PHP_EOL."\n",FILE_APPEND); 
			}else{
				M()->rollback();
				exit();
			}
		}else{
			echo 'no';
		}
	}
	
	public function system_refresh(){
		$st_time=time()-2.5*3600;
		$data=M('game_list')->where('is_show=1 and state=1 and time<'.$st_time)->select();
		foreach($data as $key=>$val){
			//print_r($val['id']);
			//$this->manual_refresh_sys($val['id']);
			$game_list['is_show']=3;
			if(M('game_list')->where('id='.$val['id'].' AND state!=5')->save($game_list)!==false){
				if($val['undo_state']==0){
					$this->undo_action($val['id']);
					$this->out_news($val['id']);
					echo '未开场,处理为延期'.$val['id'].'<br>';
				}
			}	
		}
	}
	
	
	
	public function manual_refresh(){
		
		$id=_safe(I('get.id'));
		echo $id;
		$check=M('game_list')->where('id='.$id.'')->find();
		//print_r($check);
		if($check['undo_state']!=1&&$check['state']!=5){
			$url='BF_XMLByID.aspx?id='.$id;
			$data=new Dataapi();
			$res=$data->post_sms($url,'');
			$result=simplexml_load_string($res, 'SimpleXMLElement', LIBXML_NOCDATA);
			$result=json_encode($result);
			$result=json_decode($result,true);
			//print_r($result);die;
			$Schedule=$result['match'];
			$id=$Schedule['a'];
			$state=$Schedule['f'];
			if(!empty($result)){
				//echo  $state.'<br/>';
				unset($game_list);
				if($state*1>=2){
					$game_list['half']=$Schedule['l'].'-'.$Schedule['m'];
					$game_list['f']=2;
				}elseif($state*-1==1){
					//echo $state*-1+1;
					$game_list['half']=$Schedule['l'].'-'.$Schedule['m'];
					$game_list['score']=$Schedule['j'].'-'.$Schedule['k'];
					$game_list['end_time']=time();
					$game_list['state']=4;
				}elseif($state*-1==12){
					$game_list['is_show']=2;
				}elseif($state*-1==13){
					$game_list['is_show']=4;
				}elseif($state*-1==11){
					$game_list['is_show']=5;	
				}elseif($state*-1==14){
					$game_list['is_show']=3;		
				}elseif($state*-1==10){
					$game_list['is_show']=6;
				}
				//print_r($state);die;
				//echo $id;die;
				if($check['state']!=4&&$check['is_show']<=1){
					if($state*1>=2){
						if(M('game_list')->where('id='.$id.' AND state!=3')->save($game_list)!==false){
							if($this->settlement_half()){
								echo 'succsee1'.$id.'<br>';
							}
						}
					}elseif($state*-1==1){
						$save_f['half']=$game_list['half'];
						$save_f['state']=2;
						if(M('game_list')->where('id='.$id.' AND state!=3')->save($save_f)!==false){
							if($this->settlement_half()){
								//echo 111;
								$save_s['score']=$game_list['score'];
								$save_s['end_time']=time();
								$save_s['state']=4;
								if(M('game_list')->where('id='.$id.' AND state!=5')->save($save_s)!==false){
									if($this->settlement()){
										echo 'succsee2'.$id.'<br>';
									}
								}
							}
						}
					}elseif($state*-1==12){
						if(M('game_list')->where('id='.$id.' AND state!=5')->save($game_list)!==false){
							if($check['undo_state']==0&&$state*-1>=10){
								$this->undo_action($id);
								$this->out_news($id);
								echo 'succsee3'.$id.'<br>';
							}
						}
					}elseif($state*-1==13){
						if(M('game_list')->where('id='.$id.' AND state!=5')->save($game_list)!==false){
							if($check['undo_state']==0&&$state*-1>=10){
								$this->undo_action($id);
								$this->out_news($id);
								echo 'succsee4'.$id.'<br>';
							}
						}
					}elseif($state*-1==11){
						if(M('game_list')->where('id='.$id.' AND state!=5')->save($game_list)!==false){
							if($check['undo_state']==0&&$state*-1>=10){
								$this->undo_action($id);
								$this->out_news($id);
								echo 'succsee5'.$id.'<br>';
							}
						}
					}elseif($state*-1==14){
						if(M('game_list')->where('id='.$id.' AND state!=5')->save($game_list)!==false){
							if($check['undo_state']==0&&$state*-1>=10){
								$this->undo_action($id);
								$this->out_news($id);
								echo 'succsee8'.$id.'<br>';
							}
						}	
					}elseif($state*-1==10){
						if(M('game_list')->where('id='.$id.' AND state!=5')->save($game_list)!==false){
							if($check['undo_state']==0&&$state*-1>=10){
								$this->undo_action($id);
								$this->out_news($id);
								echo 'succsee7'.$id.'<br>';
							}
						}
					}elseif($state==0){
						$time_start=$check['time']+(2.5*3600);
						if($time_start<=time()){
							$game_list['is_show']=3;
							if(M('game_list')->where('id='.$id.' AND state!=5')->save($game_list)!==false){
								if($check['undo_state']==0&&$state==0){
									$this->undo_action($id);
									$this->out_news($id);
									echo '未开场,处理为延期'.$id.'<br>';
								}
							}	
						}
					}
				}
			}else{
				echo '比赛不存在';
			}
			
		}else{
			echo '该比赛无需刷新';
		}
	}
    
	public function team_logo(){
		 echo '2223';
		 file_put_contents('./log/team_logo.log',date('Y-m-d H:i:s',time()).PHP_EOL."\n",FILE_APPEND); 
		$data=new Dataapi();
        $res=$data->post_sms('Team_XML.aspx','');
		$reader = new \XMLReader();
		$reader->XML($res);
		
		
		$countElements = 0;   
		  $i=0;
		while ($reader->read()){   
			if($reader->nodeType == \XMLReader::ELEMENT){   
				$nodeName = $reader->name;   
			}   
			if($reader->nodeType == \XMLReader::TEXT && !empty($nodeName)){   
				switch($nodeName){   
					case 'g':   
						$team[$i]['g'] = $reader->value;   //
						break;   
					case 'lsID':   
						$team[$i]['id'] = $reader->value;   
						break;
					case 'Flag':   
						$team[$i]['Flag'] = $reader->value;   
						break;
				}   
			}
			if(count($team[$i])==3){
				$i++;
			}
		} 
		$reader->close();   
		//echo 111;
		//print_r($team);
		foreach($team as $key=>$val){
			
			$data=M('game_list')->where('team_first="'.$val['g'].'" and img_first="" or team_second="'.$val['g'].'" and img_second=""')->select();
			//echo M()->getlastsql().'<br/>';
			//print_r($data);
			foreach($data as $k=>$v){
				echo 111;
				/*switch($val['g']){
					case $v['team_first']: 
						//echo 333;
						$save['img_first']='http://zq.win007.com/Image/team/'.$val['Flag'];
						break;
					case $v['team_second']: 
						///echo 222;
						$save['img_second']='http://zq.win007.com/Image/team/'.$val['Flag'];
						break;
				}*/
				unset($save);
				if($v['team_first']==$val['g']){
					$save['img_first']='http://zq.win007.com/Image/team/'.$val['Flag'];
				}else if($v['team_second']==$val['g']){
					$save['img_second']='http://zq.win007.com/Image/team/'.$val['Flag'];
				}
		//print_r($save);
				if(M('game_list')->where('id='.$v['id'].'')->save($save)!==false){
					echo $v['id'].'succsee';
				}
			}
		}
	}
	/*
     * 赛事结算 全场//
     */
    public function settlement(){
		echo 33;
		file_put_contents('./log/settlement.log',date('Y-m-d H:i:s',time()).PHP_EOL."\n",FILE_APPEND); 
		$conf_data=M('system_conf')->where('name="trade_com"')->find();
		$conf=$conf_data['value'];
		M()->startTrans();
		$str='start';
		file_put_contents('./log/half_res.log',$str.PHP_EOL."\n",FILE_APPEND); 
        $data=M('game_list')->where('state=4 AND undo_state=0 AND is_show=1')->select();     //获取完成但未结算的赛事
		
        foreach ( $data as $key => $val ){
			if($val['score']=='4-4'){
				$add['title']='【赛事公告】['.$val['area'].']';
				$add['content']=''.$val['team_first'].' vs '.$val['team_second'].' 赛事结果比分4:4，平台已补贴本场波胆投注4:4的本金，其它波胆投注有效，请知晓！';
				$add['time']=time();
				$add['is_show']=1;
				M('information')->add($add);
			}
            $record=M('table_record')->where('name="matching"')->find();
            for($i = 1;$i <= $record['value'];$i++){
                $case=M(''.$i.'_matching');
				
                $data_matching=$case->where('game_id='.$val['id'].' AND state=0 AND type=2 or type=0 AND game_id='.$val['id'].' AND state=0')->select();
				//print_r($data_matching);die;
				if(!empty($data_matching)){
					foreach ( $data_matching as $k => $v ){
						if($v['type']==2){
							$num=substr($val['score'],0,1)+substr($val['score'],2,3);
							if($v['score']>$num){
								$save['interest'] = 0;
								$save['end_state'] = 2;
								$save['state'] = 1;
							}else{
								//echo 2;die;
								$save['end_state'] = 1;
								$save['state'] = 1;
								$odds=M('game_odds')->where('score="'.$v['score'].'" AND game_id='.$val['id'].' AND type=2')->find();
								$money=($odds['odds']+1)*$v['principal'];//1060
								
								$shouxuf = (($money-$v['principal'])*(1-$conf))+$v['principal'];
								$save['interest']=round($shouxuf,2);
								//$save_money['static_money']=array('exp','static_money+'.$save['interest']);
								$check_l=M('user_coin')->lock(true)->where('num_id="'.$v['num_id'].'"')->find();
								if($check_l){
									$save_money['all_money']=array('exp','all_money+'.$save['interest']);
									if(M('user_coin')->where('num_id="'.$v['num_id'].'"')->save($save_money)!==false){
										$money_d=$save['interest']-$v['principal'];
										
										if( $this->de_rebate($v['num_id'],$money_d) ==false){
											echo 'error1';
											M()->rollback();
											return false;
											exit();
										}
										if( $this->team_rebate($v['num_id'],$money_d) ==false){
											echo 'error2';
											M()->rollback();
											return false;
											exit();
										}
										$str='(进球数)用户：'.$v['num_id'].'反'.$save['interest'].'余额：'.$check_l['all_money'].'球赛ID'.$val['id'].'比分'.$v['score'].'时间：'.date('Y-m-d H:i:s',time());
										file_put_contents('./log/whole_res.log',$str.PHP_EOL."\n",FILE_APPEND); 
										
									}else{
										echo 'error3';
										M()->rollback();
										return false;
										exit();
									}
								}else{
									echo 'error3';
									M()->rollback();
									return false;
									exit();
								}
							}
						}elseif($v['type']==0){
							if($v['score'] == $val['score']){
								$save['interest'] = 0;
								$save['end_state'] = 2;
								$save['state'] = 1;
								if($v['score']=='4-4'){
									$save['end_state'] = 1;
									$shouxuf=$v['principal'];
									$save['interest']=$shouxuf;
									$save_money['all_money']=array('exp','all_money+'.$save['interest']);
									M('user_coin')->where('num_id="'.$v['num_id'].'"')->save($save_money);
								}
							}else{
								//echo 0;die;
								$save['end_state'] = 1;
								$save['state'] = 1;
								$odds=M('game_odds')->where('score="'.$v['score'].'" AND game_id='.$val['id'].' AND type=0')->find();
								$money=($odds['odds']+1)*$v['principal'];//1060
								$shouxuf = (($money-$v['principal'])*(1-$conf))+$v['principal'];
								$save['interest']=round($shouxuf,2);
								$check_l=M('user_coin')->lock(true)->where('num_id="'.$v['num_id'].'"')->find();
								if($check_l){
									$save_money['all_money']=array('exp','all_money+'.$save['interest']);
									if(M('user_coin')->where('num_id="'.$v['num_id'].'"')->save($save_money)!==false){
										$money_d=$save['interest']-$v['principal'];
										if( $this->de_rebate($v['num_id'],$money_d) ==false){
											echo 'error4';
											M()->rollback();
											return false;
											exit();
										}
										if( $this->team_rebate($v['num_id'],$money_d) ==false){
											echo 'error5';
											M()->rollback();
											return false;
											exit();
										}
										$str='(全场)用户：'.$v['num_id'].'反'.$save['interest'].'余额：'.$check_l['all_money'].'球赛ID'.$val['id'].'比分'.$v['score'].'时间：'.date('Y-m-d H:i:s',time());
										file_put_contents('./log/whole_res.log',$str.PHP_EOL."\n",FILE_APPEND); 
									}else{
										echo 'error6';
										M()->rollback();
										return false;
										exit();
									}
								}else{
									echo 'error6';
									M()->rollback();
									return false;
									exit();
								}
							}
						}
						//print_r($save);echo $id;die;
						$save['end_time']=time();
						if($case->where('id='.$v['id'].' AND state=0')->save($save) ==false){
							//echo $res;
							echo M()->getlastsql();
							echo 'error7';
							M()->rollback();
							return false;
							exit();
						}
					}
				}
            }
			$save_game['state']=5;
			if(M('game_list')->where('id='.$val['id'].' and state=4')->save($save_game)==false){
				echo 'error8';
				M()->rollback();
				return false;
				exit();
			}
        }
		$str='end';
		file_put_contents('./log/half_res.log',$str.PHP_EOL."\n",FILE_APPEND); 
		M()->commit();
		return true;
    }
	
	/*
	 *
	 */
	public function settlement_half(){
		echo 333;
		file_put_contents('./log/settlement_half.log',date('Y-m-d H:i:s',time()).PHP_EOL."\n",FILE_APPEND); 
		$conf_data=M('system_conf')->where('name="trade_com"')->find();
		$conf=$conf_data['value'];
		$data=M('game_list')->where('state=2 AND undo_state=0 AND is_show=1 AND half!=""')->select();     //获取完成但未结算的赛事
		$str='start';
		file_put_contents('./log/half_res.log',$str.PHP_EOL."\n",FILE_APPEND); 
		foreach ( $data as $key => $val ){
            $record=M('table_record')->where('name="matching"')->find();
            for($i = 1;$i <= $record['value'];$i++){
				$case=M(''.$i.'_matching');
				M()->startTrans();
				$data_matching=$case->where('game_id='.$val['id'].' AND state=0 AND type=1')->select();
				if(!empty($data_matching)){
					foreach ( $data_matching as $k => $v ){
						if($v['score']=='其他比分'){
							$half_data=explode('-',$val['half']);
							if($half_data[0]>2||$half_data[1]>2){
								$save['interest'] = 0;
								$save['end_state'] = 2;
								$save['state'] = 1;
							}else{
								$save['end_state'] = 1;
								$save['state'] = 1;
								$odds=M('game_odds')->where('score="'.$v['score'].'" AND game_id='.$val['id'].' AND type=1')->find();										
								$money=($odds['odds']+1)*$v['principal'];//1060
								$shouxuf = (($money-$v['principal'])*(1-$conf))+$v['principal'];
								$save['interest']=$shouxuf;	
								$check_l=M('user_coin')->lock(true)->where('num_id="'.$v['num_id'].'"')->find();
								if($check_l){
									$save_money['all_money']=array('exp','all_money+'.$save['interest']);
									if(M('user_coin')->where('num_id="'.$v['num_id'].'"')->save($save_money)!==false){
										
										$money_d=$save['interest']-$v['principal'];
										if( $this->de_rebate($v['num_id'],$money_d) ==false){
											echo 'error2';
											M()->rollback();
											return false;
											exit();
										}
										if( $this->team_rebate($v['num_id'],$money_d) ==false){
											echo 'error2';
											M()->rollback();
											return false;
											exit();
										}
										$str='(半场)用户：'.$v['num_id'].'反'.$save['interest'].'余额：'.$check_l['all_money'].'球赛ID'.$val['id'].'比分'.$v['score'].'时间：'.date('Y-m-d H:i:s',time());
										file_put_contents('./log/half_res.log',$str.PHP_EOL."\n",FILE_APPEND); 
									}else{
										echo 'error1';
										M()->rollback();
										return false;
										exit();
									}
								}else{
									echo 'error1';
									M()->rollback();
									return false;
									exit();
								}
							}
						}else{
							if($v['score'] == $val['half']){
								$save['interest'] = 0;
								$save['end_state'] = 2;
								$save['state'] = 1;
							}else{
								$save['end_state'] = 1;
								$save['state'] = 1;
								$odds=M('game_odds')->where('score="'.$v['score'].'" AND game_id='.$val['id'].' AND type=1')->find();										
								$money=($odds['odds']+1)*$v['principal'];//1060
								$shouxuf = (($money-$v['principal'])*(1-$conf))+$v['principal'];
								$save['interest']=$shouxuf;					
								
								//$save['interest']=round(((1-$conf)*($odds['odds']+1))*$v['principal'],2);
								//$save_money['static_money']=array('exp','static_money+'.$save['interest']);
								$save_money['all_money']=array('exp','all_money+'.$save['interest']);
								if(M('user_coin')->where('num_id="'.$v['num_id'].'"')->save($save_money)!==false){
									$money_d=$save['interest']-$v['principal'];
									if( $this->de_rebate($v['num_id'],$money_d) ==false){
										echo 'error2';
										M()->rollback();
										return false;
										exit();
									}
									if( $this->team_rebate($v['num_id'],$money_d) ==false){
										echo 'error2';
										M()->rollback();
										return false;
										exit();
									}
									$str='(半场)用户：'.$v['num_id'].'反'.$save['interest'].'余额：'.$check_l['all_money'].'球赛ID'.$val['id'].'比分'.$v['score'].'时间：'.date('Y-m-d H:i:s',time());
									file_put_contents('./log/half_res.log',$str.PHP_EOL."\n",FILE_APPEND); 
								}else{
									echo 'error1';
									M()->rollback();
									return false;
									exit();
								}
							}
						}
						$save['half_time']=time();
						if($case->where('id='.$v['id'].' AND state=0')->save($save) ==false){
							//echo $case->getlastsql();
							M()->rollback();
							return false;
							exit();
						}
					}
				}
			}
			$save_game['state']=3;
			if(M('game_list')->where('id='.$val['id'].' and state=2')->save($save_game)==false){
				M()->rollback();
				return false;
				exit();
			}
        }
		$str='end';
		file_put_contents('./log/half_res.log',$str.PHP_EOL."\n",FILE_APPEND); 
		M()->commit();
		return true;
	}

	private function team_rebate($num_id,$money){
		file_put_contents('./log/team_rebate.log',date('Y-m-d H:i:s',time()).PHP_EOL."\n",FILE_APPEND); 
		$conf_data=M('system_conf')->where('name="trade_com" or name="max_rebate_com"')->select();
		foreach($conf_data as $key=>$val){
			if($val['name']=='trade_com'){
				$conf=$val['value'];
			}else{
				$max_com=$val['value'];
			}
		}
		
		//$num_id='zc557477';
		$build=new Builddata();
        $build->build_matching();
		$build->build_rebate_commission();
		$check=M('members')->where('num_id="'.$num_id.'"')->find();
        if($check['user_titles']==1||$check['activation']==0){
            return true;
        }
		$team=M('recommend_relation')->where('num_id="'.$num_id.'"')->find();
		$superior = array_values(array_filter(explode(' ',$team['team'] )));
		if(empty($superior)){
			return true;
		}
		$com_now=0;
		$count=count($superior);
		//foreach($superior as $key=>$val){
		for($i=0;$i<$count;$i++){
			if($max_com<=0){
				break;
			}
			//echo $superior[$count-1-$i];
			$member=M('members')->where('num_id="'.$superior[$count-1-$i].'" AND level!="" AND activation=1')->find();
			if(!empty($member)){
				
				//echo $member['level'];
				$rebate_conf=M('rebate_conf')->where('name="'.$member['level'].'"')->find();
				$rebate_conf_new=$rebate_conf['com']-$com_now;
				if($rebate_conf_new>=$max_com){
					$end_com=$max_com;
				}else{
					$end_com=$rebate_conf_new;
				}
				if($end_com>0){
					//echo '用户：'.$superior[$count-1-$i].' com:'.$end_com.' 円：'.$rebate_conf['com'].'<br/>';
					//$max_com=$max_com-$end_com;
					//$com_now=$rebate_conf['com'];
					$money_s=($end_com/100)*$money*(1-$conf);
					//print_r($money);die;
					$save_rebate['type']=1;//
					$save_rebate['time']=time();
					$save_rebate['money']=round($money_s,2);
					$save_rebate['num_id']=$member['num_id'];
					$save_rebate['from_id']=$num_id;
					if($save_rebate['money']!=0){
						$record=M('table_record')->where('name="rebate_commission"')->find();
						if(M(''.$record['value'].'_rebate_commission')->add($save_rebate)){
							$max_com=$max_com-$end_com;
							$com_now=$rebate_conf['com'];
							//print_r($save_rebate);
						}else{
							echo 'error9';
							return false;
						}
					}
				}
			}
		}
		//die;
		return true;
	}
	
	
	/*
	 *处理代理佣金 
	 */
	public function team_deal(){
		file_put_contents('./log/team_deal.log',date('Y-m-d H:i:s',time()).PHP_EOL."\n",FILE_APPEND); 
		$conf=M('system_conf')->where('name="get_rebate_day"')->find();
		//print_r($conf);die;
		if(date('w')==$conf['value']){
			$table_record=M('table_record')->where('name="rebate_commission"')->find();
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
			M()->startTrans();
			foreach ($num as $key => $val){
				$case=''.$val.'_rebate_commission';
				$record=M($case)->where('type=1 AND state=0')->select();
				foreach($record as $k=>$v){
					$num_id=$v['num_id'];
					$money=$v['money'];
					$save['all_money']=array('exp','all_money+'.$money);
					if(M('user_coin')->where('num_id="'.$num_id.'"')->save($save) !==false){
						$save_rebate['state']=1;
						if(M($case)->where('id='.$v['id'].'')->save($save_rebate) ==false){
							M()->rollback();
							//echo 2;
							break;
						}
					}else{
						//echo M()->getlastsql();
						M()->rollback();
						break;
					}
				}
			}
			M()->commit();
		}else{
			echo date('w');
		}
	}
	
	/*
	 *直推佣金
	 */
    private function de_rebate($num_id,$money){
		$conf_data=M('system_conf')->where('name="trade_com"')->find();
		$confs=$conf_data['value'];
		$build=new Builddata();
        //$build->build_matching();
		$build->build_rebate_commission();
        $data=M('recommend_relation')->where('num_id="'.$num_id.'"')->find();
        $referrer=$data['recommend'];
		//print_r($data);die;
		$check_member=M('members')->where('num_id="'.$num_id.'"')->find();
        if($check_member['user_titles']==1||$check_member['activation']==0){
            return true;
        }
		
        $check=M('members')->where('num_id="'.$referrer.'"')->find();
        if($check['user_titles']==1||$check['activation']==0){
			echo 'de01';
            return true;
        }
		if(empty($referrer)){
            return true;
        }
        $conf=M('system_conf')->where('name="direct_rebate"')->find();
		
        $money=$money*$conf['value']*(1-$confs);
		$ss=round($money,2);
        //$save_money['static_money']=array('exp','static_money+'.$money);
        $save_money['all_money']=array('exp','all_money+'.$ss);

        if(M('user_coin')->where('num_id="'.$referrer.'"')->save($save_money) !==false){
            $save_rebate['type']=0;
            $save_rebate['state']=1;
            $save_rebate['time']=time();	
					//echo (1-$confs);die;
            $save_rebate['money']=$ss;		
            $save_rebate['num_id']=$referrer;
            $save_rebate['from_id']=$num_id;
			//print_r($save_rebate);
			if($ss!=0){
				$record=M('table_record')->where('name="rebate_commission"')->find();
				if(M(''.$record['value'].'_rebate_commission')->add($save_rebate)){
					return true;
				}else{
					echo 'error10';
					return false;
				}
			}else{
				return true;
			}
        }
    }
	
	//赛程
    //赛程
    public function data(){
		$times=_safe(I('get.time',403200,'int'));
		/*echo 222;
		echo $time;die;*/
		file_put_contents('./log/data.log',date('Y-m-d H:i:s',time()).PHP_EOL."\n",FILE_APPEND); 
		$time=date('Y-m-d',time()+24*3600*4);
		//print_r($time);die;//
        $data=new Dataapi();
		echo 222;
        $res=$data->post_sms('BF_XML.aspx',$time);
		$result=simplexml_load_string($res, 'SimpleXMLElement', LIBXML_NOCDATA);
		$result=json_encode($result);
		$result=json_decode($result,true);
		
		
		//print_r($result);die;
		
		$Schedule=$result['match'];
		
		$game_list=array();
		$i=0;
		//print_r($Schedule);die;
		foreach($Schedule as $key => $val){
			//print_r($Team[3405]);
			$game_list['id']=$val['a'];
			$area=explode(',',$val['c']);
			$team_first=explode(',',$val['h']);
			$team_second=explode(',',$val['i']);
			$game_list['team_first']=$team_first[0];
			$game_list['id_first']=$team_first[3];
			$game_list['id_second']=$team_second[3];
			$game_list['team_second']=$team_second[0];
			$game_list['time']=strtotime($val['d']);
			
			$game_list['area']=$area[0];
			$check=M('game_list')->where('id='.$game_list['id'].'')->select();
			if(empty($check)){
				M('game_list')->add($game_list);
				echo 'success';
			}
			
			//print_r($game_list);
			//$i++;
		}
		//
		/*$game=$res['Competition'][350];*/
        //print_r($game_list);//
		
    }
	//延期 、、腰斩赛事
	public function data_ks(){
		echo '2data_ks<br/>';
		file_put_contents('./log/data_ks.log',date('Y-m-d H:i:s',time()).PHP_EOL."\n",FILE_APPEND); 
		$data=new Dataapi();
		$res=$data->post_sms('ModifyRecord.aspx','');
		//print_r($res);die;
		$result=simplexml_load_string($res, 'SimpleXMLElement', LIBXML_NOCDATA);
		$result=json_encode($result);
		$result=json_decode($result,true);
		//print_r($result);die;
		//print_r($res);die;
		foreach($result['match'] as $key => $val){
			$id=$val['ID'];
			if($val['type']=='modify'){
				$save['is_show']=3;
				$save['time']=strtotime($val['matchtime']);
			}elseif($val['type']=='delete'){
				$save['is_show']=2;
			}
			$check=M('game_list')->where('id='.$id.'')->find();
			//print_r($save);
			//print_r($id);
			if($check['state']!=4&&$check['is_show']<=1){
				if(M('game_list')->where('id='.$id.' and is_show<2')->save($save)!==false){
					if($check['undo_state']==0){
						$this->undo_action($id);
						$this->out_news($id);
					}
					echo 'succsee'.$id.'<br>';
				}
				
			}
		}
		$this->data_refresh_min();
		//print_r($res);
		//print_r($res);
	}
	//已开场赛果刷新
	public function data_refresh(){
		echo '111data_refresh<br/>';
		file_put_contents('./log/data_refresh.log',date('Y-m-d H:i:s',time()).PHP_EOL."\n",FILE_APPEND); 
		$time=date('Y-m-d',time());
		//print_r($time);//
        $data=new Dataapi();
        $res=$data->post_sms('today.aspx','');
		//print_r($res);die;
		$result=simplexml_load_string($res, 'SimpleXMLElement', LIBXML_NOCDATA);
		$result=json_encode($result);
		$result=json_decode($result,true);
		//print_r($result);die;
		$Schedule=$result['match'];
		//$Competition=$res['Competition'];
		//$Team=$res['Team'];
		$game_list=array();
		$i=0;
			
		//print_r($Schedule);
		
		foreach($Schedule as $key => $val){
			//print_r($Team[3405]);
			$id=$val['ID'];
			$state=$val['state'];
			
			echo  $state.'<br/>';
			unset($game_list);
			if($state*1>=2){
				$game_list['half']=$val['bc1'].'-'.$val['bc2'];
				$game_list['state']=2;
			}elseif($state*-1==1){
				//echo $state*-1+1;
				$game_list['half']=$val['bc1'].'-'.$val['bc2'];
				$game_list['score']=$val['homeScore'].'-'.$val['awayScore'];
				$game_list['end_time']=time();
				$game_list['state']=4;
			}elseif($state*-1==12){
				$game_list['is_show']=2;
			}elseif($state*-1==13){
				$game_list['is_show']=4;
			}elseif($state*-1==11){
				//echo $state*-1;
				$game_list['is_show']=5;
			}elseif($state*-1==14){
				$game_list['is_show']=3;
			}elseif($state*-1==10){
				$game_list['is_show']=6;
			}
			$check=M('game_list')->where('id='.$id.'')->find();
			//print_r($game_list);
			//echo $id;
			if($check['state']!=4&&$check['is_show']<=1){
				//var_dump($state);
				//print_r($game_list);
				if($state*1>=2){
					if($check['state']!=3){
						if(M('game_list')->where('id='.$id.' AND state!=5 and is_show<2')->save($game_list)!==false){
							if($check['undo_state']==0&&$state*-1>=10){
								$this->undo_action($id);
								$this->out_news($id);
							}
							echo 'succsee'.$id.'<br>';
						}	
					}
				}else{
					if(M('game_list')->where('id='.$id.' AND state!=5 and is_show<2')->save($game_list)!==false){
						if($check['undo_state']==0&&$state*-1>=10){
							$this->undo_action($id);
							$this->out_news($id);
						}
						echo 'succsee'.$id.'<br>';
					}	
				}
			}
		}
		//
		/*$game=$res['Competition'][350];*/
        //
		$this->data_ks();
		//$this->data_ks();
    }
	
	public function data_refresh_min(){
		echo 'data_refresh_min<br/>';
		file_put_contents('./log/data_refresh_min.log',date('Y-m-d H:i:s',time()).PHP_EOL."\n",FILE_APPEND); 
		$time=date('Y-m-d',time());
		//print_r($time);//
        $data=new Dataapi();
        $res=$data->post_sms('change2.xml','');
		//print_r($res);die;
		$result=simplexml_load_string($res, 'SimpleXMLElement', LIBXML_NOCDATA);
		$result=json_encode($result);
		$result=json_decode($result,true);
		//print_r($result);die;
		$Schedule=$result['match'];
		//$Competition=$res['Competition'];
		//$Team=$res['Team'];
		$game_list=array();
		$i=0;
		//print_r($res);die;
		foreach($Schedule as $key => $val){
			//print_r($Team[3405]);
			$id=$val['ID'];
			$state=$val['state']*1;
			unset($game_list);
			if($state*1>=2){
				$game_list['half']=$val['bc1'].'-'.$val['bc2'];
				$game_list['state']=2;
			}elseif($state*-1==1){
				//echo $state*-1+1;
				$game_list['half']=$val['bc1'].'-'.$val['bc2'];
				$game_list['score']=$val['homeScore'].'-'.$val['awayScore'];
				$game_list['state']=4;
			}elseif($state*-1==12){
				$game_list['is_show']=2;
			}elseif($state*-1==13){
				$game_list['is_show']=4;
			}elseif($state*-1==11){
				//echo $state*-1;
				$game_list['is_show']=5;
			}elseif($state*-1==14){
				$game_list['is_show']=3;
			}elseif($state*-1==10){
				$game_list['is_show']=6;
			}
			$check=M('game_list')->where('id='.$id.'')->find();
			
			if($check['state']!=4&&$check['is_show']<=1){
				//var_dump($state);
				//print_r($game_list);
				if($state*1>=2){
					if($check['state']!=3){
						if(M('game_list')->where('id='.$id.' AND state!=5 and is_show<2')->save($game_list)!==false){
							if($check['undo_state']==0&&$state*-1>=10){
								$this->undo_action($id);
								$this->out_news($id);
							}
							echo 'succsee'.$id.'<br>';
						}	
					}
				}else{
					if(M('game_list')->where('id='.$id.' AND state!=5 and is_show<2')->save($game_list)!==false){
						if($check['undo_state']==0&&$state*-1>=10){
							$this->undo_action($id);
							$this->out_news($id);
						}
						echo 'succsee'.$id.'<br>';
					}	
				}
			}
		}
		//
		/*$game=$res['Competition'][350];*/
        //print_r($game_list);
		
    }
	
	//开场刷新
	public function start_refersh(){
		/*$path='./log/';
            if (!file_exists($path)){
                mkdir($path,0777,true);
            }*/
		file_put_contents('./log/start_refersh.log',date('Y-m-d H:i:s',time()).PHP_EOL."\n",FILE_APPEND); 
		//echo 1;
		//echo 1;die;
		$save['state']=1;
		M('game_list')->where('time<'.time().' AND undo_state=0 AND is_show=1 AND state=0')->save($save);
		$this->data_refresh();
	}
	
	
	/*public function error_game(){
		$game=M('game_list')->where('is_show=2 or is_show=3 or is_show=4 or is_show=5 or is_show=6')->select();
		foreach($game as $key=>$val){
			$id=$val['id'];
			$this->undo_action($id);
		}
		
	}*/
	
	private function undo_action($game_id){
		//echo $game_id;die;
		echo 222;//die;
		file_put_contents('./log/undo_action.log',date('Y-m-d H:i:s',time()).PHP_EOL."\n",FILE_APPEND); 
		M()->startTrans();
		//查看是否已经处理过
		if(M('game_list')->where('id='.$game_id.' and undo_state>0')->find()){
			echo 'error1';
		}
        //获取下注表前缀
        $fix = M('table_record')->where('name="matching"')->find();
		$save_state['state']=3;
		for($i=1;$i<=$fix['value'];$i++){ 
			$table = $i.'_matching';
			$res = M("$table")->where('game_id='.$game_id.' AND state=0')->select();
			//如果有数据
			if($res){
				for($j=0;$j<count($res);$j++){
					if(M("$table")->where('id="'.$res[$j]['id'].'"')->save($save_state)==false){
						 M()->rollback();
						 echo 'error2';
						 exit();
					}else{
						$ress=M('user_coin')->lock(true)->where('num_id="'.$res[$j]['num_id'].'"')->find();
						if($ress){
							$save_money['all_money']=array('exp','all_money+'.$res[$j]['principal']);
							if(M('user_coin')->where('num_id="'.$res[$j]['num_id'].'"')->save($save_money)==false){
								 M()->rollback();
								 echo 'error3';
								 exit();
							}
							$str='用户：'.$res[$j]['num_id'].'退'.$res[$j]['principal'].'余额：'.$ress['all_money'].'球赛ID'.$game_id.'时间：'.date('Y-m-d H:i:s',time());
							file_put_contents('./log/money_back.log',$str.PHP_EOL."\n",FILE_APPEND); 
						}else{
							M()->rollback();
							 echo 'error3';
							 exit();
						}
					}
				}
			}	
		} 
		
		//改变撤销状态
		$save['undo_state'] = 1;
		if(M('game_list')->where('id='.$game_id)->save($save)){
			M()->commit();
			echo 'succsee6';
		}else{
			M()->rollback();
			echo 'error4 '.$game_id;
			exit();
		}		
	}
	
	private function out_news($game_id){
		//echo $game_id;
		file_put_contents('./log/out_news.log',$game_id.PHP_EOL."\n",FILE_APPEND); 
		$game=M('game_list')->where('id='.$game_id.' AND is_show>1')->find();
		if($game['state']>=3){
			$text='全场波胆已取消，半场正常结算，请知晓！      新春佳节来临之际，PUNK为感谢新老会员的支持与厚爱，从即日起，punk总部每月从利润中拿出1万美金来帮助会员建立团队，充值大于100美金以上的会员，注册新会员后成功盈利三场比赛，PUNK将额外奖励10美金，仅限每月限前1000名新会员！

如发现恶意套利行为平台将严肃处理，最终解释权归PUNK！';
		}
		if($game['state']<=2){
			$text='所有注单无效!      新春佳节来临之际，PUNK为感谢新老会员的支持与厚爱，从即日起，punk总部每月从利润中拿出1万美金来帮助会员建立团队，充值大于100美金以上的会员，注册新会员后成功盈利三场比赛，PUNK将额外奖励10美金，仅限每月限前1000名新会员！

如发现恶意套利行为平台将严肃处理，最终解释权归PUNK！';
		}
		if($game['is_show']>=2||!empty($game)){
			switch($game['is_show']){
				case '2':
					$msg='腰斩';
					break;
				case '4':
					$msg='中断';
					break;
				case '6':
					$msg='取消';
					break;
				case '3':
					$msg='延期';
					break;
				case '5':
					$msg='推迟';
					break;
			}
			
			$add['title']='【赛事公告】['.$game['area'].']';
			$add['content']=''.$game['team_first'].' vs '.$game['team_second'].' 因比赛'.$msg.'，'.$text;
			$add['time']=time();
			$add['is_show']=1;
			//$check=M('game_list')->where('team_first="热刺U23" AND team_second="宾菲加B队"')->find();
			//print_r($add);die;
			
			M('information')->add($add);
		}
	}
	
	
	
}