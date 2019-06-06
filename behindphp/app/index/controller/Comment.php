<?php
namespace app\index\controller;
use app\common\controller\HomeBase;



class Comment extends  HomeBase
{
	
	public function _initialize()
	{
		parent::_initialize();
		
	}
	
   public function addcomment(){
   	
   $data=$this->param;
   $data['uid']=session('member_info')['id'];

   $where['uid']=$data['uid'];
   $where['fid']=$data['fid'];
   
   if(model('comment')->where($where)->count()>0){
   	$this->jump([RESULT_ERROR, '已对该文档进行过评论']);
   }else{
   	$this->jump(parent::$commonLogic->dataAdd('comment',$data,true,'添加评论成功'));
   }
   
   	
   	
   }
}
