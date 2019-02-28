<?php
namespace Admin\Controller;
use Think\Controller;
class OrderController extends CommonController {
    	
	private $limit = 15;
	
	public $http_type = "http";
	
	protected $Bank_Info = array(
		"工商银行"=>array("中国工商银行","ICBC","102"),
		"中国工商银行"=>array("中国工商银行","ICBC","102"),
		"农业银行"=>array("中国农业银行","ABC" ,"103"),
		"中国农业银行"=>array("中国农业银行","ABC" ,"103"),
		"中国银行"=>array("中国银行"	,"BOC" ,"104"),
		"建设银行"=>array("中国建设银行","CCB" ,"105"),
		"中国建设银行"=>array("中国建设银行","CCB" ,"105"),
		"邮储银行"=>array("中国邮政储蓄银行","PSBC" ,"403"),
		"中国邮储银行"=>array("中国邮政储蓄银行","PSBC" ,"403"),
	);
	
	protected function Get_Global_Config($is_cache=false){
		$is_cache = false;
		if( ($Global_Config = S('Global_Config')) && $is_cache ){
			return $Global_Config;
		}
		
		$Global_Config = M("system_conf")->where("is_use=1")->select(array("index"=>"name"));
		
		S('Global_Config',$Global_Config, 24 * 3600 );

		return $Global_Config;			
		
	}
			
	public function index(){		
		$this->pay_list();		
		$this->assign("pay_method",true);
		$this->assign("order_tyoe","充值");
		$this->assign('Q_TOKEN',creatToken());
		$this->display();		
    }
  
	public function cash(){		
		$this->pay_list("0");		
		$this->assign("is_export",true);
		$this->assign('Q_TOKEN',creatToken());
		$this->assign("order_tyoe","提现");
		$this->display("index");
    }
  
	//订单
    public function pay_list ($is_cash='1'){
		
		$get_data = $_GET;
		
		$page = $get_data['refresh'] ? 1 : intval(I("get.page",1,'addslashes'));
		unset($get_data['page'],$get_data['refresh']);
		
		$start_time    =  empty($_GET['start_time'])  ? strtotime( date("Y-m") )  : strtotime($_GET['start_time']);
		$end_time  	   =  empty($_GET['end_time'])    ? strtotime(date("Y-m") ." , +1 month")  : strtotime($_GET['end_time']);
		
		$get_data['start_time'] =  date("Y-m-d",$start_time);
		$get_data['end_time']   =  date("Y-m-d",$end_time);
		
		$get_data['submit_time']=  array("between",array($start_time,$end_time));
		
		$order_where = $this->get_order_where($get_data);
		$order_where['cash'] = $is_cash;
		
		$Order = $this->GetOrderList($page,$order_where,$this->limit);
		
		$order_count = $Order['order_count'];
	
		$page_css = get_page_five($order_count,$this->limit,$page,"Order/index",$get_data);	
		
		$param['page'] =$page;
		
		$this->assign("order_list",$Order['order_list']);
		$this->assign("Order",$Order);
		$this->assign("page",$page_css);
		$this->assign("get_data",$get_data);
		$this->assign("param",$param);
		$this->assign("is_cash",$is_cash);
		
		$data = $this->fetch("pay_list");
		
		if($get_data['is_export'] && $Order['order_list']){
			
			$order_list = $Order['order_list'];
			
			import('Vendor.PayApi.three');

			$PayApi = new \PayApi();
			 
		
			foreach($order_list as $key=>$add){
				// print_r($add);die;
				$cash_order = $add['id'];
				$max = $add['order_record'];
				$user_bank = explode("---",$add["bank"]);
				$bank_info = $this->Bank_Info[$user_bank[0]];
				$sign = md5($max  . $cash_order . $add['order_num'] . $add['submit_time'] . "QHP"); 
				
				$param = array();
				$param = $add;
				$member = M('members')->where('user="'.$add['user'].'"')->find();
				if(!$member)continue;
				$param["pay_mode"]   	= "00020";			
				$param["customerName"]  = $member['name'];
				$param["cerdId"]  		= trim(getIDcrad());
				$param["rcvBranchCode"] = $bank_info[2];
				$param["accBankName"] 	= $user_bank[0];
				$param["bankBranch"] 	= $user_bank[1];
				
				$url['p']  = $max  . "_" . $cash_order . "_" . $add['order_num'] . "_" . $add['submit_time'] ; 
				$url['s']  = $sign;
				$param["asynNotifyUrl"] = $this->http_type ."://" . $_SERVER["HTTP_HOST"].U("Admin/Comm/do_c",$url);
				// print_r($param);
				// die;
				$do_cash_res = array();
				// 发起提现申请
				$do_cash_res = $PayApi->WithdrawApply($param);
				
				// print_r($do_cash_res);
				
				// die;
				
				if($do_cash_res['prdOrdNo']){
					$save_data_order_list = array(
							"platmerord"=>$do_cash_res['prdOrdNo'],						
							"qrcode"	=>$param["asynNotifyUrl"],						
							"state"		=>"9",						
							"confirm_time"=>time(),						
						);
					$res_order[] = M($max.'_order_list')->where(array("id"=>$cash_order))->save($save_data_order_list);
				}
				
				if($do_cash_res['retCode']=='1518005'){
					$save_data_order_list = array(
						"qrcode"	=>$param["asynNotifyUrl"],						
						"state"		=>"9",						
						"confirm_time"=>time()-3600*6,						
					);
					$res_order[] = M($max.'_order_list')->where(array("id"=>$cash_order))->save($save_data_order_list);
				}	
				
			}		
			
			header('content-type:text/html; charset = utf-8');
			echo '<script>alert("成功'.count($res_order).'条");window.location="'.U("").'"</script>';
	
			// $this->redirect(U(""));
			die;
			
		}
		
		if(IS_AJAX){
			$back_arr['status'] = 'ok';
			$back_arr['inner_html'] = $data;
			echo json_encode($back_arr);
			die;
		}
		return $data;
	}
	
