<?php

namespace app\common\logic;

/**
 * 逻辑
 */
class Coor extends LogicBase
{
    
    // 模型
    public static $coorModel = null;
    
    /**
     * 构造方法
     */
    public function __construct()
    {
        
        parent::__construct();
        
        self::$coorModel = model($this->name);
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
    public function getCoorList($where = [], $field = true, $order = '', $paginate = 0)
    {
        return self::$coorModel->getList($where, $field, $order, $paginate);
    }
    
    /**
     * 获取信息
     */
    public function getCoorInfo($where = [], $field = true)
    {
        
        return self::$coorModel->getInfo($where, $field);
    }
    
    
    /**
     * 添加
     */
    public function coorAdd($data = [])
    {
        
        $validate = validate($this->name);
        
        $validate_result = $validate->scene('add')->check($data);
        
        if (!$validate_result) : return [RESULT_ERROR, $validate->getError()]; endif;
        
        $url = url('configList');

        if(isset($data['companyDesc'])){
            $data['companyDesc']=htmlspecialchars_decode($data['companyDesc']);
        }

        return self::$coorModel->setInfo($data) ? [RESULT_SUCCESS, '添加成功', $url] : [RESULT_ERROR, self::$coorModel->getError()];
    }
    
    /**
     * 编辑
     */
    public function coorEdit($data = [])
    {
        
        $validate = validate($this->name);
        
        $validate_result = $validate->scene('edit')->check($data);
        
        if (!$validate_result) : return [RESULT_ERROR, $validate->getError()]; endif;
        
        $url = url('configList');

        if(isset($data['companyDesc'])){
            $data['companyDesc']=htmlspecialchars_decode($data['companyDesc']);
        }
        
        return self::$coorModel->setInfo($data) ? [RESULT_SUCCESS, '编辑成功', $url] : [RESULT_ERROR, self::$coorModel->getError()];
    }
    /**
     * 设置信息
     */
    public function setCoorValue($where = [], $field = '', $value = '')
    {
    	 
    	return self::$coorModel->setFieldValue($where, $field, $value) ? [RESULT_SUCCESS, '状态更新成功'] : [RESULT_ERROR, self::$coorModel->getError()];
    }
    /**
     * 删除
     */
    public function coorDel($where = [])
    {
        
        return self::$coorModel->deleteInfo($where,true) ? [RESULT_SUCCESS, '删除成功'] : [RESULT_ERROR, self::$coorModel->getError()];
    }
    
    /**
     * 批量删除
     */
    public function coorAlldel($ids)
    {
    	

        return self::$coorModel->deleteAllInfo(['id'=>array('in',$ids)],true) ? [RESULT_SUCCESS, '删除成功'] : [RESULT_ERROR, self::$coorModel->getError()];
    }  


}
