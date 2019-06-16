<?php

namespace app\common\logic;

/**
 * 逻辑
 */
class Work extends LogicBase
{
    
    // 模型
    public static $workModel = null;

    /**
     * 构造方法
     */
    public function __construct()
    {
        
        parent::__construct();
        
        self::$workModel = model($this->name);
    }
    /**
     * 获取列表搜索条件
     */
    public function getWhere($data = [])
    {
    
    	$where = [];
    
    	!empty($data['search_data']) && $where['name'] = ['like', '%'.$data['search_data'].'%'];
    
    	if (!is_administrator()) {
    
    		 
    	}
    
    	return $where;
    }
    /**
     * 获取列表
     */
    public function getWorkList($where = [], $field = true, $order = '', $paginate = 0)
    {
        return self::$workModel->getList($where, $field, $order, $paginate);
    }
    
    /**
     * 获取信息
     */
    public function getWorkInfo($where = [], $field = true)
    {
        
        return self::$workModel->getInfo($where, $field);
    }
    
    
    /**
     * 添加
     */
    public function workAdd($data = [])
    {
        
        $validate = validate($this->name);
        
        $validate_result = $validate->scene('add')->check($data);
        
        if (!$validate_result) : return [RESULT_ERROR, $validate->getError()]; endif;
        
        $url = url('configList');

        if(isset($data['desc'])){
            $data['desc']=htmlspecialchars_decode($data['desc']);
        }
        if(isset($data['content'])){
            $data['content']=htmlspecialchars_decode($data['content']);
        }

        return self::$workModel->setInfo($data) ? [RESULT_SUCCESS, '添加成功', $url] : [RESULT_ERROR, self::$workModel->getError()];
    }
    
    /**
     * 编辑
     */
    public function workEdit($data = [])
    {
        
        $validate = validate($this->name);
        
        $validate_result = $validate->scene('edit')->check($data);
        
        if (!$validate_result) : return [RESULT_ERROR, $validate->getError()]; endif;
        
        $url = url('configList');

        if(isset($data['desc'])){
            $data['desc']=htmlspecialchars_decode($data['desc']);
        }
        if(isset($data['content'])){
            $data['content']=htmlspecialchars_decode($data['content']);
        }
        
        return self::$workModel->setInfo($data) ? [RESULT_SUCCESS, '编辑成功', $url] : [RESULT_ERROR, self::$workModel->getError()];
    }
    /**
     * 设置信息
     */
    public function setWorkValue($where = [], $field = '', $value = '')
    {
    	 
    	return self::$workModel->setFieldValue($where, $field, $value) ? [RESULT_SUCCESS, '状态更新成功'] : [RESULT_ERROR, self::$workModel->getError()];
    }
    /**
     * 删除
     */
    public function workDel($where = [])
    {
        
        return self::$workModel->deleteInfo($where,true) ? [RESULT_SUCCESS, '删除成功'] : [RESULT_ERROR, self::$workModel->getError()];
    }
    
    /**
     * 批量删除
     */
    public function workAlldel($ids)
    {
    	

        return self::$workModel->deleteAllInfo(['id'=>array('in',$ids)],true) ? [RESULT_SUCCESS, '删除成功'] : [RESULT_ERROR, self::$workModel->getError()];
    }  


}
