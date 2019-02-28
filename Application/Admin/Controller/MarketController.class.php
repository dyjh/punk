<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Redpack;
use Think\Dataapi;
class MarketController extends CommonController {
	//显示比赛
	public function index(){
		
		$start_time    =  empty($_GET['start_time'])  ? strtotime(date('Y-m-d 00:00:00', time()))  : strtotime($_GET['start_time']);
		$end_time  	   =  empty($_GET['end_time'])    ? strtotime(date("Y-m") ." , +1 month")  : strtotime($_GET['end_time']);
		
		
		
		$this->assign('start_time',$start_time);
		$this->assign('end_time',$end_time);
		$this->display();
    }
		
	public function dec_money(){
		print_r($_GET);
		$id=I('get.id');
		$score=I('get.score');
		$type=I('get.type');
		$data=M('game_odds')->where('score="'.$score.'" and game_id='.$id.' and type='.$type.'')->find();
		$this->assign('max',$data['max']);
		$this->display();
	}
	public function res(){
		/*if($_GET['start_time'] == null || $_GET['end_time'] == null){
			   echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
               echo '<script> alert("时间不能为空"),history.back(); </script>';
               exit();
		}*/
		
		$start_time    =  empty($_GET['start_time'])  ? strtotime(date('Y-m-d 00:00:00', time()))  : strtotime($_GET['start_time']);
		$end_time  	   =  empty($_GET['end_time'])    ? strtotime(date("Y-m") ." , +1 month")  : strtotime($_GET['end_time']);

		//传递开始和结束时间参数
		if(isset($start_time) && $end_time){
		   //获取时间段内比赛数据
		   $res = M('game_list')->where('time>='.$start_time.' and time<='.$end_time.' and is_show=0 and state=0')->select();
		   if($res){
			   $this->assign('start_time',$start_times);
			   $this->assign('end_time',$end_times);
			   //echo $url;die;
			   $this->assign('url',$url);
			   $this->assign('res',$res);
			   $this->display('res');			   
		   }else{
			   echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
               echo '<script> alert("没有比赛数据"),history.back(); </script>';
               exit();
		   }
		}
	}	
		
	//放开比赛
	public function show_match(){
	    //接收放开比赛的ID,例：数组形式
		
		if(IS_GET){
		  $arr[] = $_GET['show_ids'];
		  $start_time = $_GET['start_time'];
		  $end_time = $_GET['end_time'];
		}elseif(IS_POST){
		  $arr = $_POST['show_ids'];
		  $start_time = $_POST['start_time'];
		  $end_time = $_POST['end_time'];
		}
		$data['is_show'] = 1;
       	for($i=0;$i<count($arr);$i++){
			if(empty($arr[$i])){
				continue;
			}else{
				if(M('game_list')->where('id='.$arr[$i])->save($data)==false){
					echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
					echo '<script> alert("比赛投注开放失败"),history.back(); </script>';
					exit(); 
			    }
			}
		}
		//$start_time    =  strtotime($_POST['start_time']);
		//$end_time  	   =  strtotime($_POST['end_time']);
		//$url = U('Market/odd_score').'?start_time='.$_POST['start_time'].'&end_time='.$_POST['end_time'];
        //返回结果
		echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
        echo '<script> alert("比赛投注已开放");window.location.href="'.U('Market/odd_score').'";</script>';
        exit();
	}
	
	//设置比分与赔率设置主页
	public function odd_score(){
	    //传递开始和结束时间参数
		
		$start_time    =  time();
		
		if(isset($start_time)){
		    //获取时间段内比赛已经设置过需要显示的数据
			$res = M('game_list')->where('time>='.$start_time.' and is_show=1')->order('time desc')->select();
			if($res){
				 //获取比分配置
				 $score = M('score')->select();
				 //模板数据
				 $this->assign('res',$res); 
                 $this->assign('score',$score);				 
				 $this->display();
			}else{
				echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
                echo '<script> alert("没有比赛数据"),history.back(); </script>';
                exit();
			}
		}else{
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
            echo '<script> alert("开始或结束时间不能为空"),history.back(); </script>';
            exit();
		}
	}
	
