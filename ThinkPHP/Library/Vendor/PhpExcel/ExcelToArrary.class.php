<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/8 0008
 * Time: 下午 4:09
 */
 require dirname ( __FILE__ ).DIRECTORY_SEPARATOR.'/Classes/PHPExcel.php';

class ExcelToArrary
{
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
	
    /* 导出excel函数*/
    public function push($data,$name)
    {
        // ob_end_clean();
		// PRINT_R($data);DIE;
        $objPHPExcel = new \PHPExcel();

        /*以下是一些设置 ，什么作者  标题啊之类的*/

        $objPHPExcel->getProperties()->setCreator("QHP")
            ->setLastModifiedBy("QHP")
            ->setTitle("数据EXCEL导出")
            ->setSubject("数据EXCEL导出")
            ->setDescription("备份数据")
            ->setKeywords("excel")
            ->setCategory("result file");

        $objPHPExcel->setActiveSheetIndex(0);

        $key1 = 1;
       
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A'.$key1, '订单号')
			->setCellValue('B'.$key1, '版本(1.0)')
			->setCellValue('C'.$key1, '金额(分)')
			->setCellValue('D'.$key1, '币种(RMB)')
			->setCellValue('E'.$key1, '银行名称')
			->setCellValue('F'.$key1, '银行简称')			
			->setCellValue('G'.$key1, '银行编码')
			->setCellValue('H'.$key1, '开户省')			
			->setCellValue('I'.$key1, '开户市')			
			->setCellValue('J'.$key1, '支行名称')	
			->setCellValue('K'.$key1, '账户号')			
			->setCellValue('L'.$key1, '银行预留手机号')		
			->setCellValue('M'.$key1, '银行卡类型(0 公有 1私有)')		
			->setCellValue('N'.$key1, '证件类型(身份证)')		
			->setCellValue('O'.$key1, '身份证号')		
			->setCellValue('P'.$key1, '法人姓名')		
			->setCellValue('Q'.$key1, '商户商编')		
			->setCellValue('R'.$key1, '出账类型(1-用户，2-商户)')	
			->setCellValue('S'.$key1, '回调地址')		
			->setCellValue('T'.$key1, '到账类型(D00, T01)')	
			->setCellValue('U'.$key1, '交易类型(0008)');
		foreach ($data as $k => $v) {
			$num = $k + 2;						
			$user_bank = explode("---",$v["bank"]);
			$bank_info = $this->Bank_Info[$user_bank[0]];
			 
			$sign = md5($v['order_record'] . "1" . $v['id'] . $v['order_num'] . $v['submit_time']. $v['handling']); 
			$objPHPExcel->setActiveSheetIndex(0)
				//Excel的第A列，uid是你查出数组的键值，下面以此类推////
				->setCellValue('A' . $num, $v['order_num'])
				->setCellValue('B' . $num, "1.0 ")
				->setCellValue('C' . $num, (int)($v['money']*100))  
				->setCellValue('D' . $num, "RMB")
				->setCellValue('E' . $num, $bank_info[0])
				->setCellValue('F' . $num, $bank_info[1])
				->setCellValue('G' . $num, $bank_info[2])
				->setCellValue('H' . $num, $v["bank_province"])	
				->setCellValue('I' . $num, $v["bank_city"])	
				->setCellValue('J' . $num, $user_bank[1])	
				->setCellValue('M' . $num, '1')					
				->setCellValue('N' . $num, '身份证')			
				->setCellValue('P' . $num, '')					
				->setCellValue('R' . $num, '1')				 
				->setCellValue('S' . $num, $this->Url.U("Admin/Order/extract",array("fix"=>$v['order_record'],"cases"=>1,"id"=>$v['id'],"order_num"=>$v['order_num'],"time"=>$v['submit_time'],"hand"=>$v['handling'] , "sign"=>$sign)))				
				->setCellValue('T' . $num, 'D00')			
				->setCellValue('U' . $num, '0008');		
				 
				$objPHPExcel->getActiveSheet()->setCellValueExplicit('K'.$num,$v['bank_number'],PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->getActiveSheet()->setCellValueExplicit('O'.$num,getIDcrad(),PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->getActiveSheet()->setCellValueExplicit('Q'.$num,"100520135",PHPExcel_Cell_DataType::TYPE_STRING);
				$objPHPExcel->getActiveSheet()->setCellValueExplicit('L'.$num,"13".rand(100000000,999999999),PHPExcel_Cell_DataType::TYPE_STRING);
		} 
		
		header('Content-Type: application/vnd.ms-excel;charset=utf8');
        header('Content-Disposition: attachment;filename="' . $name . '提现订单.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	
	
        $objWriter->save('php://output');

        exit;
    }
}