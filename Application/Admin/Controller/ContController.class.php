<?php
namespace Admin\Controller;
use Think\Controller;
class ContController extends CommonController {
    public function index(){
		if(IS_POST){
			if(empty($_POST)){
			 echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
			 echo '<script> alert("操作错误。请重新提交"),history.back(); </script>';
			 exit();
			}
			
			$arr = I('post.');
			$f = 0;
			foreach($arr as $key=>$val){
				M('system_conf')->where('id='.$key)->setField('value',$val);
				$f++;
			}
			if(count($arr) == $f){
					echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
					echo '<script> alert("配置信息修改成功");window.location.href="'.U('Cont/index').'";</script>';
					exit();
				}else{
					echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
					echo '<script> alert("操作有误，请重新提交"),history.back();</script>';
					exit();
				}
		}else{
		$Model = M('system_conf');
		$res = $Model->order('id asc')->select();
		$this->assign('res',$res);
		$this->display();
		}
	}
	
}	