	//设置操作
	public function set_odd_score(){

		//需要传递比赛id，比分，最大金额，赔率，类型，
        //      字段名game_id,score,	max_moeny,odds,type[0,1,2]	
		
		
		$data = array();
		$post_list = explode('&',$_POST['data']);	
        for($i=0;$i<count($post_list);$i++){
			$list = explode('=',$post_list[$i]);
			if($list[0]=='odds'){
				$data['odds'] = $list[1]/100;
			}else{
				$data[$list[0]] = $list[1];
			}
		}
		//查看有没有相同比赛相同比分
		if(M('game_list')->where('id="'.$data['game_id'].'" and type=2')->find()){
			 echo 3;//已经设置过
		}else{
			$save['type'] = 2;
		     if(M('game_list')->where('id='.$data['game_id'])->save($save)){
				 echo 1;//添加成功
			 }else{
				 echo 2;//添加失败
			 }	
		}
	}
	
	public function save_odd_score(){
		$data = array();
		$post_list = explode('&',$_POST['data']);	
        for($i=0;$i<count($post_list);$i++){
			$list = explode('=',$post_list[$i]);
			if($list[0]=='pei'){
				$data['odds'] = $list[1]/100;
			}else if($list[0]=='id'){
				$id =  $list[1];
			}else{
				$data[$list[0]] = $list[1];
			}
		}
		//查看有没有当前比分
		if(M('game_odds')->where('id="'.$id.'"')->find()){
			 if(M('game_odds')->where('id='.$id)->save($data)){
				 echo 1;//修改成功
			 }else{
				 echo 3;//修改失败
			 }
		}else{
		     echo 2;//已经设置过 	
		}
	}
	
	//设置操作
	public function set_odd_ajax(){

		//需要传递比赛id，比分，最大金额，赔率，类型，
        //      字段名game_id,score,	max_moeny,odds,type[0,1,2]	
		
		
		$id = I('post.active_id',0,int);
		if($id == 0){
			echo 99; //id不能为空
		}
		//查看有没有相同比赛相同比分
		if(M('game_list')->where('id="'.$id.'" and type=2')->find()){
			 echo 3;//已经设置过
		}else{
			$save['type'] = 2;
		     if(M('game_list')->where('id='.$id)->save($save)){
				 echo 1;//添加成功
			 }else{
				 echo 2;//添加失败
			 }	
		}
	}
	
	//显示比赛
	public function bet(){
		
		$start_time    =  empty($_GET['start_time'])  ? strtotime(date('Y-m-d 00:00:00', time()))  : strtotime($_GET['start_time']);
		$end_time  	   =  empty($_GET['end_time'])    ? strtotime(date("Y-m") ." , +1 month")  : strtotime($_GET['end_time']);
		
		$this->assign('start_time',$start_time);
		$this->assign('end_time',$end_time);
		$this->display();
    }		
	
	//查询历史下注记录
	public function bet_history(){
		$start_time   =  strtotime($_GET['start_time']);
		$end_time  	   =  strtotime($_GET['end_time']);	
		//判断传递数据
		if(empty($start_time) || empty($end_time)){
			 echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
			 echo '<script> alert("时间不能为空"),history.back(); </script>';
			 exit();
		}else{
			 if(!empty($start_time) || !empty($end_time)){
				 if(!empty($_GET['num_id'])){
					 $sql = 'add_time>='.$start_time.' and add_time<='.$end_time.' and num_id="'.$_GET['num_id'].'"';
				 }else{
					 $sql = 'add_time>='.$start_time.' and add_time<='.$end_time;
				 }
				 $array = array();
				 //获取表前缀
				 $fix = M('table_record')->where('name="matching"')->find();
				 for($i=1;$i<=$fix['value'];$i++){
					 $table = $i.'_matching';
					 $res = M("$table")->where($sql)->select();
					 if($res){
						 $array = array_merge($array,(array)$res);
					 }
				 }
				 
				 for($k=0;$k<count($array);$k++){
					 $score = M('game_list')->where('id='.$array[$k]['game_id'])->find();
					 $array[$k]['goscore'] = $score['score'];
					 $array[$k]['half'] = $score['half'];
					 $array[$k]['time'] = $score['time'];
					 $post_list = explode('-',$score['score']);
					 $array[$k]['goal'] = $post_list[0]+$post_list[1];
				 }
				 
				 $this->assign('res',$array);
	             $this->display();			 
			 }else{
				 echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
			     echo '<script> alert("开始时间或结束时间不能为空"),history.back(); </script>';
			     exit();
			 }
		}
	}
	
