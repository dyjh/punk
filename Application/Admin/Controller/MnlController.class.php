<?php
namespace Admin\Controller;
use Think\Controller;
class MnlController extends CommonController {
    public function index(){
		$res = M('game_list')->where('mnl=1')->order('time desc')->select();
		$this->assign('res',$res);
		$this->display();
	}
	
	public function odd_score(){
		if(IS_POST){
			//print_r($_POST);
			$add['area'] = I('post.area',0,addslashes);
			$add['team_first'] = I('post.team_first',0,addslashes);
			$add['team_second'] = I('post.team_second',0,addslashes);
			$start_time   =  strtotime($_POST['time']);
			$add['time'] = $start_time;
			$add['mnl'] = 1;
			
			$id = $this->add_id();
			$sec = M('game_list')->where('id='.$id)->find();
			if($sec){
				$this->odd_score();
			}else{
				$add['id'] = $id;
				if(M('game_list')->add($add)){
					echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
					echo '<script> alert("添加成功");window.location.href="'.U('Mnl/index').'";</script>';
					exit();
				}else{
					echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
					echo '<script> alert("操作失败");window.location.href="'.U('Mnl/odd_score').'";</script>';
					exit();
				}
			}
			
		}else{
			
		$start_time    =  empty($_GET['start_time'])  ? strtotime( date("Y-m") )  : strtotime($_GET['start_time']);

		$this->assign('start_time',$start_time);
		 $this->display();	
		}
		
		
	}
	
	public function add_id(){
			$endtime=1356019200;//2012-12-21时间戳
			$curtime=time();//当前时间戳
			$newtime=$curtime-$endtime;//新时间戳
			$ssd=substr($newtime,5);
			$rand=rand(0,99);//两位随机
			$all=$rand.$ssd;
			return $all;
	}
	
	public function score(){
		if(IS_POST){
		$add = I('post.');
		$ay = array();
		if($add['start'] == 1){
			$bc = M('game_list')->where('id='.$add['id'])->find();
			if(empty($bc['half'])){
				if($add['score_1'] == ''){
					$ay['half'] = $add['score_2'];
				}else{
					$ay['half'] = $add['score_1'];
				}
				
				$ay['state'] = 2;
				
				if(M('game_list')->where('id='.$add['id'])->save($ay)){
					echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
					echo '<script> alert("半场比分更新成功");window.location.href="'.U('Mnl/index').'";</script>';
					exit();
				}else{
					echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
					echo '<script> alert("操作失败");window.location.href="'.U('Mnl/odd_score').'";</script>';
					exit();
				}
			}else{
					echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
					echo '<script> alert("请不要重复设置");window.location.href="'.U('Mnl/index').'";</script>';
					exit();
			}
		}else{
			if($add['score_1'] == ''){
					$ay['score'] = $add['score_2'];
				}else{
					$ay['score'] = $add['score_1'];
				}
				
				$ay['state'] = 4;
				
			if(M('game_list')->where('id='.$add['id'])->save($ay)){
					echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
					echo '<script> alert("全场比分更新成功");window.location.href="'.U('Mnl/index').'";</script>';
					exit();
				}else{
					echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
					echo '<script> alert("操作失败");window.location.href="'.U('Mnl/odd_score').'";</script>';
					exit();
				}
		}
				
				
		}else{
			$ge = I('get.');
			$geres = M('game_list')->where('id='.$ge['id'])->find();
			$score = M('score')->select();
			$this->assign('score',$score);			
			$this->assign('ge',$ge);
			$this->assign('re',$geres);
			$this->display();	
		}
		
		
	}
	
}	