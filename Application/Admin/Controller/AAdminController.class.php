<?php
namespace Admin\Controller;
use Think\Controller;
class AAdminController extends CommonController {
    public function index(){
		if(IS_POST){
			$Admin = I('post.');  
			$Is=_safe($Admin['password']);            			
			$I_sd=_safe($Admin['sd_password']);						
			$dataadmin=_safe($Admin['user']);						
			$key = 'IH^&*%56&ll'.$dataadmin;					
			$I = access_md16( $Is , $key );				
			$data['password'] = access_md16( $I_sd , $key );				
			$res = M('admin')->find();
			if($I == $res['password']){
				if(M('admin')->where('id=1')->save($data)){
					$this->success('修改成功,请重新登陆',U('Index/index'));
				}else{
					$this->error('参数错误！');
				}
			}else{
				$this->error('操作失败');
			}
		}else{
			$Model = M('Admin');
			$res = $Model->find();
			$this->assign('res',$res);
			$this->display();
		}
	}
	
}	