	//撤退金额主页
	public function undo_data(){
		
		//获取取消或者延期的比赛
		$res = M('game_list')->where('type=2 and is_show in (2,3,4,6)')->select();
		$this->assign('res',$res);
		$this->display();
	}
	
	
	//撤退金额操作
	public function undo_action(){
		M()->startTrans();
	    //传递比赛ID
        $game_id = $_GET['game_id'];
		//查看是否已经处理过
		if(M('game_list')->where('id='.$game_id.' and undo_state>0')->find()){
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
			echo '<script> alert("已经处理过了"),history.back(); </script>';
			exit();
		}
        //获取下注表前缀
        $fix = M('table_record')->where('name="matching"')->find();
		for($i=1;$i<=$fix['value'];$i++){ 
			$table = $i.'_matching';
			$res = M("$table")->where('game_id='.$game_id)->select();
			//如果有数据
			if($res){
				for($j=0;$j<count($res);$j++){
					if(M("$table")->where('num_id="'.$res[$j]['num_id'].'" and game_id="'.$res[$j]['game_id'].'" and type="'.$res[$j]['type'].'" and score="'.$res[$j]['score'].'"')->setField('state',2)==false){
						 M()->rollback();
						 echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
						 echo '<script> alert("状态撤销失败"),history.back(); </script>';
						 exit();
					}
					
					if(M('user_coin')->where('num_id="'.$res[$j]['num_id'].'" and game_id="'.$res[$j]['game_id'].'" and type="'.$res[$j]['type'].'" and score="'.$res[$j]['score'].'"')->setInc('all_money',$res[$j]['principal'])==false){
						 M()->rollback();
						 echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
						 echo '<script> alert("撤销失败"),history.back(); </script>';
						 exit();
					}
				}
			}	
		} 
		
		//改变撤销状态
		$save['undo_state'] = 1;
		if(M('game_list')->where('id='.$game_id)->save($save)){
			M()->commit();
			$this->out_news($game_id);
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
			echo '<script> alert("撤销成功"),history.back(); </script>';
			exit();
		}else{
			M()->rollback();
			echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
			echo '<script> alert("单子撤销失败"),history.back(); </script>';
			exit();
		}		
	}
	
	
	public function odd_index(){
		
		$start_time    =  empty($_GET['start_time'])  ? strtotime(date('Y-m-d 00:00:00', time()))  : strtotime($_GET['start_time']);
		$end_time  	   =  empty($_GET['end_time'])    ? strtotime(date("Y-m") ." , +1 month")  : strtotime($_GET['end_time']);
		
		$this->assign('start_time',$start_time);
		$this->assign('end_time',$end_time);
		$this->display();
    }
	
	
	
