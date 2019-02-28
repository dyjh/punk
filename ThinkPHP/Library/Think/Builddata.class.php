<?php

namespace Think;
/**
 * 用于ThinkPHP的自动生成
 */
class Builddata {
    public function build_matching(){


        $va=M('table_record')->where('name="matching"')->find();
        $case=$va['value']+1;
        $num=M($va['value'].'_matching')->count();
        if($num+1>=300000) {
            M('table_record')->where('name="matching"')->setInc('value', 1);
            $Model = M();
            $Model->execute('
                    CREATE TABLE `' . $case . '_matching` (
                      `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
					  `num_id` varchar(20) NOT NULL,
					  `principal` int(10) unsigned NOT NULL COMMENT \'本金\',
					  `score` varchar(10) NOT NULL COMMENT \'投注场次，比分的编号\',
					  `interest` double(20,2) unsigned NOT NULL COMMENT \'利息\',
					  `end_state` tinyint(1) unsigned NOT NULL DEFAULT \'0\' COMMENT \'1 胜利 2输 \',
					  `state` tinyint(1) unsigned NOT NULL DEFAULT \'0\' COMMENT \'进行中0 完成 1 退款 2 3系统\',
					  `add_time` int(10) unsigned NOT NULL,
					  `game_id` int(10) unsigned NOT NULL,
					  `against_team` char(20) NOT NULL,
					  `rebate_state` tinyint(1) unsigned NOT NULL DEFAULT \'0\' COMMENT \'0 已处理 1未处理\',
					  `type` tinyint(1) unsigned NOT NULL COMMENT \'0 全场 1 半场 2 总球数\',
					  `order_num` varchar(100) NOT NULL,
					  `end_time` int(10) unsigned DEFAULT NULL,
					  PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
            ');
        }
	}

		public function build_order_list(){
			$va=M('table_record')->where('name="order_list"')->find();
			$case=$va['value']+1;
			$num=M($va['value'].'_order_list')->count();
			
			if($num+1>=300000) {
				//echo $num;
				M('table_record')->where('name="order_list"')->setInc('value', 1);
				$Model = M();
				$Model->execute('
					`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
					  `order_num` varchar(255) NOT NULL COMMENT \'订单号\',
					  `user` varchar(255) DEFAULT NULL,
					  `money` double(10,4) unsigned NOT NULL COMMENT \'提现金额\',
					  `submit_time` int(10) unsigned NOT NULL COMMENT \'提交时间\',
					  `confirm_time` int(10) unsigned NOT NULL COMMENT \'确认时间\',
					  `state` tinyint(2) unsigned NOT NULL DEFAULT \'0\' COMMENT \'0未完成 1已完成\',
					  `cash` tinyint(1) unsigned NOT NULL COMMENT \'交易类型 0 提现 1充值\',
					  `handling` double(10,4) unsigned DEFAULT NULL COMMENT \'手续费\',
					  `method` varchar(255) DEFAULT NULL,
					  `usrPayAmt` double(10,4) DEFAULT NULL COMMENT \'用户实际支付\',
					  `platmerord` varchar(50) DEFAULT NULL COMMENT \'支付平台订单\',
					  `qrcode` varchar(255) DEFAULT NULL COMMENT \'支付平台地址或二维码地址\',
					  `bank` varchar(255) DEFAULT NULL,
					  `bank_number` varchar(255) DEFAULT NULL,
					  `bank_city` varchar(255) DEFAULT NULL,
					  `bank_province` varchar(255) DEFAULT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
				');
			}
		}
		public function build_rebate_commission(){
			$va=M('table_record')->where('name="rebate_commission"')->find();
			$case=$va['value']+1;
			$num=M($va['value'].'_rebate_commission')->count();
			if($num+1>=300000) {
				M('table_record')->where('name="rebate_commission"')->setInc('value', 1);
				$Model = M();
				$Model->execute('
					CREATE TABLE `'.$case.'_rebate_commission` (
					  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
					  `num_id` varchar(20) NOT NULL,
					  `type` tinyint(2) unsigned NOT NULL DEFAULT \'0\' COMMENT \'0直推返佣1代理佣金\',
					  `money` double(10,2) unsigned NOT NULL,
					  `time` int(10) unsigned NOT NULL,
					  `state` tinyint(1) unsigned NOT NULL DEFAULT \'0\',
					  `from_id` varchar(20) NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;
			  ');
			}
		}
		public function build_trans_record(){
			$va=M('table_record')->where('name="trans_record"')->find();
			$case=$va['value']+1;
			$num=M($va['value'].'_trans_record')->count();
			if($num+1>=300000) {
				M('table_record')->where('name="trans_record"')->setInc('value', 1);
				$Model = M();
				$Model->execute('
					CREATE TABLE `' . $case . '_trans_record` (
					  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
					  `get_id` varchar(255) NOT NULL,
					  `from_id` varchar(255) NOT NULL,
					  `time` int(10) unsigned NOT NULL,
					  `money` int(10) unsigned NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8;
				');
			}
		}
	}


