<?php

namespace app\admin\controller;


/**
 * 文档控制器
 */
class Topic extends AdminBase
{
    

    /**
     * 构造方法
     */
    public function _initialize()
    {
        
        parent::_initialize();
     
   }

    /**
     * 获取列表搜索条件
     */
    public function getWhere($data = [])
    {
    
    	$where = [];
    
    	$where['m.status']=array('egt',0);
    
    	if (!is_administrator()) {
    
    		 
    	}
    
    	return $where;
    }
    /**
     * 文档列表
     */
    public function topicList()
    {
        
        $where = $this->getWhere($this->param);
        
        $this->assign('list', parent::$commonLogic->getDataList('topic',$where, 'm.*,user.nickname,groupcate.name as gidname,group.name as tidname', 'm.id desc',0,[['user','user.id=m.uid'],['groupcate','groupcate.id=m.gid'],['group','group.id=m.tid']]));
       
       
        return $this->fetch('topic_list');
    }
    
    /**
     * 文档添加
     */
    public function topicAdd()
    {
        
        IS_POST && $this->jump(parent::$commonLogic->dataAdd('topic',$this->param));
        
        return $this->fetch('topic_add');
    }
    /**
     * 文档编辑
     */
    public function topicEdit()
    {
    	$info = parent::$commonLogic->getDataInfo('topic',['id' => $this->param['id']]);
    	IS_POST && $this->jump(parent::$commonLogic->dataEdit('topic',$this->param,$info));
    	
    	
    	$this->assign('info', $info);
    	return $this->fetch('topic_edit');
    }
    /**
     * 文档批量删除
     */
    public function topicAlldel($ids = 0)
    {
    
    	$this->jump(parent::$commonLogic->dataDel('topic',['id'=>array('in',$ids)]));
    }
    /**
     * 文档删除
     */
    public function topicDel($id = 0)
    {
        
        $this->jump(parent::$commonLogic->dataDel('topic',['id' => $id]));
    }
    /**
     * 文档状态更新
     */
    public function topicCstatus($id = 0,$status,$field)
    {
    	
        $this->jump(parent::$commonLogic->setDataValue('topic',['id' => $id],$field,$status));
    }
    /**
     * 文档审核
     */
    public function topicSh($id = 0,$status,$field)
    {
    
    	$this->jump(parent::$commonLogic->setDataValue('topic',['id' => $id],$field,$status));
    }
    
    /**
     * 文档批量审核
     */
    public function topicAllSh($ids = 0)
    {
    
    	$this->jump(parent::$commonLogic->setDataValue('topic',['id'=>array('in',$ids)],$field,$status));
    }
    

}
