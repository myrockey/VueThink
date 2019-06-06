<?php

namespace app\admin\controller;

use app\common\logic\Member as LogicMember;
use app\admin\logic\AuthGroup as LogicAuthGroup;

/**
 * 前台会员控制器
 */
class Member extends AdminBase
{
    
    /**
     * 会员逻辑
     */
	
    private static $memberLogic = null;
    
    /**
     * 构造方法
     */
    public function _initialize()
    {
        
        parent::_initialize();
      
        self::$memberLogic = get_sington_object('memberLogic', LogicMember::class);
    }

    /**
     * 会员授权
     */
    public function memberAuth()
    {
        
        IS_POST && $this->jump(self::$memberLogic->addToGroup($this->param));
        
        $authGroupLogic = get_sington_object('authGroupLogic', LogicAuthGroup::class);
        
        // 所有的权限组
        $group_list = $authGroupLogic->getAuthGroupList();
        
        // 会员当前权限组
        $member_group_list = $this->authGroupAccessLogic->getMemberGroupInfo($this->param['id']);

        // 选择权限组
        $list = $authGroupLogic->selectAuthGroupList($group_list, $member_group_list);
        
        $this->assign('list', $list);
        
        $this->assign('id', $this->param['id']);
        
        return $this->fetch('user_auth');
    }
    /**
     * 修改密码
     */
    public function changePass()
    {
    	 
    	$info = self::$memberLogic->getMemberInfo(['id' => MEMBER_ID]);
    	IS_POST&& $this->jump(self::$memberLogic->setMemberPassword($this->param,$info));
    	 
    
    
    
    	$this->assign('info', $info);
    	return $this->fetch('change_pass');
    }
    /**
     * 会员列表
     */
    public function memberList()
    {
        
        $where = self::$memberLogic->getWhere($this->param);

        $this->assign('list', self::$memberLogic->getMemberList($where, true, 'id desc'));
       
       
        return $this->fetch('member_list');
    }
    
    /**
     * 会员添加
     */
    public function memberAdd()
    {
        
        IS_POST && $this->jump(self::$memberLogic->memberAdd($this->param));
        
        return $this->fetch('user_add');
    }
    /**
     * 会员编辑
     */
    public function memberEdit()
    {
    	$info = self::$memberLogic->getMemberInfo(['id' => $this->param['id']]);
    	IS_POST && $this->jump(self::$memberLogic->memberEdit($this->param,$info));
    	
    	
    	$this->assign('info', $info);
    	return $this->fetch('user_edit');
    }
    /**
     * 会员查看
     */
    public function memberShow()
    {
    	$info = self::$memberLogic->getMemberInfo(['id' => $this->param['id']]);

    	$this->assign('info', $info);
    	return $this->fetch('member_show');
    }
    /**
     * 会员批量删除
     */
    public function memberAlldel($ids = 0)
    {
    
    	$this->jump(self::$memberLogic->memberAlldel($ids));
    }
    /**
     * 会员删除
     */
    public function memberDel($id = 0)
    {
        
        $this->jump(self::$memberLogic->memberDel(['id' => $id]));
    }
}
