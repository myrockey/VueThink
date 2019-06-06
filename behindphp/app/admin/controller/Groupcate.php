<?php

namespace app\admin\controller;


/**
 * 小组分类控制器
 */
class Groupcate extends AdminBase
{
    
    /**
     * 小组分类逻辑
     */

    /**
     * 构造方法
     */
    public function _initialize()
    {
        
        parent::_initialize();
    
    }

    
    /**
     * 小组分类列表
     */
    public function groupcateList()
    {
        
        $where = parent::$commonLogic->getWhere($this->param);
        
        $this->assign('list', parent::$commonLogic->getDataList('groupcate',$where, true, 'id desc'));
       
       
        return $this->fetch('groupcate_list');
    }
    
    /**
     * 小组分类添加
     */
    public function groupcateAdd()
    {
        
        IS_POST && $this->jump(parent::$commonLogic->dataAdd('groupcate',$this->param));
        
        return $this->fetch('groupcate_add');
    }
    /**
     * 小组分类编辑
     */
    public function groupcateEdit()
    {
    	$info = parent::$commonLogic->getDataInfo('groupcate',['id' => $this->param['id']]);
    	IS_POST && $this->jump(parent::$commonLogic->dataEdit('groupcate',$this->param,$info));
    	
    	
    	$this->assign('info', $info);
    	return $this->fetch('groupcate_edit');
    }
    /**
     * 小组分类批量删除
     */
    public function groupcateAlldel($ids = 0)
    {
    
    	$this->jump(parent::$commonLogic->dataDel('groupcate',['id'=>array('in',$ids)]));
    }
    /**
     * 小组分类删除
     */
    public function groupcateDel($id = 0)
    {
        
        $this->jump(parent::$commonLogic->dataDel('groupcate',['id' => $id]));
    }
    /**
     * 导航状态更新
     */
    public function groupcateCstatus($id = 0,$status)
    {
    
    	$this->jump(parent::$commonLogic->setDataValue('groupcate',['id' => $id],'status',$status));
    }
}