	//修改提现订单状态
	public function EditOrderInfo(){
		
		if( !checkToken($_POST['Q_TOKEN']) ){
			$datas['state']=0;
			$datas['msg']= '当前页已失效。请刷新或重新登录。'; 
			echo json_encode($datas);
			die;
		}
		
	}
	
	//
	// 获取订单查询的条件
	protected function get_order_where($get_data){
		
		foreach($get_data as $key=>$val){
			
			switch ($key){
				case "state":
					$order_where[$key] = do_order_state($val);
					
					break;
				case "submit_time":
					$order_where[$key] = $val;
					break;	
				case "pay_method":
					$order_where["method"] = $val;
					break;	
				case "phone":
					$order_where["user"] = array("like","%".$val."%");
					break;	
				case "order":
					$order_where["order_num"] = array("like","%".$val."%");
					break;
				case "export_id":
					$order_where["id"] = array("in",$val);		
					break;	
				default:
					break;
			}
			
		}
		
		return array_filter($order_where);
		
	}
		
	// 查询 订单列表
	/**
	 * TODO 查询 订单列表
	 * @param int $page  当前页数
	 * @param int $limit 分页条数
	 * @param array $order_where  查询条件
	 * @return OrderList
	 */
	private function GetOrderList( $page , $order_where ,$limit ){
		
		$order_record  = M("table_record")->where(array("name='order_list'"))->getfield("value");
		
		foreach($order_where as $key=>$val){
			$o_order_where["o.".$key] = $val;
		}
		
		FOR($record = $order_record-1 ; $record >0; $record--){
			
			$order_table = "{$record}_order_list";
			$order_alias = "{$record}_o";
			$order_field = "{$order_alias}.id,order_num,{$order_alias}.user,handling,{$order_alias}.bank_province,{$order_alias}.bank_city,method,money,state,m.name,{$order_alias}.bank,{$order_alias}.bank_number,{$order_alias}.submit_time,{$order_alias}.confirm_time,{$record} as order_record";
			$Order_join = " right join __MEMBERS__ m on m.user={$order_alias}.user";
			$where = "{$order_alias}_order_where";
			foreach($order_where as $key=>$val){
				${$where}[$order_alias.".".$key] = $val;
			}
		 
			$count_field = " count(".$order_alias.".id)";
			// $sql[] = M($order_table)->alias($order_alias)->join($Order_join)->field($order_field)->where(${$where})->buildSql();
			$sql[] 		 = M($order_table)->alias($order_alias)->join($Order_join)->field($order_field)->where(${$where})->buildSql();
			$sql_count[] = M($order_table)->alias($order_alias)->join($Order_join)->field($count_field)->where(${$where})->limit(1)->buildSql();
			
			
		}
		$count_field_str = implode("+",$count_field);
		
		$Order['table'] = "{$order_record}_order_list";
		$order_field = "o.id,order_num,o.user,handling,method,money,state,o.bank_province,o.bank_city,m.name,o.bank,o.bank_number,o.submit_time,o.confirm_time,{$order_record} as order_record";
		$Order_join = " right join __MEMBERS__ m on m.user=o.user";
		
		$Order['order_sql']  = substr(M($Order['table'])->alias('o')->join($Order_join)->field($order_field)->union($sql,true)->where($o_order_where)->buildSql() , 1, -1);
		// $Order['order_list']  = M($Order['table'])->alias('o')->join($Order_join)->field($order_field)->union($sql,true)->where($o_order_where)->order("o.state asc ,o.id desc")->limit(($page-1), $limit)->select();
		
		$Order['order_list'] = M()->query($Order['order_sql'] . " order by submit_time desc limit ".($page-1).",".$limit."");
		
		$count_field_all = $count_field_str ? "count(o.id)+".$count_field_str : "count(o.id)";
		
		$count_field = "count(o.id) as all_count ,sum(o.money) as all_money , sum(if((o.state=1),o.money,null)) as com_money,sum(if((o.state=0),o.money,null)) as not_money , count(if((o.state=1),o.id,null)) as com_count , count(if((o.state=0),o.id,null)) as not_count ";
		$order_count =M($Order['table'])->alias('o')->join($Order_join)->field($count_field)->union($sql_count,true)->where($o_order_where)->select();
		  
		//  将总数相加
		foreach($order_count as $val){
			$Order['all_count']   += $val['all_count'];
			$Order['com_count']   += $val['com_count'];
			$Order['not_count']   += $val['not_count'];
			$Order['all_money']   += $val['all_money'];
			$Order['com_money']   += $val['com_money'];
			$Order['not_money']   += $val['not_money'];
		}
		$Order['order_count'] = $Order['all_count'];
		// echo M()->getLastSQL();
		// print_r($order_count); 
		// print_r($Order);
		// die;
		return $Order;	
	}
	
	
	//提现相关操作
	public function extract(){
		
	   if(IS_POST){
		  //验证
          foreach($_POST as $v){
			 if(!is_numeric($v*1)){
				 $data['state'] = 0;
                 $data['content'] = '请求错误';
                 echo json_encode($data);
                 exit;				 
			 }
		  }	
		  //表名
		  $table = $_POST['fix'].'_order_list';
		  $save['state'] = $_POST['cases'];	
		  $save['confirm_time'] = time(); 
		  $sql = 'id='.$_POST['id'].' and order_num="'.$_POST['order_num'].'"';		  
		  if(M("$table")->where($sql)->save($save)){
			  $data['state'] = 1;
              $data['content'] = '处理成功';
              echo json_encode($data);	
		  }else{
			  $data['state'] = 0;
              $data['content'] = '处理失败';
              echo json_encode($data);	
		  } 
	   }
	}

