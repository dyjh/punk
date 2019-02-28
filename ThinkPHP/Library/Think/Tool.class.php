<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/17 0017
 * Time: 下午 4:11
 */

namespace Think;


class Tool
{
    /*
     * 普通分页
     * $database 目标数据表
     * $where 查询条件
     * $o 当前页
     * $per_num 每页显示条数
     * $showPage 页码显示数量
     */
    public function Page($database,$where,$o,$per_num,$showPage,$join,$field,$order){
		//print_r($join);
        $case=M($database);
        //echo $where;
        $count= $case->join($join)->where($where)->filter('strip_tags')->count();   //得到总的条数
        //$per_num = 4;  //每页显示的条数
        $pages = ceil($count/$per_num);

        if($o<1){
            $o =1;
        }else if($o > $pages){
            $o = $pages;
        }
        $start_page=$o-floor($showPage/2);
        $end_page=$o+floor($showPage/2);
        if($o-$showPage < 1){
            $start_page = 1;
            $end_page = $showPage;
        }
        if($o+$showPage > $pages){
            $end_page = $pages;
            $start_page = $pages-$showPage+1;
        }
        if($pages < $showPage){
            $start_page = 1;
            $end_page = $pages;
        }
//$page=array(1,7);
		
/////**/
        $data = $case->join($join)->where($where)->field($field)->filter('strip_tags')->limit((($o-1)*$per_num).','.$per_num)->order($order)->select();
        // $data = $case->limit('1,7')->select();//
		//echo $case->getlastsql();
		//echo '<br/>'.$o.','.$per_num.'./1';die;
        if(empty($data)){
            $page['state']=0;
        }else{
            $page['state']=1;
        }
        $page['count']=$pages;
        $page['data']=$data;
        //$page['start_page']=$start_page;
        //$page['end_page']=$end_page+1;
        $page['o']=$o;
        return $page;
    }
    /*
     * 数组分页
     * $num 每页显示条数
     * $data 目标数组
     * $showPage 页码显示数量//
     * $o 当前页
     */
    public function Page_arr($data,$num,$showPage,$o){
        $count=count($data);//得到数组元素个数
        $pages = ceil($count/$num);
        if($o<1){
            $o =1;
        }else if($o > $pages){
            $o = $pages;
        }
        $start_page=$o-floor($showPage/2);
        $end_page=$o+floor($showPage/2);
        //起始页
        if($o-$showPage < 1){
            $start_page = 1;
            $end_page = $showPage;
        }
        //结束页
        if($o+$showPage > $pages){
            $end_page = $pages;
            $start_page = $pages-$showPage+1;
        }
        if($pages < $showPage){
            $start_page = 1;
            $end_page = $pages;
        }
        $res =array_slice($data,($o-1)*$num,$num);
        if(empty($data)){
            $page['state']=0;
        }else{
            $page['state']=1;
        }
        $page['data']=$res;
        $page['count']=$pages;
        //$page['end_page']=$end_page+1;
        $page['o']=$o;
        return $page;
    }


    public function time($start_time,$end_time){
        if($start_time==''){
            $start_time = mktime(0,0,0,date('m'),1,date('Y'));
            $start_times=''.date('Y').'-'.date('m').'-01';
        }else{
            $s_y=substr($start_time,0,4);
            $s_m=substr($start_time,5,2);
            $s_d=substr($start_time,8,2);
            $s_h=substr($start_time,11,2);
            $s_i=substr($start_time,14,2);
            $s_s=substr($start_time,17,2);
            $start_time = mktime($s_h,$s_i,$s_s,$s_m,$s_d,$s_y);
        }
        if($end_time==''){
            $end_time=time();
            $end_times=date('Y-m-d H:i:s');
        }else{
            $e_y=substr($end_time,0,4);
            $e_m=substr($end_time,5,2);
            $e_d=substr($end_time,8,2);
            $e_h=substr($end_time,11,2);
            $e_i=substr($end_time,14,2);
            $e_s=substr($end_time,17,2);
            $end_time = mktime($e_h,$e_i,$e_s,$e_m,$e_d,$e_y);
        }
        $data['start']=$start_time;
        $data['starts']=$start_times;
        $data['end']=$end_time;
        $data['ends']=$end_times;
        return $data;
    }
}