	//设置比分与赔率设置主页
	public function odd(){
		
		$start_time    =  empty($_GET['start_time'])  ? strtotime(date('Y-m-d 00:00:00', time()))  : strtotime($_GET['start_time']);
		$end_time  	   =  empty($_GET['end_time'])    ? strtotime(date("Y-m") ." , +1 month")  : strtotime($_GET['end_time']);
		
		if(empty($start_time) && empty($end_time)){
			 echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
			 echo '<script> alert("查询条件不能为空"),history.back(); </script>';
			 exit();
		}
		
		//$start_time = strtotime(date('Y-m-d 00:00:00', time()));
		//$end_time = strtotime(date('Y-m-d 00:00:00', time()))+172800;
		$res = M('game_list')->where('time>"'.$start_time.'" and time<"'.$end_time.'" and is_show=1 and type=2')->order('time asc')->select(); 
			if($res){
				 for($i=0;$i<count($res);$i++){
					 $dd = M('game_odds')->where('game_id='.$res[$i]['id'])->select();
					 $res[$i]['dd'] = count($dd);
						$table = '1_matching';
						$ad = M("$table")->where('game_id='.$res[$i]['id'])->select();
						$ad_2 = M("$table")->where('game_id='.$res[$i]['id'])->sum('principal');
						//$ad_2 = M('game_odds')->where('game_id='.$res[$i]['id'])->sum('max_money');
						$res[$i]['ad'] = count($ad);
						$res[$i]['money'] = $ad_2;
				 }
				 $this->assign('res',$res);			 
				 $this->display();
			}else{
				echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
                echo '<script> alert("没有比赛数据"),history.back(); </script>';
                exit();
			}
	}
	
	public function odd_list(){
		$id = I('get.id');
		$res = M('game_odds')->where('game_id='.$id)->select();
		$fix = M('table_record')->where('name="matching"')->find();
		if($res){
			for($i=0;$i<count($res);$i++){
				$res[$i]['pei'] = $res[$i]['odds']*100;
				for($j=1;$j<=$fix['value'];$j++){ 
				$table = $j.'_matching';
				$xx = M("$table")->where('game_id="'.$res[$i]['game_id'].'" and type="'.$res[$i]['type'].'" and score="'.$res[$i]['score'].'"')->select();
				
				$ll = M("$table")->where('game_id="'.$res[$i]['game_id'].'" and type="'.$res[$i]['type'].'" and score="'.$res[$i]['score'].'"')->sum('principal');
				
				$res[$i]['sel_num'] = count($xx);
				$res[$i]['sel_money'] = $ll;
				}
			}
			$this->assign('res',$res);			
			$this->display('odd_pei');
		}else{
				echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
                echo '<script> alert("没有赔率数据"),history.back(); </script>';
                exit();
			}
		
	}
	
	public function set_odd_list(){
		$id = I('get.id',0,int);
		$score = I('get.score');
		$type = I('get.type',0,int);
		$lie = M('game_odds')->where('game_id="'.$id.'" and type="'.$type.'" and score="'.$score.'"')->find();
		if($lie){
			$res = M('game_list')->where('id='.$id)->find();
			$fix = M('table_record')->where('name="matching"')->find();
			for($j=1;$j<=$fix['value'];$j++){ 
				$table = $j.'_matching';
				$selres = M("$table")->where('game_id="'.$id.'" and type="'.$type.'" and score="'.$score.'"')->select();
				}
			$this->assign('res',$res);
			$this->assign('lie',$lie);
			$this->assign('selres',$selres);
			$this->display('score_list');
		}else{
				echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
                echo '<script> alert("没有赔率数据"),history.back(); </script>';
                exit();
			}
		
	}
	
	public function odd_list_ajax(){
		if(IS_POST){
			$data = array();
			$post_list = explode('&',$_POST['data']);	
			for($i=0;$i<count($post_list);$i++){
				$list = explode('=',$post_list[$i]);
				if($list[0]=='odds'){
					$save['odds'] = $list[1]/100;
				}elseif($list[0]=='max_money'){
					$save['max_money'] = $list[1];
				}elseif($list[0] == 'score'){
					$data[$list[0]] = urldecode($list[1]);
				}else{
					$data[$list[0]] = $list[1];
				}
			}
			$res = M('game_odds')->where('game_id="'.$data['id'].'" and type="'.$data['type'].'" and score="'.$data['score'].'"')->find();
			if($res){
				$odds = $odds/100;
				if(M('game_odds')->where('game_id="'.$data['id'].'" and type="'.$data['type'].'" and score="'.$data['score'].'"')->save($save)){
					echo 1;
				}else{
					echo 3;
				}
			}else{
				echo 2;
			}
		}
	}
	
