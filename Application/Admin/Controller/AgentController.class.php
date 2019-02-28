<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Account;
class AgentController extends CommonController {
    public function index(){
		$Model = M('rebate_conf');
		$res = $Model->select();
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
				$this->success('注册成功！', U('Agent/index'));
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
			$Model = M('rebate_conf');
			$where['id'] = $svav['admin_id'];
			if($Model->where($where)->save($svav)){
				$this->success('修改成功！', U('Agent/index'));
			}else{
				$this->error('操作有误！');
			}
		}else{
			$id = I('get.admin_id',0);
			$Model = M('rebate_conf');
			$res = $Model->where('id='.$id)->find();
			$this->assign('res',$res);
			$this->display();	
		}
    }
	
}