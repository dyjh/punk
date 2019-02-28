<?php
namespace Pc\Controller;
use Think\Tool;
use Think\Builddata;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){
		$start_today=mktime(0,0,0,date('m'),date('d'),date('Y'));
        $start_tomorrow=$start_today+3600*24;
        $end_tomorrow=$start_tomorrow+3600*24;
		
        /*
         * 头部信息
         */
        $data=M('members')->where('num_id="'.session('num_id').'"')->find();
        $money=M('user_coin')->where('num_id="'.session('num_id').'"')->find();
        /*
         * 公告
         */
        $information=M('information')->where('is_show=1')->order('time desc')->find();
		
		//print_r($information);die;
        if(empty($information)){
            $info='暂无最新公告';
        }else{
			$information['content']=strip_tags( htmlspecialchars_decode($information['content']));
            $info=$information['title'].'：'._safe($information['content']);
        }
       
		$where_all='is_show=1 AND state=0 AND time>='.$start_today.' AND time<='.$end_tomorrow.'';
		$where_today='is_show=1 AND state=0 AND time>='.$start_today.' AND time<='.$start_tomorrow.'';
		$where_tomorrow='is_show=1 AND state=0 AND time>='.$start_tomorrow.' AND time<='.$end_tomorrow.'';
		
		
		//echo $where_today;die;
        //$game_all=M('game_list')->where($where_all)->order('time')->select();
		//print_r($game_all);//
        //$game_today=M('game_list')->where($where_today)->order('time')->select();
        //$game_tomorrow=M('game_list')->where($where_tomorrow)->order('time')->select();
	
		//$count_all=M('game_list')->where($where_all)->count();
		//$count_all=count($game_all);
		//$count_today=M('game_list')->where($where_today)->count();
		//$count_today=count($game_today);
		//$count_tomorrow=M('game_list')->where($where_tomorrow)->count();//
		//$count_tomorrow=count($game_tomorrow);//*/
        ////print_r($_SESSION);die;
		//echo $end_tomorrow;die;
		$area=M('game_list')->field('area')->where('is_show=1 AND state=0 AND time>='.$start_today.' AND time<='.$end_tomorrow.'')->group('area')->select();
		foreach($area as $k => $v){
			//$area[$k]['']
			$area[$k]['num']=M('game_list')->where('is_show=1 AND state=0 AND time>='.$start_today.' AND time<='.$end_tomorrow.' AND area="'.$v['area'].'"')->count();
		}
		//print_r($area);die;
		$this->assign('area',$area);
        /*$this->assign('game_all',$game_all);
        $this->assign('count_all',$count_all);
        $this->assign('game_today',$game_today);
        $this->assign('count_today',$count_today);
        $this->assign('game_tomorrow',$game_tomorrow);
        $this->assign('count_tomorrow',$count_tomorrow);*/
        $this->assign('info',$info);
        $this->assign('num_id',$data['num_id']);
		$this->assign('money',$money['all_money']);
        $this->display();
    }
	
	public function market_refresh(){
		if(IS_AJAX){
			$start_today=mktime(0,0,0,date('m'),date('d'),date('Y'));
			$start_tomorrow=$start_today+3600*24;
			$end_tomorrow=$start_tomorrow+3600*24;
			
			$area=_safe(I('post.area'));
			$super=explode('|',$area);
			//print_r($super);//
			
			$where_all='';
			$where_today='';
			$where_tomorrow='';
			if(!empty($area)){
				foreach($super as $key => $val){
					$where_all.='is_show=1 AND state=0 AND time>='.$start_today.' AND type=2 AND time<='.$end_tomorrow.' AND area="'.$val.'" or ';
					$where_today.='is_show=1 AND state=0 AND time>='.$start_today.' AND type=2 AND time<='.$start_tomorrow.' AND area="'.$val.'" or ';
					$where_tomorrow.='is_show=1 AND state=0 AND time>='.$start_tomorrow.' AND type=2 AND time<='.$end_tomorrow.' AND area="'.$val.'" or ';
				}
				$where_all=substr($where_all,0,-4);
				$where_today=substr($where_today,0,-4);
				$where_tomorrow=substr($where_tomorrow,0,-4);
			}else{
				$where_all='is_show=1 AND state=0 AND time>='.$start_today.' AND time<='.$end_tomorrow.' AND type=2';
				$where_today='is_show=1 AND state=0 AND time>='.$start_today.' AND time<='.$start_tomorrow.' AND type=2';
				$where_tomorrow='is_show=1 AND state=0 AND time>='.$start_tomorrow.' AND time<='.$end_tomorrow.' AND type=2';
			}
			//echo $where_all;die;
			$game_all=M('game_list')->where($where_all)->order('time')->select();
			
			//echo M('game_list')->getlastsql();die;
			$game_today=M('game_list')->where($where_today)->order('time')->select();
			
			$game_tomorrow=M('game_list')->where($where_tomorrow)->order('time')->select();
			
			//$count_all=M('game_list')->where($where_all)->count();
			$count_all=count($game_all);
			//$count_today=M('game_list')->where($where_today)->count();
			$count_today=count($game_today);
			//$count_tomorrow=M('game_list')->where($where_tomorrow)->count();//
			$count_tomorrow=count($game_tomorrow);//
			$area=M('game_list')->field('area')->where('is_show=1 AND state=0 AND time>='.$start_today.' AND time<='.$end_tomorrow.' AND type=2')->group('area')->select();
			foreach($area as $k => $v){
				//$area[$k]['']
				$area[$k]['num']=M('game_list')->where('is_show=1 AND state=0 AND time>='.$start_today.' AND time<='.$end_tomorrow.' AND type=2 AND area="'.$v['area'].'"')->count();
			}
			$conf=C('TMPL_PARSE_STRING');
			$url=$conf['__PUBLIC__'];
			//全部
			$str_all='';
			foreach($game_all as $ka => $va){
				$time=date('H:i',$va['time']);
				//echo $time;
				$str_all.=' <a href="'.U('Index/detail',array('id'=>$va['id'])).'">
								<div class="marked-list">
									<div class="list-head">
										<div class="marked-head-time"><span>'.$time.'</span></div>
										<div class="marked-head-name"><span>'.$va['area'].'</span></div>
									</div>
									<div class="marked-list-box">
										<div class="list-box" ><img src="'.$va['img_first'].'"></div>
										<div class="list-box list-box-span list-box-width">
											<span class="size4 box-span-width">'.$va['team_first'].'</span>
											<span class="size3 box-span-width list-box-vs">VS</span>
											<span class="size4 box-span-width">'.$va['team_second'].'</span>
										</div>
										<div class="list-box"><img src="'.$va['img_second'].'"></div>
										<div class="list-box" style="width: auto;"><img style="margin-left: 85%;" src="'.$url.'/images/right-arrow.png" class="right-arrow"></div>
									</div>
								</div>
							</a>';
			}
			//今日
			$str_today='';
			//print_r($game_today);die;//
			foreach($game_today as $kt => $vt){
				$time=date('H:i',$vt['time']);
				//echo $time;
				$str_today.=' <a href="'.U('Index/detail',array('id'=>$vt['id'])).'">
								<div class="marked-list">
									<div class="list-head">
										<div class="marked-head-time"><span>'.$time.'</span></div>
										<div class="marked-head-name"><span>'.$vt['area'].'</span></div>
									</div>
									<div class="marked-list-box">
										<div class="list-box" ><img src="'.$vt['img_first'].'"></div>
										<div class="list-box list-box-span list-box-width">
											<span class="size4 box-span-width">'.$vt['team_first'].'</span>
											<span class="size3 box-span-width list-box-vs">VS</span>
											<span class="size4 box-span-width">'.$vt['team_second'].'</span>
										</div>
										<div class="list-box"><img src="'.$vt['img_second'].'"></div>
										<div class="list-box" style="width: auto;"><img style="margin-left: 85%;" src="'.$url.'/images/right-arrow.png" class="right-arrow"></div>
									</div>
								</div>
							</a>';
			}
			
			//明日
			$str_tomorrow='';
			foreach($game_tomorrow as $km => $vm){
				$time=date('H:i',$vm['time']);
				//echo $time;
				$str_tomorrow.=' <a href="'.U('Index/detail',array('id'=>$vm['id'])).'">
								<div class="marked-list">
									<div class="list-head">
										<div class="marked-head-time"><span>'.$time.'</span></div>
										<div class="marked-head-name"><span>'.$vm['area'].'</span></div>
									</div>
									<div class="marked-list-box">
										<div class="list-box" ><img src="'.$vm['img_first'].'"></div>
										<div class="list-box list-box-span list-box-width">
											<span class="size4 box-span-width">'.$vm['team_first'].'</span>
											<span class="size3 box-span-width list-box-vs">VS</span>
											<span class="size4 box-span-width">'.$vm['team_second'].'</span>
										</div>
										<div class="list-box"><img src="'.$vm['img_second'].'"></div>
										<div class="list-box" style="width: auto;"><img style="margin-left: 85%;" src="'.$url.'/images/right-arrow.png" class="right-arrow"></div>
									</div>
								</div>
							</a>';
			}
			$data['all']=$str_all;
			$data['all_count']=$count_all;
			$data['today']=$str_today;
			$data['today_count']=$count_today;
			$data['tomorrow']=$str_tomorrow;
			$data['tomorrow_count']=$count_tomorrow;
			$data=json_encode($data);
			echo $data;
			//print_r($game_all);
		}
	}
	
	
	
    public function detail(){
		 /*
		 * 头部信息
		 */
		$data=M('members')->where('num_id="'.session('num_id').'"')->find();
		$money=M('user_coin')->where('num_id="'.session('num_id').'"')->find();
		/*
		 * 公告
		 */
		$information=M('information')->where('is_show=1')->order('time desc')->find();
		
		if(empty($information)){
			$info='暂无最新公告';
		}else{
			$information['content']=strip_tags( htmlspecialchars_decode($information['content']));
			$info=$information['title'].'：'._safe($information['content']);
		}
		$this->assign('num_id',$data['num_id']);
		$this->assign('money',$money['all_money']);
		$this->assign('info',$info);
		
		$game_id=_safe(I('get.id'));
		//echo $game_id;die;
		$game=M('game_list')->where('id='.$game_id.'')->find();
		$history=M('game_list')->where('team_first="'.$game['team_first'].'" AND team_second="'.$game['team_second'].'" AND time<'.$game['time'].' or team_first="'.$game['team_second'].'" AND team_second="'.$game['team_first'].'" AND time<'.$game['time'].'')->order('time DESC')->select();
		/*
		 *赔率
		 */
		$odds_all=M('game_odds')->where('game_id='.$game['id'].' AND type=0 AND max_money!=0 AND odds!=0')->select();
		foreach($odds_all as $k => $v){
			$odds_all[$k]['odds']=($v['odds']*100);
		}
		$count_all=M('game_odds')->where('game_id='.$game['id'].' AND type=0 AND max_money!=0 AND odds!=0')->sum('num');
		$odds_half=M('game_odds')->where('game_id='.$game['id'].' AND type=1 AND max_money!=0 AND odds!=0')->select();
		foreach($odds_half as $ke => $va){
			$odds_half[$ke]['odds']=($va['odds']*100);
		}
		$count_half=M('game_odds')->where('game_id='.$game['id'].' AND type=1 AND max_money!=0 AND odds!=0')->sum('num');
		$odds_number=M('game_odds')->where('game_id='.$game['id'].' AND type=2 AND max_money!=0 AND odds!=0')->select();
		foreach($odds_number as $key => $val){
			$odds_number[$key]['odds']=($val['odds']*100);
		}
		$count_number=M('game_odds')->where('game_id='.$game['id'].' AND type=2 AND max_money!=0 AND odds!=0')->sum('num');
		//print_r($odds_half);die;
		$this->assign('id',$game_id);//
		$this->assign('game',$game);
		$this->assign('history',$history);
		$this->assign('odds_all',$odds_all);
		$this->assign('odds_half',$odds_half);
		$this->assign('odds_number',$odds_number);
		$this->assign('count_all',$count_all);
		$this->assign('count_half',$count_half);
		$this->assign('count_number',$count_number);
		$this->display();
    }
	
	
	
	public function bet(){
		if(IS_AJAX){//
			$build=new Builddata();
			$build->build_matching();
			//$build->build_rebate_commission();
			$data=M('members')->where('num_id="'.session('num_id').'"')->find();
			
			$key = 'IH^&*%545qg'.$data['user'];
			$pass=_safe(I('post.pass'));
			$pass = access_md16( $pass , $key );
			//echo $pass;die;
			if($pass!=$data['trade_password']){
				$res['state']=-1;
				$res['res']='二级密码错误';
				$res=json_encode($res);
				echo $res;
				exit;
			}
			
			$money=_safe(I('post.money'));
			$type=_safe(I('post.type'));
			$state=_safe(I('post.state'));
			$id=_safe(I('post.id'));
			$odds=_safe(I('post.odds'));
			$score=_safe(I('post.score'));
			//print_r($_POST);die;
			$game_list=M('game_list')->where('id='.$id.'')->find();
			if($game_list['time']<=(time()-300)){
				$res['state']=-1;
				$res['res']='比赛已封盘';
				$res=json_encode($res);
				echo $res;
				exit;
			}
			$odds_game=M('game_odds')->where('game_id='.$id.' AND score="'.$score.'" AND type='.$state.'')->find();
			if($odds_game['max_money']<$money){
				$res['state']=-1;
				$res['res']='可下注金额不足';
				$res=json_encode($res);
				echo $res;
				exit;
			}
			if($game_list['is_show']==2||$game_list['is_show']==3){
				$res['state']=-1;
				$res['res']='比赛已被腰斩或延迟';
				$res=json_encode($res);
				echo $res;
				exit;
			}
			$save_odds['max_money']=array('exp','max_money-'.$money);
			$save_odds['bet_money']=array('exp','bet_money+'.$money);
			$save_odds['num']=array('exp','num+1');
			if($money<=0||$id<=0||$odds<=0){
				$res['state']=0;
				$res['res']='信息错误';
				$res=json_encode($res);
				echo $res;
				exit;
			}
			$coin=M('user_coin')->where('num_id="'.session('num_id').'"')->find();
			if($coin['all_money']<$money){
				$res['state']=-2;
				$res['res']='信息错误';
				$res=json_encode($res);
				echo $res;
				exit;
			}
			$save_money['all_money']=array('exp','all_money-'.$money);
			
			M()->startTrans();
			
			if($odds_game=M('game_odds')->where('game_id='.$id.' AND score="'.$score.'" AND type='.$state.'')->save($save_odds)!==false){
				$game=M('game_list')->where('id='.$id.'')->find();
				if(M('user_coin')->where('num_id="'.session('num_id').'"')->save($save_money) !==false){
					//echo M('user_coin')->getlastsql();die;
					$add['order_num']=substr(session('num_id'),4,7).''.substr(time(),5,9).''.rand(0,9).''.rand(0,9);
					$add['num_id']=session('num_id');
					$add['principal']=$money;
					$add['score']=$score;
					$add['interest']=($odds/100+1)*$moeny;
					$add['state']=0;
					$add['add_time']=time();
					$add['game_id']=$id;
					$add['add_time']=time();
					$add['type']=$type;
					$add['against_team']=$game['team_first'].'VS'.$game['team_second'];
					$record=M('table_record')->where('name="matching"')->find();
					if(M(''.$record['value'].'_matching')->add($add)){
						M()->commit();
						$res['state']=1;
						$res['res']='下注成功';
						$res=json_encode($res);
						echo $res;
						exit;
					}else{
						M()->rollback();
						$res['state']=0;
						$res['res']='下注失败';
						$res=json_encode($res);
						echo $res;
						exit;
					}
				}else{
					M()->rollback();
					$res['state']=0;
					$res['res']='下注失败';
					$res=json_encode($res);
					echo $res;
					exit;
				}
			}else{
				M()->rollback();
				$res['state']=0;
				$res['res']='下注失败';
				$res=json_encode($res);
				echo $res;
				exit;
			}
		}
	}
	
	public function notice(){
		if(IS_AJAX){
			if($_POST['o']!==null){
                $o =I('post.o',1,'int');
            }else{
                $o =1;
            }
			//echo $o;die;
			$tool=new Tool();
			$database='information';
			$date='';
			$join = "";
			$field = "";
			$order= "time DESC";
			$data=$tool->Page($database,$date,$o,7,5,$join,$field,$order);
			//print_r($data);
			$str='';
			foreach($data['data'] as $key => $val){
				$time=date('Y-m-d H:i:s',$val['time']);
				$str.='
					<div class="score-box trade-list-box">
						<div class="score-left notice-left">
							<a href='.U('Index/noticeshow',array('id'=>$val['id'])).'>
								<div class="score-left-list notive-list">
									<span class="score-time wzgg">'.$time.'</span>
								</div>
								<div class="score-left-list notive-list notive-list-hidden">
									<span class="wzgg">网站公告：</span>		
									<span>'.$val['title'].'</span>
								</div>
							</a>
						</div>
					</div>
				';
			}
			$res['data']=$str;
			$res['o']=$data['o'];
			$res['count']=$data['count'];
			$res=json_encode($res);
			echo $res;
		}else{
			$data=M('members')->where('num_id="'.session('num_id').'"')->find();
			$money=M('user_coin')->where('num_id="'.session('num_id').'"')->find();
			
			$this->assign('num_id',$data['num_id']);
			$this->assign('money',$money['all_money']);
			
			$this->display();
		}
	}
	
	public function noticeshow(){
		$datas=M('members')->where('num_id="'.session('num_id').'"')->find();
		$money=M('user_coin')->where('num_id="'.session('num_id').'"')->find();
		
		$this->assign('num_id',$datas['num_id']);
		$this->assign('money',$money['all_money']);
		$id=_safe(I('get.id'));
		$data=M('information')->where('id='.$id.'')->find();
		$data['content']=htmlspecialchars_decode($data['content']);
		$count=M('information')->count();
		$first=M('information')->order('id asc')->find();
		$last=M('information')->order('id desc')->find();
		if($first['id']==$id){
			$pre['name']='上一则（无）';
			$pre['url']='';//
		}else{
			for($i=$id-1;$i>=$first['id'];$i--){
				$pre=M('information')->where('id='.$i.'')->find();
				if(!empty($pre)){
					$pre['name']='上一则';
					$pre['url']=''.U('Index/noticeshow',array('id'=>$i)).'';
					break;
				}
			}
		}
		if($last['id']==$id){
			$next['name']='下一则（无）';
			$next['url']='';
		}else{
			for($k=$id+1;$k<=$last['id'];$k++){
				$next=M('information')->where('id='.$k.'')->find();
				if(!empty($next)){
					$next['name']='下一则';
					$next['url']=''.U('Index/noticeshow',array('id'=>$k)).'';
					break;
				}
			}
		}
		$this->assign('next',$next);
		$this->assign('pre',$pre);
		$this->assign('data',$data);
		$this->display();
	}
	public function coin(){
		if(IS_AJAX){
			$money=M('user_coin')->where('num_id="'.session('num_id').'"')->find();
			if(!empty($money)){
				$data['state']=1;
				$data['money']=$money['all_money'];
			}else{
				$data['state']=0;
			}
			$data=json_encode($data);
			echo $data;
		}
	}
}