	//测试专用
	public function ttp(){
		//比赛ID 
		$id = I('get.id',0,int);
		$type = I('get.type',0,int);//0 全场 1半场 2进球数
		//比分数据
		if($type == 2){
			$d = 1;
			for($x=0;$x<4;$x++){
				$whe['game_id'] = $id;
				$whe['score'] = $d;
				$whe['type'] = $type;
				if(M('game_odds')->where($whe)->find()){
					echo "已经该进球数'".$d."'";
					continue;
				}else{
					$add['game_id'] = $id;
					$add['score'] = $d;
					$add['type'] = $type;
					$numbers = rand(50,1000); 
					$ppx = $numbers/1000;
					$add['odds'] = $ppx;
					$money = rand(4000,8000); 
					$add['max_money'] = $money;
					M('game_odds')->add($add);
					$d++;
				}
			}
			
			if($d == 5){
				$q = $d-1;
				echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
				echo '<script> alert("赔率设置成功,总设置'.$q.'个赔率");window.location.href="'.U('Market/odd_list',array('id'=>$id)).'";</script>';
				exit;
			}else{
				echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
				echo '<script> alert("操作错误"),history.back(); </script>';
				exit;
			}
		}else if($type == 0){
			$score = M('score')->select();
			$f = 0;
			$arrpt = $this->max_peilv(0,count($score),$score);
			$arrmo = $this->max_money_2(0,count($arrpt),$arrpt);
			for($i=0;$i<count($arrmo);$i++){
				$whe['game_id'] = $id;
				$whe['score'] = $arrmo[$i]['score'];
				$whe['type'] = $type;
				if(M('game_odds')->where($whe)->find()){
					echo "已经存在比分'".$arrmo[$i]['score']."'";
					continue;
				}else{
					$add['game_id'] = $id;
					$add['score'] = $arrmo[$i]['score'];
					$add['max_money'] = $arrmo[$i]['max_money']*10000;
					$add['type'] = $type;
					$add['odds'] = $arrmo[$i]['odds'];
					M('game_odds')->add($add);
					$f++;
				}
			}
			
			if($f == count($arrmo)){
				echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
				echo '<script> alert("赔率设置成功,总设置'.$f.'个赔率");window.location.href="'.U('Market/odd_list',array('id'=>$id)).'";</script>';
				exit;
			}else{
				echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
				echo '<script> alert("操作错误"),history.back(); </script>';
				exit;
			}
		}else{
			$score[] = array('score'=>'0-1');
			$score[] = array('score'=>'0-2');
			$score[] = array('score'=>'1-2');
			$score[] = array('score'=>'0-0');
			$score[] = array('score'=>'1-0');
			$score[] = array('score'=>'2-0');
			$score[] = array('score'=>'2-1');
			$score[] = array('score'=>'2-2');
			$f = 0;
			$arrpt = $this->max_peilv(1,count($score),$score);
			$arrmo = $this->max_money_2(1,count($arrpt),$arrpt);
			for($i=0;$i<count($arrmo);$i++){
				$whe['game_id'] = $id;
				$whe['score'] = $score[$i]['score'];
				$whe['type'] = $type;
				if(M('game_odds')->where($whe)->find()){
					echo "已经存在比分'".$score[$i]['score']."'";
					continue;
				}else{
					$add['game_id'] = $id;
					$add['score'] = $arrmo[$i]['score'];
					$add['max_money'] = $arrmo[$i]['max_money']*10000;
					$add['type'] = $type;
					$add['odds'] = $arrmo[$i]['odds'];
					M('game_odds')->add($add);
					$f++;
				}
			}
			
			
			
			if($f == count($arrmo)){
				echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
				echo '<script> alert("赔率设置成功,总设置'.$f.'个赔率");window.location.href="'.U('Market/odd_list',array('id'=>$id)).'";</script>';
				exit();
			}else{
				echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
				echo '<script> alert("操作错误"),history.back(); </script>';
				exit;
			}
		}
	}
	
