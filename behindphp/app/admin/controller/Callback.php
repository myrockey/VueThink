<?php

namespace app\admin\controller;
use think\Controller;


class Callback extends Controller
{
	public function groupadd_call_back($result,$data){
		 
		$insert['group_id']=$result;
		$insert['uid']=$data['uid'];
		$insert['grade']=2;
		$insert['create_time']=time();
		model('user_group')->insert($insert);
		 
	}
  

}
