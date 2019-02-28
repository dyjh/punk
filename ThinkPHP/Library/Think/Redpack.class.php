<?php

// +----------------------------------------------------------------------

// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]

// +----------------------------------------------------------------------

// | Copyright (c) 2011 http://thinkphp.cn All rights reserved.

// +----------------------------------------------------------------------

// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )

// +----------------------------------------------------------------------

// | Author: luofei614 <weibo.com/luofei614>　

// +----------------------------------------------------------------------

namespace Think;

class Redpack{
    //总赔率
    private $total=0;
    //数量
    private $num=0;
    //最小赔率
    private $min=1;

    public function __construct($total,$num,$min)
    {
        $this->total = $total;
        $this->num = $num;
        $this->min = $min;
    }
	
    //结果
    public function getPack()
    {
        $total = $this->total;
        $num = $this->num;
        $min = $this->min; 
        for ($i=1;$i<$num;$i++){   
            $safe_total=($total-($num-$i)*$min)/($num-$i);//随机安全上限   
            $money=mt_rand($min*100,$safe_total*100)/100;   
            $total=$total-$money;
				if(($money>10) && ($money<0)){
					$money=mt_rand($min*100,$safe_total*100)/100;
					
				}
            //数据
            $readPack[]= [
                'money'=>$money,
                'balance'=>$total,
            ];
        }
        //最后不用随机       
        /*$readPack[] = [
            'money'=>$money,
            'balance'=>0,
        ];*/
        //返回结果
        return $readPack;
    }

}