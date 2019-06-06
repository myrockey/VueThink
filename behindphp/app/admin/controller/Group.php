<?php

namespace app\admin\controller;



class Group extends AdminBase
{
    

	

    /**
     * 构造方法
     */
    public function _initialize()
    {
        
        parent::_initialize();
      
  
    }
    public function getWhere($data = [])
    {
    
    	$where = [];
    
    	
    	!empty($data['pid'])  && $where['pid'] = $data['pid'];
    	if (!is_administrator()) {
    
    		 
    	}
    
    	return $where;
    }
    /**
     * 小组分类列表
     */
    public function groupList()
    {
    
    	
    	
    	$where = $this->getWhere($this->param);
    	
        $where['m.status']=1;
        
    	$this->assign('list', parent::$commonLogic->getDataList('group',$where, 'm.*,user.nickname', 'm.id desc',0,[['user','user.id=m.uid','LEFT']]));

    	$groupcate_list =parent::$commonLogic->getDataList('groupcate',['status'=>1], true, 'id desc',false);
    	if(!empty($groupcate_list)){
    		foreach ($groupcate_list as $k =>$v){
    			 
    			$lsarr[$v['id']]=$v;
    			 
    			 
    		}
    		$this->assign('groupcate_list',$lsarr);
    	}else{
    		$this->assign('groupcate_list','');
    	}
    
    	
    	$this->assign('pid',  !empty($where['pid']) ? $where['pid'] : 0);
    	
    
    	 
    	return $this->fetch('group_list');
    }
    
    /**
     * 小组分类添加
     */
    public function groupAdd()
    {
    
    	
    	$obj=new Callback();
    	
    	
    	$this->assign('groupcate_list',parent::$commonLogic->getDataList('groupcate',['status'=>1], true, 'id desc',false));
    	
    	if(IS_POST){
    	$data=$this->param;
    	$data['describe']=htmlspecialchars_decode($data['describe']);
    	
    	$this->jump(parent::$commonLogic->dataInsert('group',$data,false,'添加成功',$obj,'groupadd_call_back'));
    	}
    	
    	
    	return $this->fetch('group_add');
    }
  
    
    /**
     * 小组分类编辑
     */
    public function groupEdit()
    {
    	$info = parent::$commonLogic->getDataInfo('group',['id' => $this->param['id']]);
    	
    	if(IS_POST){
    		$data=$this->param;
    		
    		$data['describe']=htmlspecialchars_decode($data['describe']);
    		
    		$this->jump(parent::$commonLogic->dataEdit('group',$data,$info));
    	}
    	
    	
    	
    	$this->assign('groupcate_list',parent::$commonLogic->getDataList('groupcate',['status'=>1], true, 'id desc',false));
    	 
    	$this->assign('info', $info);
    	return $this->fetch('group_edit');
    }
    /**
     * 小组分类批量删除
     */
    public function groupAlldel($ids = 0)
    {
    
    	$this->jump(parent::$commonLogic->dataDel('group',['id'=>array('in',$ids)]));
    }
    /**
     * 小组分类删除
     */
    public function groupDel($id = 0)
    {
    
    	$this->jump(parent::$commonLogic->dataDel('group',['id' => $id]));
    }
    /**
     * 导航状态更新
     */
    public function groupCstatus($id = 0,$status)
    {
    
    	$this->jump(parent::$commonLogic->setDataValue('group',['id' => $id],'status',$status));
    }

}
