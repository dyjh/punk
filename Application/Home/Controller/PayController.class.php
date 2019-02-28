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
use Think\Controller;

class PayController extends Controller
{
	
	public function team_logo(){
		 
		
	  
	
	

		 
		 //echo 2;die;
		$data=new Dataapi();
        $res=$data->post_sms('Team_XML.aspx','');
		$reader = new \XMLReader();
		$reader->XML($res);
		//echo 111;die;
		//$assoc = $this->xml2assoc($xml);
		
		//$countElements = 0;   
  //echo 111;
		
		//$xml->close();
		//echo 222;
		//$result=simplexml_load_string($res, 'SimpleXMLElement', LIBXML_NOCDATA);
		/*$result=json_encode($result);
		$result=json_decode($result,true);*/
		
		
		
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
						/*case 'addr':   
							$team[$i]['addr'] = $reader->value;   
							break;
						case 'URL':   
							$team[$i]['URL'] = $reader->value;   
							break;*/
					}   
				}
				if(count($team[$i])==3){
					$i++;
				}

		 } 

         var_dump($team);		 
	
		$reader->close();   
	
		foreach($team as $key=>$val){
			$data=M('game_list')->where('id_first='.$val['id'].' or id_second='.$val['id'].'')->select();
			foreach($data as $k=>$v){
				if($v['id_first']==$val['id']){
					$save['img_first']=$val['Flag'];
				}elseif($v['id_second']==$val['id']){
					$save['img_second']=$val['Flag'];
					
				}
				
				
				
				//M('game_list')->where('id='.$v['id'].'')->save($save);
			}
			
		}
		
		
		
		//echo 222;
		
		
		/*$data=array();
		foreach($result as $val){
			$data['game']
		}*/
	}
	
	
	
	
	
	
	public $http_type = "http";
	
	private $LogPath = "";
	private $ImagePath = "";
	protected $Pay_method  = array(
		// "alipay"	=>array("yifu" ,'QuickPay'    ,"alipay" ,"YiFuPayBack"), 
		"qq"		=>array("three",'ScanPayApply','00032'  ,"ScanPayBack","verify"=>array("order_num"=>"prdOrdNo","platmerord"=>"payId")), 
		"qqwap"		=>array("three",'PayApply'	  ,'00033'  ,"ScanPayBack","verify"=>array("order_num"=>"prdOrdNo")), 
		"linebank"	=>array("three",'BankApply'	  ,'00020'  ,"ScanPayBack","verify"=>array("order_num"=>"prdOrdNo")), 
		// "wx"	=>array("three",'PayApply'	  ,'00025'  ,"ScanPayBack"), 
	);
	protected $Pay_bank = array(
		  '103'=>'农业银行','104'=>'中国银行','105'=>'建设银行','301'=>'交通银行','303'=>'光大银行','304'=>'华夏银行','305'=>'民生银行',
		  '306'=>'广发银行','307'=>'平安银行','308'=>'招商银行','309'=>'兴业银行','310'=>'浦发银行','325'=>'上海银行','403'=>'邮储银行',
		   "102"=>"工商银行",
		 );
	
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
	
	protected $Url = "http://punkfc.com";
	
	function __construct(){
		
		parent::__construct();
		$this->LogPath   = APP_PATH . "Runtime/PayLog/"   . date("Y-m") . "/" . date("d") . "/";
		$this->ImagePath = APP_PATH . "Runtime/PayImage/" . date("Y-m") . "/" . date("d") . "/";
	
		if (!is_dir($this->LogPath)){mkdir($this->LogPath, 0777 ,true);}
		$this->assign('Pay_bank',$this->Pay_bank);
		// print_r($this->Pay_bank);die;
	}
	
	public function recharge(){
		//echo phpinfo();die;
		$this->check_sess();
		$build=new Builddata();
        $build->build_order_list();
		
		$data=M('members')->where('num_id="'.session('num_id').'"')->find();
			$money=M('user_coin')->where('num_id="'.session('num_id').'"')->find();
			$this->assign('money',$money['all_money']);
			$this->assign('num_id',$data['num_id']);
			$this->assign('Q_TOKEN',creatToken());
			$this->assign('data',$data);
		
		$this->display();
	}
	
	public function extract_money(){
		$this->check_sess();
		//接收提现数据
		if( IS_AJAX ){
			
			$q_is_cash =M('system_conf')->where('name="is_cash"')->getfield("value");
			if($q_is_cash != "1"){
				$res['state']=-1;
				$res['msg']='通道维护中，请稍后';
				$res=json_encode($res);
				echo $res;
				exit;
			}
				
			$money=_safe(I('post.money'));
			$pass=_safe(I('post.password'));
			$bank=_safe(I('post.bank'));
			$bank_number=_safe(I('post.bank_number'));
			$bank_province=_safe(I('post.bank_province'));
			$bank_city=_safe(I('post.bank_city'));
			$name=_safe(I('post.name'));
			$member=M('members')->where('num_id="'.session('num_id').'"')->find();
			
			$key = 'IH^&*%545qg'.$member['user'];
			$pass = access_md16( $pass , $key );
			//echo $pass;die;
			if($pass!=$member['trade_password']){
				$res['state']=-1;
				$res['msg']='二级密码错误';
				$res=json_encode($res);
				echo $res;
				exit;
			}
			$conf=M('system_conf')->where('name="cash_withdrawal_com"')->find();
			$odds=$conf['value'];
			$check_money=(1+$odds)*$money;
			$coin=M('user_coin')->where('num_id="'.session('num_id').'"')->find();
			if($coin['all_money']<$check_money){
				$res['state']=-1;
				$res['msg']='余额不足';
				$res=json_encode($res);
				echo $res;
				exit;
			}
			if(empty($bank_city)||empty($bank_province)){
				$res['state']=-1;
				$res['msg']='信息不足';
				$res=json_encode($res);
				echo $res;
				exit;
			}
			
			$conf_money=M('system_conf')->where('name="exchange_rate"')->find();
			$odds_money=explode(':',$conf_money['value']);
			$money_new=$money*$odds_money[1];
			// $money_new='5';
			
			M()->startTrans();
			$add['submit_time']=time();
			$add['order_num']=date("YmdHis",$add['submit_time']) . str_shuffle(  session('user') ) . rand(1000,9999);
			$add['cash']=0;
			$add['state']=0;
			$add['money']=$money_new;
			$add['bank']=$bank;
			$add['handling']=$money_new*$odds;
			$add['bank_number']=$bank_number;
			$add['bank_province']=$bank_province;
			$add['bank_city']=$bank_city;
			$add['user']=session('user');
			
			$table_record=M('table_record')->where('name="order_list"')->find();
			$max=$table_record['value'];
			
			if($cash_order = (M($max.'_order_list')->add($add))){
				$save['all_money']=array('exp','all_money-'.$money*(1+$odds));
				if(M('user_coin')->where('num_id="'.session('num_id').'"')->save($save)!==false){
					// M()->commit();
					
					//高于5000 直接提交
					if($money_new >= 5000){
						$res['state']=1;
						$res['msg']='成功发起提现';
						$res=json_encode($res);
						echo $res;
						exit;
					}
					
					import('Vendor.PayApi.three');
					$PayApi = new \PayApi();
						
					$user_bank = explode("---",$add["bank"]);
					$bank_info = $this->Bank_Info[$user_bank[0]];
					$sign = md5($max  . $cash_order . $add['order_num'] . $add['submit_time'] . "QHP"); 
					
					$param = array();
					$param = $add;
					
					$param["pay_mode"]   	= "00020";			
					$param["customerName"]  = $member['name'];
					$param["cerdId"]  		= trim(getIDcrad());
					$param["rcvBranchCode"] = $bank_info[2];
					$param["accBankName"] 	= $user_bank[0];
					$param["bankBranch"] 	= $user_bank[1];
					
					$url['p']  = $max  . "_" . $cash_order . "_" . $add['order_num'] . "_" . $add['submit_time'] ; 
					$url['s']  = $sign;
					$param["asynNotifyUrl"] = $this->http_type ."://" . $_SERVER["HTTP_HOST"].U("Admin/Comm/do_c",$url);
					
					$do_cash_res = array();
					// 发起提现申请
					$do_cash_res = $PayApi->WithdrawApply($param);
				
					if($do_cash_res['retCode']=='1518005' || !empty($do_cash_res['prdOrdNo'])){
						
						$save_data_order_list = array(
							"qrcode"	=>$param["asynNotifyUrl"],						
							"state"		=>"9",						
							"confirm_time"=>time()-3600*6,						
						);
						
						if($do_cash_res['prdOrdNo']){
							$save_data_order_list['platmerord'] = $do_cash_res['prdOrdNo'];
						}
						
						$res_order[] = M($max.'_order_list')->where(array("id"=>$cash_order))->save($save_data_order_list);
						M()->commit();
				
						$res['state']=1;
						$res['msg']='成功发起提现';
					}
					elseif($do_cash_res['retCode']=='1518041'){
						M()->rollback();
						$res['state']=-1;
						$res['msg']=$do_cash_res['retMsg'];
					}
					else{
						M()->rollback();
						$res['state']=-1;
						$res['msg']='发起失败';
					}
					
					
					$res=json_encode($res);
					echo $res;
					exit;
				}else{
					M()->rollback();
					$res['state']=-1;
					$res['msg']='发起失败';
					$res=json_encode($res);
					echo $res;
					exit;
				}
			}else{
				M()->rollback();
				$res['state']=-1;
				$res['msg']='发起失败';
				$res=json_encode($res);
				echo $res;
				exit;
			}
		}
	}
	
	// 提现申请
	
	public function do_pay(){
		// $this->ScanPayBack();
		
		$q_is_cash =M('system_conf')->where('name="is_pay"')->getfield("value");
		if($q_is_cash != "1"){
			$res['state']=-1;
			$res['msg']='通道维护中，请稍后';
			$res=json_encode($res);
			echo $res;
			exit;
		}
		
		$this->check_sess();
		// 判定提交方式
		$pay_method = $_POST['pay_method'];
		$pay_money  = (int)$_POST['pay_money'];
		$datas = array();
		if( !isset($this->Pay_method[$pay_method]) ){
			$datas['state']=0;
			$datas['msg']= '支付方式不正确，请重新提交！';  
			$datas['Q_TOKEN'] = creatToken();
			echo json_encode($datas);
			die;
		}
		
		// 判断金额限制
		if($pay_money <= 0 || !is_numeric($pay_money) ){
			$datas['state']=0;
			$datas['msg']= '支付金额不正确，请重新提交！';  
			$datas['Q_TOKEN'] = creatToken();
			echo json_encode($datas);
			die;
		}
		
		// 判定 TOKEN 防止多次提交
		$user_info = session('user');
		
		if(!checkToken($_POST['Q_TOKEN']) || empty($user_info)){
			$datas['state']=0;
			$datas['msg']= '当前页已失效。请刷新或重新登录'; 
			echo json_encode($datas);
			die;
		}
		
		/********************************************************/		
		/********************************************************/		
		/********************************************************/		
			// $pay_money = '2';
			// $pay_money = '0.01';
		/********************************************************/
		/********************************************************/
		
		/********************************************************/
		// 交通银行  为英文版
		// 中心支持IE
		// 
		// ['103'=>'农业银行','104'=>'中国银行','105'=>'建设银行','301'=>'交通银行','303'=>'光大银行','304'=>'华夏银行','305'=>'民生银行',
		//  '306'=>'广发银行','307'=>'平安银行','308'=>'招商银行','309'=>'兴业银行','310'=>'浦发银行','325'=>'上海银行','403'=>'邮储银行'
		// ];
		// $_POST['bank'] = 103;
		// 增加用户订单
		$order_param['order_num']   = date("YmdHis") . str_shuffle(  $user_info ) . rand(1000,9999);	
		$order_param['money']	    = $pay_money;
		$order_param['submit_time']	= time();
		$order_param['state']		= 0;
		$order_param['cash']		= 1;
		$order_param['method']		= $pay_method;
		$order_param['user']		= $user_info;
		$order_param['bank']		= $_POST['bank'];
		
		$order_record = M("table_record")->where(array("name='order_list'"))->getfield("value");
		
		$Order_table  = "{$order_record}_order_list";
		$order_info   = M($Order_table)->add($order_param);
		
		$pay_method_api = $this->Pay_method[$pay_method];
		
		$pay_param = $order_param;
		unset($pay_param['user']);
		$pay_param['pay_mode'] = $pay_method_api[2];
		
		$pay_param['asynNotifyUrl'] = $this->http_type ."://" . $_SERVER["HTTP_HOST"] . U("Pay/".$pay_method_api[3]);	//异步通知URL
		$pay_param['synNotifyUrl']  = $this->http_type ."://" . $_SERVER["HTTP_HOST"] . U("Pay/recharge");				//同步返回URL
		$pay_param['merParam']  	= "table_".$order_record."|paymethod_".$pay_method;		  // 表前缀
		$pay_param['user_phone']    = $user_info;
		
		$pay_param['tranChannel']   = $pay_method=='linebank' ? $_POST['bank'] : '103';		//设置用户选择的银行编码
				
		if($order_info){
			
			// 调起 支付接口
			$method_name = $pay_method_api[1];
			import('Vendor.PayApi.'.$pay_method_api[0]);
			// echo $pay_method_api[1];
			$PayApi = new \PayApi();
			$pay_result = ($PayApi->$pay_method_api[1]($pay_param));
	
		// die;
			switch($method_name){
				case "ScanPayApply":
					// 修改 用户订单
					$order_save['qrcode'] 		= $pay_result['qrcode'];
					$order_save['platmerord']   = $pay_result['platmerord'];
					M($Order_table)->where(array("id"=>$order_info))->save($order_save);
				
					if($pay_result['qrcode'] ){
						
						$Pay_img =  $this->ImagePath . $user_info."/". $pay_result['platmerord'] . ".png" ;	
					
						$datas['state']=2;
						$datas['msg']= '提交成功，请扫码充值';  
						// $datas['msg']= '扫码暂无法使用';  
						// $datas['pay_result'] = $pay_result; 
						$datas['http_url'] = $pay_result['qrcode']; 
						$datas['imagepath']= __ROOT__ . "/" . $Pay_img; 
						
						if ( ! file_exists( $Pay_img ) ){ 
							//  2018年1月13日16:12:02
							
							$log_dir = dirname($Pay_img);
							if (!is_dir($log_dir)) {
								mkdir($log_dir, 0755, true);
							}							
							
							Vendor('phpqrcode.phpqrcode');
							
							$errorCorrectionLevel =intval(3) ;//容错级别 
							
							$matrixPointSize = intval(4);//生成图片大小 
							//生成二维码图片 

							$object = new \QRcode();																			
							
							$object->png($pay_result['qrcode'] ,  $Pay_img, $errorCorrectionLevel, $matrixPointSize, 2); 
													
						}
						
					}else{
						$datas['state']=0;
						$datas['msg']= '提交失败，请稍后重试';  
					}
				    break;
				case "PayApply":
					// 修改 用户订单
				
					if($pay_result){
						
						$first_num = (strpos($pay_result,"<body>"));
						$last_num  = (strpos($pay_result,"</body>"));
						$str_length  = strlen($pay_result);
						
						$datas['state']=1;
						$datas['msg']= '提交成功，正在跳转';  
						$datas['http_url']= trim(substr($pay_result,$first_num+6,$last_num-$str_length-7));

						$order_save['qrcode'] 		= $datas['http_url'];
						$order_save['platmerord']   = $pay_result['platmerord'];
						M($Order_table)->where(array("id"=>$order_info))->save($order_save);
					}else{
						$datas['state']=0;
						$datas['msg']= '提交失败，请稍后重试';  
					}
				    break;	
					
				case "BankApply":
					// 修改 用户订单
					// $order_save['qrcode'] 		= $pay_result['qrcode'];
					// $order_save['platmerord']   = $pay_result['platmerord'];
					// M($Order_table)->where(array("id"=>$order_info))->save($order_save);
				
					if($pay_result){
						
						$datas['state']=3;
						$datas['msg']= '提交成功，正在跳转';  
						$datas['html']= $pay_result;

					}else{
						$datas['state']=0;
						$datas['msg']= '提交失败，请稍后重试';  
					}
				    break;	



				
				case "QuickPay":
					// 修改 用户订单
					
					$order_save['qrcode'] 		= $pay_result['data'];
					// $order_save['platmerord']   = $pay_result['platmerord'];
					M($Order_table)->where(array("id"=>$order_info))->save($order_save);				
						
					if($pay_result['data']){
						$datas['state']=1;
						$datas['msg']= '提交成功，正在跳转';  
						$datas['http_url']= $pay_result['data'];  
					}else{
						$datas['state']=0;
						$datas['msg']= '提交失败，请稍后重试'; 
						$datas = $pay_result;
					}
					break;	
				default :
					$datas['state']=0;
					$datas['msg']= '支付方式不正确，请重新提交！';  
					break;	
			}
			$datas['Q_TOKEN'] = creatToken();
			echo json_encode($datas);
			die;
		}else{
			
			$datas['state']=0;
			$datas['msg']= '提交支付失败，请您稍后重试！';  
			echo json_encode($datas);
			die;
			
		}
			
	}
	
	// QQ WX 扫码支付异步回调
	public function ScanPayBack(){		
		$input = file_get_contents("php://input");
		$signstring=urldecode($input);
		// $signstring = "merParam=table_1|paymethod_linebank&signData=036AF24808AD400E42BF7BC49E9B4B88&payTime=20180118110403&orderStatus=01&versionId=1.0&orderAmount=1&transType=008&asynNotifyUrl=http://119.29.168.120/zuqiu/index.php/Home/Pay/ScanPayBack.html&synNotifyUrl=http://119.29.168.120/zuqiu/index.php/Home/Pay/recharge.html&signType=MD5&merId=100520135&payId=953824088294432768&prdOrdNo=20180118105918722639088183535";
		$signarr = explode("&",$signstring);
		
		foreach($signarr as $val){
			$value = explode("=",$val);
			$param_arr[$value[0]] = $value[1];
		}
		
		//获取支付方式 验证signdata
		$merParam 		= explode("|",$param_arr['merParam']);
		
		$order_record 	= explode("_",$merParam[0])[1];
		$pay_mode_name	= explode("_",$merParam[1])[1];		
		
		// 获取支付平台订单号及原订单号
		// $order_where['order_num']  = $param_arr['prdOrdNo'];		
			
		$pay_mode = $this->Pay_method[$pay_mode_name];
		$pay_mode_verify = $pay_mode["verify"];
	
		foreach($pay_mode_verify as $key=>$val){
			$order_where[$key] = $param_arr[$val];
		}	
			
		$order_where['state']  	   = 0;		
		//
		if( $pay_mode_name == 'linebank' || $pay_mode_name == 'qqwap' ){		
			$order_save['platmerord'] = $param_arr['payId'];
		}
		
		$Order_table = "{$order_record}_order_list";
		// print_r($param_arr);
		$order_info  = $this->OrderIsExist($Order_table, $order_where);
		
		$LogPathCom = $this->LogPath ;
		
		$LogFileName=$LogPathCom. "user-" .$order_info['user']  ;
		
		file_put_contents($LogFileName . "-sign.log",date("H:i:s")."---". $order_info['method']."---" .$signstring . "\r\n\r\n",FILE_APPEND) ;
		
		// 有订单 且状态为 未完成 及确认时间为空
		// 调用订单查询接口
		import('Vendor.PayApi.three');
		// echo $pay_method_api[1];
		$PayApi = new \PayApi();
		
		$signData = $param_arr['signData'];
		unset($param_arr['signData']);
		
		$Order_result = $PayApi->OrderStatusQuery($param_arr,$signData,$pay_mode[2]);
		
		if($Order_result && ($param_arr['orderStatus']==1) ){			
			// sign 验证正确 且 订单支付成功
			M()->startTrans();
			$order_save['state']		= 1;
			$order_save['confirm_time'] = strtotime($param_arr['payTime']);
			$order_save['usrPayAmt'] 	= $param_arr['orderAmount']/100;
			
			$res_order = M($Order_table)->where($order_where)->save($order_save);
		
			$conf_money=M('system_conf')->where('name="exchange_rate"')->find();
			$odds_money=substr($conf_money['value'],2,3);
			$user_save['all_money'] = array("exp","all_money+'".round(($order_save['usrPayAmt']/$odds_money),2)."'");
			
			$res_user = M("user_coin")->where(array("num_id"=>$order_info['num_id']))->save($user_save);
		
			if($res_user!==false){
				$res_user=true;
			}
			
			if($res_user && $res_order){
		
				if($this->check_matching($order_info['num_id'],$order_info['user'])){
					M()->commit();
		
					$LogString = date("Y-m-d H:i:s") ."\r\n";
					$LogString.= "支付金额：". $order_save['usrPayAmt'] ."\r\n";
					$LogString.= "支付方式：". $order_info['method']    ."\r\n";
					$LogString.= "支付状态：SUCCESS" ."\r\n";
					$LogString.= "\r\n";
				
					file_put_contents($LogFileName. ".log", $LogString . "\r\n", FILE_APPEND) ;
					
					echo "SUCCESS";
					die;
				}else{
					M()->rollback();
					echo "FAIL1";
					die;
				}	
			}else{
				M()->rollback();
				echo "FAIL1";
				die;
			}		
		}
		
		echo "FAIL";
		die;
	}
	
	// yifu 支付宝回调
	public function YiFuPayBack(){
		
		$input = file_get_contents("php://input");
		$signstring=urldecode($input);
		
		// $signstring = '{"appId":"28C85D0FB0E5475B9498C86971FC8515","apiVer":"1.0","payType":"alipay","scene":"wap","terminal":"android","fmt":"json","charset":"utf-8","sgnType":"md5","merchOrdrNo":"20180110104522791088622839180","usrPayAmt":"1.00","platformOrdrNo":"20180110104810667626","state":"success","timeStamp":"2018-01-10 10:48:41","usrName":"18228068397","extParm":"table_1|paymethod_alipay","sgn":"5708961244aa9b82565df6927fbea53c"}';
		
		$response=json_decode($signstring,true);
		
		$order_where['order_num']   = $response['merchOrdrNo'];		
		$order_where['o.user']  		= $response['usrName'];		
		
		$merParam 		= explode("|",$response['extParm']);
		$order_record 	= explode("_",$merParam[0])[1];
		$pay_mode_name	= explode("_",$merParam[1])[1];		
		
		$pay_mode = $this->Pay_method[$pay_mode_name];
		
		$Order_table = "{$order_record}_order_list";
				
		$order_info  = $this->OrderIsExist($Order_table, $order_where);
		
		$LogPathCom = $this->LogPath ;
		
		$LogFileName=$LogPathCom. "user-" .$order_info['user']  ;
		
		file_put_contents($LogFileName . "-sign.log", $order_info['method']."---" .$signstring . "\r\n\r\n",FILE_APPEND) ;
		
		// 有订单 且状态为 未完成 及确认时间为空
		// 调用订单查询接口
		import('Vendor.PayApi.yifu');
		// echo $pay_method_api[1];
		$PayApi = new \PayApi();
		
		$signData = $response['sgn'];
		
		$Order_result = $PayApi->OrderStatusQuery($signstring,$signData,$pay_mode[2]);
		
		if($Order_result && ($response['state']=="success") ){			
			// sign 验证正确 且 订单支付成功
			M()->startTrans();
			$order_save['state']		= 1;
			$order_save['confirm_time'] = strtotime($response['timeStamp']);
			$order_save['platmerord'] 	= $response['platformOrdrNo'];
			$order_save['usrPayAmt'] 	= $response['usrPayAmt'];
			
			$res_order = M($Order_table)->alias("o")->where($order_where)->save($order_save);
			$conf_money=M('system_conf')->where('name="exchange_rate"')->find();
			$odds_money=substr($conf_money['value'],2,3);
			$user_save['all_money'] = array("exp","all_money+'".round(($response['usrPayAmt']/$odds_money),2)."'");
			
			$res_user = M("user_coin")->where(array("num_id"=>$order_info['num_id']))->save($user_save);
			
			if($res_user && $res_order){
				if($this->check_matching($order_info['num_id'],$order_info['user'])){
					M()->commit();
					$LogString = date("Y-m-d H:i:s") ."\r\n";
					$LogString.= "支付金额：". $order_save['usrPayAmt'] ."\r\n";
					$LogString.= "支付方式：". $order_info['method']    ."\r\n";
					$LogString.= "支付状态：SUCCESS" ."\r\n";
					$LogString.= "\r\n";
				
					file_put_contents($LogFileName. ".log", $LogString . "\r\n", FILE_APPEND) ;
					echo "SUCCESS";
					die;
				}else{
					M()->rollback();
					echo "FAIL";
					die;
				}
			}else{
				M()->rollback();
				echo "FAIL";
				die;
			}		
		}
		
		echo "FAIL";
		die;
		
	}
	
	//查询订单是否存在
	protected function OrderIsExist($Order_table ,$order_where ){		
		//$this->check_sess();
		//查询该订单
		// 及该订单用户的num_id
		$join = " right join __MEMBERS__ m on m.user = o.user" ;
		$order_info = M($Order_table)->alias("o")->field("o.*,m.num_id")->join($join)->where($order_where)->find();
		// echo M()->getLastSql();
		
		if(!$order_info){
			echo "FAIL";
			die;
		}
		
		if($order_info['state'] == 2 && $order_info['confirm_time']){
			echo "SUCCESS";
			die;
		}
		
		return $order_info;
		
	}
		 
	private function check_sess(){//
        session_start();
        if(!isset($_SESSION['user'])){
            echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
            echo "<script> error('请您先登录',3500)</script>";
            echo "<script> window.location.href='".U('Login/login')."';</script>";
            exit();
        }
    }
	private function check_matching($num_id,$user){
		//$this->check_sess();
		$chech_member=M('members')->where('num_id="'.$num_id.'"')->find();
		if($chech_member['activation']==0){
			$table_record=M('table_record')->where('name="order_list"')->find();
			$max=$table_record['value'];
			$money=0;
			for($i=1;$i<=$max;$i++){
				$case=''.$i.'_order_list';
				$money+=M($case)->where('user="'.$user.'" AND cash=1 AND state=1')->sum('money');
			}
			$conf_money=M('system_conf')->where('name="exchange_rate"')->find();
			$odds_money=substr($conf_money['value'],2,3);
			$active_money=M('system_conf')->where('name="active_money"')->find();
			$money=$money/$odds_money;
			//print_r($money);die;
			if($money>=$active_money['value']){
				$team=M('recommend_relation')->field('team,recommend')->where('num_id="'.$num_id.'"')->find();
				$superior = array_values(array_filter(explode(' ',$team['team'] )));
				$superior[count($superior)]=$num_id;
				if(!empty($superior)){
					//print_r($team);die;
					M('recommend_relation')->where('num_id="'.$team['recommend'].'"')->setInc('direct_num',1);
					$level=M('rebate_conf')->select();
					$count_le=count($level);
					foreach($superior as $key=>$val){
						$save_team['team_num'] = array('exp','team_num+1');
						if(M('recommend_relation')->where('num_id="%s"',array( $val ))->save($save_team) == false){
							//echo 5;
							return false;
						}
					}
					foreach($superior as $k=>$v){
						$num_data=M('recommend_relation')->where('num_id="%s"',array( $v ))->find();
						$check_num_data=M('members')->where('num_id="%s"',array( $v ))->find();
						if($check_num_data['activation']==1){
							$level_name='';
							for($i=$count_le-1;$i>=0;$i--){
								if($num_data['direct_num']>=$level[$i]['direct_num']&&$num_data['team_num']>=$level[$i]['team_num']){
									$level_name=$level[$i]['name'];
									break;
								}
							}
							if(empty($check_num_data['level'])){
								if(!empty($level_name)){
									$save_member['level']=$level_name;
									if(M('members')->where('num_id="%s"',array( $v ))->save($save_member)==false){
										//echo M()->getlastsql();
										return false;
									}
								}
							}
							
						}
					}
				}
				$save_data['activation']=1;
				if(M('members')->where('num_id="%s"',array( $num_id ))->save($save_data)==false){
					//echo 4;
					return false;
				}
				//echo 1;
				return true;
			}else{
				//echo 2;
				return true;
			}
		}else{
			//echo 3;
			return true;
		}
	}

}