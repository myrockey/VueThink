<?php
namespace app\index\controller;
use app\common\controller\HomeBase;




class Article extends  HomeBase
{
	


	
	public function _initialize()
	{
		parent::_initialize();
		
		
	}
	
   public function index($id){
   	
   	if($id>0){
   		
   	parent::$commonLogic->setDataValue('article',['id'=>$id], 'view', array('exp','view+1'));
   	
   	$info = parent::$commonLogic->getDataInfo('article',['id'=>$id]);
   	
   	$this->assign('info',$info);
   	
   	}else{
   		
   		$this->error('非法操作', 'index/index');
   		
   	}
   	return $this->fetch();
   	
   }
   

   
}