	public function team_score(){
		if(IS_POST){
			$data = array();
			$post_list = I('post.');
				foreach($post_list['odds'] as $k=>$v){
					if(!empty($v)){
						$add[$k]['odds'] = $v/100;
						}
					
				}
				
				foreach($post_list['max_money'] as $k=>$v){
					if(!empty($v)){
						$add[$k]['max_money'] = $v;
						$add[$k]['score'] = $post_list['score'][$k];
						$add[$k]['type'] = $post_list['type'];
						$add[$k]['game_id'] = $post_list['id'];
						}
					
				}
				
				//查看有没有相同比赛相同比分
				$s = 0;
				$g = 0;
				foreach($add as $g=>$l){
					if(M('game_odds')->add($add[$g])){
						$s++;
					 }else{
						$g = 99; 
					 }
				}
				
				if(($s==count($add)) && ($g!==99)){
					$s = $s;
					echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
					echo '<script> alert("赔率设置成功,总设置'.$s.'个赔率");window.location.href="'.U('Market/odd_list',array('id'=>$post_list['id'])).'";</script>';
					exit();
				}else{
					echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
					echo '<script> alert("赔率设置失败,失败'.$s.'个赔率");window.location.href="'.U('Market/odd_list',array('id'=>$post_list['id'])).'";</script>';
					exit();
				}
		}else{
			$id = I('get.id',0,int);
			$res = M('game_list')->where('id='.$id)->find(); 
			$score = M('score')->select();
			$odd = M('game_odds')->where('type=0 and game_id='.$id)->select();
			
			foreach($odd as $key=>$val){
				$add[$val['score']] = $val;
			}
			$this->assign('odd',$add);
			$this->assign('score',$score);
			$this->assign('res',$res);
			$this->display();
		}
	}
	
	
	public function team_score_2(){
			$id = I('get.id',0,int);
			$res = M('game_list')->where('id='.$id)->find(); 
			$score[] = array('score'=>'0-1');
			$score[] = array('score'=>'0-2');
			$score[] = array('score'=>'1-2');
			$score[] = array('score'=>'0-0');
			$score[] = array('score'=>'1-0');
			$score[] = array('score'=>'2-0');
			$score[] = array('score'=>'2-1');
			$score[] = array('score'=>'2-2');
			$score[] = array('score'=>'其他比分');
			$odd = M('game_odds')->where('type=1 and game_id='.$id)->select();
			
			foreach($odd as $key=>$val){
				$add[$val['score']] = $val;
			}
			
			$this->assign('odd',$add);
			$this->assign('score',$score);
			$this->assign('res',$res);
			$this->display();
	}
	
	public function team_score_3(){
			$id = I('get.id',0,int);
			$res = M('game_list')->where('id='.$id)->find();
			$odd = M('game_odds')->where('type=2 and game_id='.$id)->select();
			
			$zuqiu[] = array('score'=>'1');
			$zuqiu[] = array('score'=>'2');
			$zuqiu[] = array('score'=>'3');
			$zuqiu[] = array('score'=>'4');
			
			foreach($odd as $key=>$val){
				$add[$val['score']] = $val;
			}
			$this->assign('odd',$add);
			$this->assign('zuqiu',$zuqiu);
			$this->assign('res',$res);
			$this->display();
	}
	
	public function peilv(){
		$total=80;//总赔率   
		$num=18;// 
		$min=1.5;  
		$redpack = new Redpack($total,$num,$min);
		$jieguo = $redpack->getPack();
		foreach($jieguo as $key=>$val){
			$n = $key+1;
			$f += $val['money'];
			echo '第'.$n.'个赔率：'.$val['money'].' %，计：'.$f.' %<br>';
			
			}
		if($f<=70){
			$this->peilv();
		}else{
			print_r($jieguo);
		}
		
	}
	
