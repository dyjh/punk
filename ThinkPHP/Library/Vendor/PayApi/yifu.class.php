<?php
/**
 * @Author QHP 
 * @2018年1月8日15:12:29
 *
 */
 
 header('content-type:text/html; charset = utf-8');
 // 加载配置
 require_once( 'config/config.php');
 
 class PayApi{
	 
	private $MERID;
	private $KEY;
	private $TRANS_URL;
	private $SIGN_TYPE;
	private $PAY_GATEWAY;
	
	public function __construct(){
		// 加载配置值
		
		$config =config();
		
		foreach($config as $key=>$val){
			
			$this->$key = $val;
			
		}
		
	}
	
	/**
	 * 快速支付请求接口
	 * @param  string $pieces [请求的参数]
	 * @return  string
	 */
	public function QuickPay($param){
		
		$this->PAY_GATEWAY = 'http://pay.payone.top/pay';
		
		$MERID_INFO = $this->$param['pay_mode'];
		$param['merId'] = $MERID_INFO['MERID'];
		
		$pieces = $this->ConfigParam($param);
		
		$signString= yifusignstring($pieces);		
		
		return $this->DoThreePay($signString);
	}
	 
	protected function ConfigParam($param){
		
		$MERID_INFO = $this->$param['pay_mode'];
		
		$pieces['appId']				=$param['merId'];								//
		$pieces['apiVer']				="1.0";											//
		$pieces['payType']				=$param['pay_mode'];							//
		$pieces['scene']				='wap';											//支付场景
		$pieces['terminal']				='android';											//支付终端
		$pieces['fmt']					='json';										//
		$pieces['charset']				="utf-8";										//
		$pieces['sgnType']				=strtolower($this->SIGN_TYPE);					//
		$pieces['merchOrdrNo']			=$param['order_num'];							// 
		$pieces['totOrdrAmt']			=number_format($param['money'],2);				// 
		$pieces['noteUrl']				=$param['asynNotifyUrl'];						//
		$pieces['rtnUrl']				=$param['synNotifyUrl'];						//
		$pieces['timeStamp']			=date("Y-m-d H:i:s");							//
		$pieces['usrName']				=$param['user_phone'] ;							//
		$pieces['extParm']				=$param['merParam'];							//
		// $pieces['extParm']				="123456";							//
		$pieces['secretKey']			=$MERID_INFO['KEY'] ;							//		
		
		$pieces['appId']				="28C85D0FB0E5475B9498C86971FC8515";								//
		// $pieces['apiVer']				="1.0";											//
		// $pieces['payType']				="alipay";										//
		// $pieces['scene']				='wap';											//支付终端
		// $pieces['terminal']				='android';										//支付终端
		// $pieces['fmt']					='json';										//
		// $pieces['charset']				="utf-8";										//
		// $pieces['sgnType']				="md5";											//
		// $pieces['merchOrdrNo']			="20150320010101001";							// 
		// $pieces['totOrdrAmt']			="0.01";										// 
		// $pieces['noteUrl']				="http://localhost:2066/noteUrl.aspx";			//
		// $pieces['rtnUrl']				="http://localhost:2066/rtnUrl.aspx";			//
		// $pieces['timeStamp']			="2018-01-09 16:10:52";							//
		// $pieces['usrName']				="zhangsan";									//
		// $pieces['extParm']				="20150320010101001";
		$pieces['secretKey']			="CAACC818BCCEC16457C2514F89196C33FAA683CFB4694912829914E83849790F" ;							//
		
		
		// sort($pieces);
		return $pieces;
	} 
	 
	protected function DoThreePay($pieces){
		
			$post_url =  $this->PAY_GATEWAY;
			
			$res = $this->Qhpcurl($post_url,$pieces);			
			
			return $res;
			
	} 
	
	/**
	 * 请求接口返回内容
	 * @param  string $url [请求的URL地址]
	 * @param  string $params [请求的参数]
	 * @param  int $ipost [是否采用POST形式]
	 * @return  string
	 */
	private function Qhpcurl($url,$params=false,$ispost=1){
		$httpInfo = array();
		$ch = curl_init();
	 
		curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
		// curl_setopt( $ch, CURLOPT_USERAGENT , 'Qhp' );
		curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 60 );
		curl_setopt( $ch, CURLOPT_TIMEOUT , 60);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		if( $ispost )
		{
			curl_setopt( $ch , CURLOPT_POST , true );
			curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
			curl_setopt( $ch , CURLOPT_URL , $url );
		}
		else
		{
			if($params){
				curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
			}else{
				curl_setopt( $ch , CURLOPT_URL , $url);
			}
		}
		$response = curl_exec( $ch );
		
		if ($response === FALSE) {
			return false;
		}
		$response=json_decode($response,true);
		
		$httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
		$httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
		curl_close( $ch );
		
		return $response;
	}
	
	//支付异步验证接口
	public function OrderStatusQuery( $input , $signData , $pay_mode ){
		
		$response=json_decode($input,true);
		unset($response['sgn']); 
		
		$MERID_INFO = $this->$pay_mode;
	
		$signstring = yifusignstring($response);
		
		if( $signstring == $input ){
			return true;
		}
		return true;
		return false;
		
	}
	
 }