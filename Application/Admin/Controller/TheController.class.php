<?php
namespace Admin\Controller;
use Think\Controller;
class TheController extends CommonController {
    public function index(){
		$Model = M('information');
		$res = $Model->order('id desc')->select();
		$f = 0;
		for ($i=0;$i<count($res);$i++){
		 $res[$i]['cont'] = htmlspecialchars_decode(htmlspecialchars_decode($res[$i]['content']));
		 //$res[$i]['content'] = showShort($res[$i]['cont'],30);
		 $f++;
		} 
		$this->assign('res',$res);
		$this->display();
	}
	
	public function add(){
		if(IS_POST){
			$add = I('post.');
			$add['time'] = time();
			$add['is_show'] = 1;
			if(M('information')->add($add)){
					$this->success('发布成功',U('The/index'));
			}else{
				$this->error('发布失败');
			}
		}else{
			$this->display();
		}
	}
	
	public function edit(){
		if(IS_POST){
			$save = I('post.');
			if(M('information')->where('id='.$save['id'])->save($save)){
					$this->success('修改成功',U('The/index'));
			}else{
				$this->error('修改失败');
			}
		}else{
			$id = I('get.admin_id');
			$Model = M('information');
			$res = $Model->where('id='.$id)->find();
			$this->assign('res',$res);
			$this->display();
		}
	}
	
	public function the_ajax(){
		if(IS_POST){
			$id = I('post.id',0,int);
			$start = I('post.start',0,int);
			if(M('information')->where('id='.$id)->setField('is_show',$start)){
				$start==1?$ru=1:$ru=2;
				echo $ru;
			}else{
				echo 0;
			}
		}
	}
	
	public function the_del(){
		if(IS_POST){
			$id = I('post.active_id',0,int);
			if(M('information')->where('id='.$id)->delete()){
				echo 1;
			}else{
				echo '操作错误';
			}
		}
	}
	
}	