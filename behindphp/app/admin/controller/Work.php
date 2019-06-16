<?php

namespace app\admin\controller;

use app\common\logic\Work as LogicWork;

/**
 * 文章控制器
 */
class Work extends AdminBase
{
    
    /**
     * 文章逻辑
     */
	
    private static $workLogic = null;
    /**
     * 构造方法
     */
    public function _initialize()
    {
        
        parent::_initialize();
        self::$workLogic = get_sington_object('workLogic', LogicWork::class);
    }

    
    /**
     * 文章列表
     */
    public function workList()
    {
        
        $where = self::$workLogic->getWhere($this->param);
        
        $this->assign('list', self::$workLogic->getWorkList($where, true, 'id desc'));
       
       
        return $this->fetch('work_list');
    }
    
    /**
     * 文章添加
     */
    public function workAdd()
    {
        
        IS_POST && $this->jump(self::$workLogic->workAdd($this->param));
        return $this->fetch('work_add');
    }
    /**
     * 文章编辑
     */
    public function workEdit()
    {
    	$info = self::$workLogic->getWorkInfo(['id' => $this->param['id']]);
    	IS_POST && $this->jump(self::$workLogic->workEdit($this->param,$info));
    	
    	$this->assign('info', $info);
    	return $this->fetch('work_edit');
    }
    /**
     * 文章批量删除
     */
    public function workAlldel($ids = 0)
    {
    
    	$this->jump(self::$workLogic->workAlldel($ids));
    }
    /**
     * 文章删除
     */
    public function workDel($id = 0)
    {
        
        $this->jump(self::$workLogic->workDel(['id' => $id]));
    }


}