	public function back_money(){
		
		$order_alias = "o";
		$where[$order_alias.'.id'] 		= (int)$_POST['order_id'];
		$where['order_num'] = _safe($_POST['order_num']);
		$where['state'] 	= 7;
		
		
		$Order_join = " right join __MEMBERS__ m on m.user={$order_alias}.user";
		$order_field = "money,m.num_id";
		
		$order_info  = M((int)$_POST['order_record']."_order_list")->alias($order_alias)->field($order_field)->join($Order_join)->where($where)->find();
		 
		if($order_info ){
			M()->startTrans();
			$exchange_rate = M("system_conf")->where(['name'=>"exchange_rate"])->getfield("value");
			
			$exchange_rate_arr = explode(":",$exchange_rate);
			$exchange_rate 	   = $exchange_rate_arr[0]/$exchange_rate_arr[1];
			$back_moeny_count = $order_info["money"]  * ($exchange_rate_arr[0]/$exchange_rate_arr[1]) ;
			
			$save_user_data = ["all_money"=>['exp','all_money+'.$back_moeny_count]];
			
			$res_user = M("user_coin")->where(array("num_id"=>$order_info['num_id']))->save($save_user_data);
			
			$res_order= M((int)$_POST['order_record']."_order_list")->alias($order_alias)->where($where)->save(['state'=>'8']);
			
			if($res_user && $res_order){
				M()->commit();
				$data['status']  = 1;
				$data['message'] = "退回成功";
				$data['order_num'] = $where['order_num'];
				echo json_encode($data);
				die;
			}else{
				M()->rollback();
				$data['status']  = 0;
				$data['message'] = "退回失败";
				$data['order_num'] = $where['order_num'];
				echo json_encode($data);
				die;
			}
		} 
		
		echo '没有该订单';
		die;
		
	}
	
