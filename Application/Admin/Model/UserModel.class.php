<?php
namespace Admin\Model;
use Think\Model\ViewModel;
class UserModel extends ViewModel {
   public $viewFields = array(
     'members'=>array('num_id','user','name','bank_name','bank_adress','bank_number','regist_time','login_time','user_titles'),
     'user_coin'=>array('dynamic_money','static_money','all_money','_on'=>'members.num_id=user_coin.num_id'),
     'recommend_relation'=>array('recommend','team','direct_num','team_num', '_on'=>'members.num_id=recommend_relation.num_id'),
   );
}