	public function max_peilv($type,$cund,$score){
		if($type == 0){
			$cont_odds = M('system_conf')->where('name="random_odds"')->find();
			$list_odds = explode(':',$cont_odds['value']);
			$count_price = $list_odds[1];  
			$mix_price = $list_odds[0];
		}else{
			$cont_odds = M('system_conf')->where('name="half_odds"')->find();
			$list_odds = explode(':',$cont_odds['value']);
			$count_price = $list_odds[1];  
			$mix_price = $list_odds[0];
		}
			
		$gd_rond_num = $cund;
		$rond_num = $cund;
		$added_min = 0.01;
		$added_max = 1;
		$odds_array = array();
		$temp = true;
		$counter = 0;
		$odds_money = 0;


		while($temp){
			 if($odds_money>=$mix_price && $counter>=$gd_rond_num){
				  $temp = false;
			 }else{
				  //计算平均值
				 $average = sprintf("%.2f", $count_price/$rond_num);
				 //随机加减操作
				 $random_oction = rand(0,1);
				 if($random_oction==0){
					 $odds = $average+rand($added_min*100,$added_max*100)/100;
				 }else{
					 $odds = $average-rand($added_min*100,$added_max*100)/100;
				 }
				 
				 //查看赔率是否存在
				 if(in_array($odds,$odds_array)){
					 //不存在则跳出
					 continue;
				 }else{
					 //存在则加入数组
					 array_push($odds_array,$odds);
					 //计数增加
					 $counter++;
					 //轮数减少
					 $rond_num--;
					 //总金额减少
					 $count_price-=$odds;
					 //增量赔率记录
					 $odds_money+=$odds;
				 }
				 
			 }
		}
		//shuffle($odds_array);
		
		if($type == 0){
			$ngg = count($odds_array)-1;
		}else{
			$ngg = count($odds_array);
		}
		
			for($i=0;$i<$ngg;$i++){
			 $add[$i]['score'] = $score[$i]['score'];
			 $add[$i]['odds'] = $odds_array[$i]/100;
			 $f++;
				
			}
			
		if($type == 0){
			$add[$f]['score'] = $score[$f]['score'];
			$add[$f]['odds'] = 0.005;
		}
		
		
	return $add;
	}
	