	function get_new_cash(){
		
		$table_record = M("table_record")->where(['name'=>"order_list"])->getfield("value");
		$where['state'] = 0;
		$where['cash']  = 0;
		$is_order = M((int)$table_record."_order_list")->where($where)->find();
		// echo M()->getLastSQL();
		if($is_order){
			echo 1;
			die;
		}
		die;
	}
	
	public function refresh_order(){
		
		$where['id'] 		= (int)$_POST['order_id'];
		$where['order_num'] = _safe($_POST['order_num']);
		$where['state'] 	= 9;
		$table = (int)$_POST['order_record']."_order_list";
		$order_info  = M($table)->where($where)->find();
		
		  	
		// 查询代付订单状态
		$param['pay_mode'] = '00020';
		$param['prdOrdNo'] = $order_info['order_num'];
		import('Vendor.PayApi.three');

		$PayApi   = new \PayApi();
		$cash_res = $PayApi->OrderStatusQuery_cash($param);
		
		foreach($cash_res as $key=>$val){
				
			$string .= $key . ":" . $val ." --- " ;
			
		}
		
		$LogPath   = APP_PATH . "Runtime/CashLog/"   . date("Y-m") . "/" . date("d") . "/";
		
		if (!is_dir($LogPath)){mkdir($LogPath, 0777 ,true);}
		
		file_put_contents($LogPath . $order_info['user'] . ".log",date("H:i:s") . "---" . $string ."\r\n" ,FILE_APPEND) ;
	
		if($cash_res['orderstatus']=='1' && $cash_res['retCode']==1){
			$save['state'] 		  = 1;	
			$save['confirm_time'] = time(); 
			$save['usrPayAmt'] = $cash_res['ordamt']/100; 
			 
			if(M($table)->where($where)->save($save)){		
				$data['status'] = 1;           
				$data['message'] = '处理成功';   
				$data['order_num'] = $order_info['order_num']; 				
				echo json_encode($data);		
			}else{			
				$data['status'] = 0;   
				$data['message'] = '处理失败';      
				echo json_encode($data);		
			} 	
		}elseif($cash_res['orderstatus']== '14' || $cash_res['orderstatus']=='22'){
			
			$save['state'] 		  = 8;	
		
			M($table)->where($where)->save($save);
			
			$data['status'] = 0;   
			$data['message'] = '处理失败'; 
			
			echo json_encode($data);
			die;
		}
		else{
			
			$data['status'] = 0;   
			$data['message'] = '处理中，请稍后'; 
			
			echo json_encode($data);
			die;
		}
		
	}
		
}