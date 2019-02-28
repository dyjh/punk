<?php
/**
 * Created by Dr.耗子.
 * User: Administrator
 * Date: 2017/12/26 0026
 * Time: 上午 11:11
 */

namespace Think;


class Account
{
    private $data=array();

    public function __construct($data)
    {
        /*
         * $data['user']:手机号
         * $data['num_id']:编号
         * $data['trade_password']:姓名
         * $data['bank_name']:姓名
         * $data['bank_adress']:姓名
         * $data['bank_number']:姓名
         * $data['name']:姓名
         * $data['password']:密码
         * $data['state']:0 下级注册 1 顶级注册
         * $data['referrer']:推荐人
         */
        $this->data = $data;  //接收用户数据
    }

    public function login(){
        $key = 'IH^&*%545qg'.$this->data['user'];
        $member=M('members')->where('user=%s',array($this->data['user']))->field('user,num_id,name,user_titles')->find();

        if(empty($member)){
            return 'no';
        }
		
        //$check=M('user_titles')->where('num_id="%s"',array($member['num_id']))->find();
        if($member['user_titles']==1){
            return 'titles';
        }
        $this->data['password'] = access_md16( $this->data['password'] , $key );
        $data=M('members')->where('user="'.$this->data['user'].'" AND password = "'.$this->data['password'].'"')->find();
		$coin=M('user_coin')->where('num_id="'.session('num_id').'"')->find();
        //echo M()->getLastSql();die;
        if(!empty($data)){
            session_start();
			$_SESSION['money']=$coin['all_money'];
			$_SESSION['name']=$member['name'];
            $_SESSION['user']=$member['user'];
            $_SESSION['num_id']=$member['num_id'];
            return 'success';
        }else{
            return 'error';
        }
    }

    public function regist(){
        $key = 'IH^&*%545qg'.$this->data['user'];
		//print_r($this->data);
        $this->data['password'] = access_md16( $this->data['password'] , $key );
        $this->data['trade_password'] = access_md16( $this->data['trade_password'] , $key );
		//print_r($this->data);die;
        //生成ID////
        $this->data['num_id'] = $this->get_id($this->data['user']);
        $check=M('members')->where('user=%s',array($this->data['user']))->find();
        if(!empty($check)){
            return 'already';
        }
        M()->startTrans();
        if( $this->add_data() ){
            if( $this->set_relation() ){
                M()->commit();
                return 'success';
            }else{
				//echo 1;
				die;
                M()->rollback();
                return 'error1';
            }
        }else{
            M()->rollback();
            return 'error2';
        }
    }

    //添加基础信息
    private function add_data(){
        $this->data['regist_time']=time();
        if(M('members')->add($this->data)){
            $add['num_id']=$this->data['num_id'];
            if(M('user_coin')->add($add)){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    //建立推荐关系
    public function set_relation(){
        switch( $this->data['state'] ){
            case '0':    //次级注册
                
                $referrer=M('recommend_relation')->where('num_id="%s"',array( $this->data['referrer'] ))->find();
				//echo M('recommend_relation')->getLastSql();
                if(!empty($referrer)){
                    $team['team'] = $referrer['team'].' '.$this->data['referrer'];
                    $team['recommend'] = $this->data['referrer'];
                    $team['num_id'] = $this->data['num_id'];
                    $save['direct_num'] = array('exp','direct_num+1');
                    $save['team_num'] = array('exp','team_num+1');
					
					/*print_r($this->data['referrer']);
					print_r($this->data['referrer']);
					die;*/
                    if(/*M('recommend_relation')->where('num_id="%s"',array( $this->data['referrer'] ))->save($save) !== false &&*/ M('recommend_relation')->add($team)){
                        //echo 111;die;
                        /*$superior = array_values(array_filter(explode(' ',$referrer['team'] )));
                        $superior_t = array_values(array_filter(explode(' ',$team['team'] )));
                        if(empty($superior)){
                            return true;
                        }
                        foreach ($superior as $key => $val ){
                            $save_team['team_num'] = array('exp','team_num+1');
                            if(M('recommend_relation')->where('num_id="%s"',array( $val ))->save($save_team) == false){
                                return false;
                            }
                        }
						if(!empty($superior_t)){
							$level=M('rebate_conf')->select();
							$count_le=count($level);
							foreach($superior_t as $k=>$v){
								$num_data=M('recommend_relation')->where('num_id="%s"',array( $v ))->find();
								
								for($i=$count_le-1;$i>=0;$i--){
									if($num_data['direct_num']>=$level[$i]['direct_num']&&$num_data['team_num']>=$level[$i]['team_num']){
										$level_name=$level[$i]['name'];
										break;
									}
								}
								if(!empty($level_name)){
									$save_member['level']=$level_name;
									if(M('members')->where('num_id="%s"',array( $v ))->save($save_member)==false){
										return false;
									}
								}
							}
						}*/
						
                        return true;
                    }
                }else{
                    return false;
                }
                break;
            case '1':  //顶级注册
                $team['num_id'] = $this->data['num_id'];
                if(M('recommend_relation')->add($team)){
                    return true;
                }else{
                    return false;
                }
                break;
        }
    }


    /*
     * 获取num_id
     */
    private function get_id(){
//        echo $this->data['user'];die;

        $num_tel=substr($this->data['user'],8,3);
        $num_time=rand(0,9).''.rand(0,9).''.rand(0,9);
        $num_id='zc';
        $num_id.=$num_tel;
        $num_id.=$num_time;
        //echo $num_id;
        $res=M('members')->where('num_id="'.$num_id.'"')->select();
        if(!empty($res)){
            //print_r($res);die;
            //return $this->get_id();
        }else{
            return $num_id;
        }
    }
}