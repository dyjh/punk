<?php
/**
 * @Author QHP 
 * @2018��1��8��15:12:29
 *
 */
 
 // ��������
 require_once( 'config/config.php');
 
 class PayApi{
	 
	private $MERID;
	private $KEY;
	private $TRANS_URL;
	private $SIGN_TYPE;
	private $PAY_GATEWAY;
	
	public function __construct(){
		// ��������ֵ
		
		$config =config();
		
		foreach($config as $key=>$val){
			
			$this->$key = $val;
			
		}
		 
	}
	
	/**
	 * ɨ��֧������ӿ�
	 * @param  string $pieces [����Ĳ���]
	 * @return  string
	 */
	public function ScanPayApply($param){
		
		$this->PAY_GATEWAY = '/payment/ScanPayApply.do';
		
		$MERID_INFO = $this->$param['pay_mode'];
		$param['merId'] = $MERID_INFO['MERID'];
		
		$pieces = $this->ConfigParam($param);

		foreach ($pieces as $key=>$value){
			$input_str  .= $key ."=".$value . "&";
		}
		
		$input_str = substr($input_str , 0 , -1);
		
		$signString= signString($input_str,$MERID_INFO['KEY']);		
	
		return $this->DoThreePay($signString);
	}
	 
	public function BankApply($param){
		return $this->PayApply($param);		
	} 
	
	public function WithdrawApply($param){
		
		$this->PAY_GATEWAY = '/payment/WithdrawApply.do';
		
		$MERID_INFO = $this->$param['pay_mode'];
		$param['merId'] = $MERID_INFO['MERID'];
		
		$pieces = $this->WithdrawConfigParam($param);
// print_r($pieces);
		// die;  
		foreach ($pieces as $key=>$value){
			$input_str  .= $key ."=".$value . "&";
		}
		
		$input_str = substr($input_str , 0 , -1);
		
		$signString= signString($input_str,$MERID_INFO['KEY']);		
		// var_dump($pieces);  
		
		
		return $this->DoThreePay($signString);
		
	}
	
	public function OrderStatusQuery_cash($param){
		
		$this->PAY_GATEWAY = '/payment/OrderStatusQuery.do';
		
		$MERID_INFO = $this->$param['pay_mode'];
		$param['merId'] = $MERID_INFO['MERID'];
		
		$pieces['merId'] = $param['merId'];
		$pieces['prdOrdNo'] = $param['prdOrdNo'];
		$pieces['signType'] = "MD5";
		
		foreach ($pieces as $key=>$value){
			$input_str  .= $key ."=".$value . "&";
		}
		
		$input_str = substr($input_str , 0 , -1);
		
		$signString= signString($input_str,$MERID_INFO['KEY']);		
		
		return $this->DoThreePay($signString);
		
	}
	 
	/**
	 * ����֧������ӿ�
	 * @param  string $pieces [����Ĳ���]
	 * @return  string
	 **/ 
	public function PayApply($param){
		
		$this->PAY_GATEWAY = '/payment/PayApply.do';
		
		$MERID_INFO = $this->$param['pay_mode'];
		$param['merId'] = $MERID_INFO['MERID'];
		
		$pieces = $this->ConfigPayApplyParam($param);

		foreach ($pieces as $key=>$value){
			$input_str  .= $key ."=".$value . "&";
		}
		
		$input_str = substr($input_str , 0 , -1);
		
		$signString= signString($input_str,$MERID_INFO['KEY']);		
		
		$res = $this->DoThreePay($signString,false);
		 
		 // print_r($pieces);
		 // print_r($signString);
		 // print_r($res);
		 // die;
		return $res;
	}
	 
	protected function ConfigParam($param){
		
		$pieces['versionId']='1.0';											//����汾��
		$pieces['orderAmount']=$param['money'] * 100 ;						//�������
		$pieces['orderDate']=date("YmdHis",$param['submit_time']);			//��������
		$pieces['currency']='RMB';											//��������
		$pieces['transType']='008';											//�������
		$pieces['asynNotifyUrl']=$param['asynNotifyUrl'];					//�첽֪ͨURL
		$pieces['synNotifyUrl']=$param['synNotifyUrl'];						//ͬ������URL
		$pieces['signType']=$this->SIGN_TYPE;								//���ܷ�ʽ
		$pieces['merId']=$param['merId'];									//�̻���� 
		$pieces['prdOrdNo']=$param['order_num'];							//��Ʒ������ 
		$pieces['payMode']=$param['pay_mode'];								//֧����ʽ
		$pieces['receivableType']='D00';									//��������
		$pieces['prdAmt']=$param['money'] ;									//��Ʒ����
		$pieces['prdDisUrl']='';											//��Ʒչʾ��ַ
		$pieces['prdName']='prdName';										//
		$pieces['productDesc']='productDesc';								//
		$pieces['prdShortName']='';											//
		$pieces['prdDesc']='';												//
		$pieces['merParam']=$param['merParam'];
		// sort($pieces);
		return $pieces;
	} 
	
	protected function WithdrawConfigParam($param){
		
		$pieces['versionId']		= '1.0';											
		$pieces['orderAmount']		= $param['money'] * 100 ;						
		$pieces['orderDate']		= date("YmdHis",$param['submit_time']);			
		$pieces['currency']			= 'RMB';											
		$pieces['transType']		= '008';											
		$pieces['asynNotifyUrl']	= $param['asynNotifyUrl'];							
		$pieces['signType']			= $this->SIGN_TYPE;								
		$pieces['merId']			= $param['merId'];									 
		$pieces['prdOrdNo']			= $param['order_num'];							 									
		$pieces['receivableType']	= 'D00';									
		$pieces['isCompay']			= '0';									
		$pieces['outaccounttype']	= '2';									
		$pieces['phoneNo']			= $param['user'] ;									
		$pieces['customerName']		= $param['customerName'] ;									
		$pieces['cerdId']			= $param['cerdId'] ;									
		$pieces['accBankName']		= $param['accBankName'] ;									
		$pieces['acctNo']			= $param['bank_number'] ;									
		$pieces['rcvBranchCode']	= $param['rcvBranchCode'] ;									
		$pieces['bankBranch']		= $param['bankBranch'] ;									
		$pieces["provinceName"] 	= $param['bank_province'];
		$pieces["cityname"] 		= $param['bank_city'];
					
		// sort($pieces);
		return $pieces;
	} 
	
	
	protected function ConfigPayApplyParam($param){
		
		$pieces['versionId']='1.0';											//����汾��
		$pieces['orderAmount']=$param['money'] * 100 ;						//�������
		$pieces['orderDate']=date("YmdHis",$param['submit_time']);			//��������
		$pieces['currency']='RMB';											//��������
		$pieces['accountType']='0';											//���п�����
		$pieces['transType']='008';											//�������
		$pieces['asynNotifyUrl']=$param['asynNotifyUrl'];					//�첽֪ͨURL
		$pieces['synNotifyUrl']=$param['synNotifyUrl'];						//ͬ������URL
		$pieces['signType']=$this->SIGN_TYPE;								//���ܷ�ʽ
		$pieces['merId']=$param['merId'];									//�̻���� 
		$pieces['prdOrdNo']=$param['order_num'];							//��Ʒ������ 
		$pieces['payMode']=$param['pay_mode'];								//֧����ʽ
		$pieces['tranChannel']=$param['tranChannel'];						//���б���
		$pieces['receivableType']='D00';									//��������
		$pieces['prdAmt']=$param['money'] *100 ;							//��Ʒ����
		$pieces['prdDisUrl']='';											//��Ʒչʾ��ַ
		$pieces['prdName']='prdName';										//
		$pieces['productDesc']='productDesc';								//
		$pieces['pnum']='1';												//��Ʒ����
		$pieces['prdDesc']='prdDesc';										//
		$pieces['merParam']=$param['merParam'];
		// sort($pieces);
		return $pieces;
	} 
	  	 
	protected function DoThreePay($pieces,$is_json=true){
		
			$post_url = $this->TRANS_URL . $this->PAY_GATEWAY;
			
			$res = $this->Qhpcurl($post_url,$pieces,$is_json);
			// $res = substr($this->Qhpcurl($post_url,$pieces) , 1 , -1);
			// $res = explode(",",$res);
			 
			// var_dump($pieces);
			// print_r($res);
			// var_dump($param);
			// die; 
			
			return $res;
			
	} 
	
	/**
	 * ����ӿڷ�������
	 * @param  string $url [�����URL��ַ]
	 * @param  string $params [����Ĳ���]
	 * @param  int $ipost [�Ƿ����POST��ʽ]
	 * @return  string
	 */
	private function Qhpcurl($url,$params=false,$is_json=true , $ispost=1){
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
		if($is_json){
			$response=json_decode($response,true);
		}
		$httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
		$httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
		curl_close( $ch );
		
		return $response;
	}
	
	//֧���첽��֤�ӿ�
	public function OrderStatusQuery( $input , $signData , $pay_mode ){
		
		$MERID_INFO = $this->$pay_mode;
	
		foreach($input as $key=>$val){
			$sign_arr[] = $key."=".$val;
		}
		$signstring = implode("&",$sign_arr);
		
		$sign = sign($signstring,$MERID_INFO['KEY']);
		
		if( $sign == $signData ){
			return true;
		}
		
		return false;
		
	}
	
	
	
	
 }