	public function max_money_2($type,$cund,$score){
		if($type == 0){
			$cont_money = M('system_conf')->where('name="random_money"')->find();
			$list_money = explode(':',$cont_money['value']);
			$count_price = $list_money[1];  
			$mix_price = $list_money[0];
		}else{
			$cont_money = M('system_conf')->where('name="hale_money"')->find();
			$list_money = explode(':',$cont_money['value']);
			$count_price = $list_money[1];  
			$mix_price = $list_money[0];
		}
			
		$gd_rond_num = $cund;
		$rond_num = $cund;
		$added_min = 0.01;
		$added_max = 1;
		$odds_array = array();
		$temp = true;
		$counter = 0;
		$odds_money = 0;


		while($temp){
			 if($odds_money>=$mix_price && $counter>=$gd_rond_num){
				  $temp = false;
			 }else{
				  //计算平均值
				 $average = sprintf("%.2f", $count_price/$rond_num);
				 //随机加减操作
				 $random_oction = rand(0,1);
				 if($random_oction==0){
					 $odds = $average+rand($added_min*100,$added_max*100)/100;
				 }else{
					 $odds = $average-rand($added_min*100,$added_max*100)/100;
				 }
				 
				 
				 //查看赔率是否存在
				 if(in_array($odds,$odds_array)){
					 //不存在则跳出
					 continue;
				 }else{
					 //存在则加入数组
					 array_push($odds_array,$odds);
					 //计数增加
					 $counter++;
					 //轮数减少
					 $rond_num--;
					 //总金额减少
					 $count_price-=$odds;
					 //增量赔率记录
					 $odds_money+=$odds;
				 }
				 
			 }
		}
		//shuffle($odds_array);
			
		if($type == 0){
			$ngg = count($odds_array)-1;
		}else{
			$ngg = count($odds_array);
		}
		
		
		for($i=0;$i<$ngg;$i++){
		 $add[$i]['score'] = $score[$i]['score'];
		 $add[$i]['odds'] = $score[$i]['odds'];
		 $add[$i]['max_money'] = $odds_array[$i];
		 $f++;
		 }
		 
		if($type == 0){	
			$add[$f]['score'] = $score[$f]['score'];
			$add[$f]['odds'] = $score[$f]['odds'];
			$add[$f]['max_money'] = $odds_array[$f];
		}
		
		return $add;
	}
	
	
	public function game_betting(){
		$id = I('get.id',0,int);
		$list = M('game_list')->where('id='.$id)->find();
		
		$fix = M('table_record')->where('name="matching"')->find();
		$max_principal = 0;
		$max_interest = 0;
		
			$f = $fix['value'];
			$all = array();
			for ($i=0;$i<$fix['value'];$i++){
			$reba = $f.'_matching';
			$prin = M($reba)->where('game_id='.$id)->order('add_time desc')->select();
			$all = array_merge($all , (array)$prin);
			$f--;
			 }
			 
			for($f=0;$f<count($all);$f++){
			$sel_odds = M('game_odds')->where('game_id="'.$id.'" and score="'.$all[$f]['score'].'" and type="'.$all[$f]['type'].'"')->find();
			$all[$f]['odds'] = $sel_odds['odds'];
			if($all[$f]['state'] == 2){
				continue;
			}else{
				$max_principal += $all[$f]['principal'];
				$max_interest += $all[$f]['interest'];
			}
			
			
		}
			 
		$this->assign('list',$list);
		$this->assign('res',$all);
		$this->assign('max_principal',$max_principal);
		$this->assign('max_interest',$max_interest);
		$this->display();
	}
	
	
	public function manual_refresh(){
		$id=_safe(I('get.id'));
		$check=M('game_list')->where('id='.$id.'')->find();
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
				//$game_list['undo_state']=0;
			}elseif($state*-1==13){
				$game_list['is_show']=4;
				//$game_list['undo_state']=0;
			}elseif($state*-1==11){
				//echo $state*-1;
				$game_list['is_show']=5;
				//$game_list['undo_state']=0;
			}elseif($state*-1==14){
				$game_list['is_show']=3;
				//$game_list['undo_state']=0;
			}elseif($state*-1==10){
				$game_list['is_show']=6;
				//$game_list['undo_state']=0;
			}
			//print_r($game_list);die;
			//$check=M('game_list')->where('id='.$id.'')->find();
			
			//echo $id;
			if($check['state']!=4&&$check['is_show']<=1){
				//var_dump($state);
				//print_r($game_list);
				if(M('game_list')->where('id='.$id.' AND state!=5')->save($game_list)!==false){
					//echo 'succsee'.$id.'<br>';
					if($check['undo_state']==0&&$state*-1>=10){
						$this->undo_action($id);
					}
				}
				
			
				
			}
		}else{
				echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
				echo '<script> alert("该比赛状态正常"),history.back(); </script>';
				exit;
		}
	}
	
	private function out_news($game_id){
		$game=M('game_list')->where('id='.$game_id.' AND is_show>1')->find();
		if($game['state']==3){
			$text='全场波胆已取消，半场正常结算，请知晓！';
		}
		if($game['state']<=2){
			$text='所有注单无效';
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
			
			M('information')->add($add);
		}
	}
	
	public function the_del(){
		if(IS_POST){
			$id = I('post.active_id',0,int);
			$save['is_show'] = 2;
			M()->startTrans();
			if(M('game_list')->where('id='.$id)->save($save)){
				if(M('game_odds')->where('game_id='.$id)->select() == false){
					M()->commit();
					echo 1;
				}else{
					if(M('game_odds')->where('game_id='.$id)->delete()){
					M()->commit();
					echo 1;
					}else{
						M()->rollback();
						echo '赔率操作错误';
					}
				}
			}else{
				M()->rollback();
				echo '比赛操作错误';
			}
		}
	}

  }
