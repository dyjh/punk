<?php
namespace Admin\Controller;
use Think\Controller;
class CommController extends CommonController {
	
	
    public function index(){
		$Model = M('table_record');
		$rebate = $Model->where('id=5')->find();
		$f = $rebate['value'];
		for ($i=0;$i<$rebate['value'];$i++){
		 $reba = $f.'_rebate_commission';
		 $bate = M($reba)->order('id desc')->select();
		 $res[$i] = $bate;
		 $f--; 
		}
		$this->assign('res',$res);
		$this->display();
	}		
	
	public function do_c(){	
			
			$LogPath   = APP_PATH . "Runtime/CashLog/"   . date("Y-m") . "/" . date("d") . "/";	
			
			$asynNotifyUrl = explode("/",$_POST['asynNotifyUrl']);
			$_P  = $asynNotifyUrl[7];
			$post_sign = $asynNotifyUrl[9];
		
			//验证    
			$param = explode("_",$_P);
			
			$order_record = $param[0];
			$id 		  = $param[1];
			$order_num 	  = $param[2];
			$time 		  = $param[3];
				
			$sign = md5($order_record.$id.$order_num.$time."QHP"); 
			
			// 查询该订单
			$cash_order_where['id'] 		  = $id;
			$cash_order_where['order_num']    = $order_num;
			$cash_order_where['submit_time']  = $time;
			$cash_order_where['state']		  = 9;
			$cash_order_where['cash']		  = 0;
			
			$table = $order_record.'_order_list';	
			$order_info = M($table)->where($cash_order_where)->find();
			
			if($sign !== $post_sign || !$order_info ){		
				$data['state'] = 0;             
				$data['content'] = '请求错误';        
				echo json_encode($data);              
				exit;			  		
			}		  	
				  
			// 查询代付订单状态
			
			$param['pay_mode'] = '00020';
			$param['signType'] = 'MD5';
			$param['prdOrdNo'] = $order_info['order_num'];
			import('Vendor.PayApi.three');

			$PayApi   = new \PayApi();
			$cash_res = $PayApi->OrderStatusQuery_cash($param);
			
			foreach($cash_res as $key=>$val){
				$string .= $key . ":" . $val ." --- " ;				
			}
			
			file_put_contents( $LogPath . $order_info['user'] . ".log",date("H:i:s")  . "---" . $string  . "\r\n" ,FILE_APPEND) ;
		
			if($cash_res['orderstatus']=='01' && $cash_res['retCode']==1){
				$save['state'] 		  = 1;	
				$save['confirm_time'] = time(); 
				$save['usrPayAmt'] = $cash_res['ordamt']/100; 
				
				if(M($table)->where($cash_order_where)->save($save)){		
					$data['state'] = 1;           
					$data['content'] = '处理成功';       
					// echo json_encode($data);	
					echo "SUCCESS";
					DIE;
				}else{			
					$data['state'] = 0;   
					$data['content'] = '处理失败';      
					echo json_encode($data);		
				} 	
			}elseif($cash_res['orderstatus']== '14' || $cash_res['orderstatus']=='22'){
				
				$save['state'] 		  = 8;	
			
				M($table)->where($cash_order_where)->save($save);
				echo json_encode($cash_res);
				die;
			}
		

	}
	
}	