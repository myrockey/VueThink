<?php

namespace app\common\logic;

/**
 * 股票逻辑
 */
class Shares extends LogicBase
{
    
    // 文章模型
    public static $sharesModel = null;
    
    /**
     * 构造方法
     */
    public function __construct()
    {
        
        parent::__construct();
        
        self::$sharesModel = model($this->name);
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
     * 获取文章列表
     */
    public function getSharesList($where = [], $field = true, $order = '', $paginate = 0)
    {
        return self::$sharesModel->getList($where, $field, $order, $paginate);
    }
    
    /**
     * 获取文章信息
     */
    public function getSharesInfo($where = [], $field = true)
    {
        
        return self::$sharesModel->getInfo($where, $field);
    }
    
    
    /**
     * 文章添加
     */
    public function sharesAdd($data = [])
    {

        $validate = validate($this->name);
        
        $validate_result = $validate->scene('add')->check($data);
        
        if (!$validate_result) : return [RESULT_ERROR, $validate->getError()]; endif;
        
        $url = url('configList');
        
        return self::$sharesModel->setInfo($data) ? [RESULT_SUCCESS, '文章添加成功', $url] : [RESULT_ERROR, self::$sharesModel->getError()];
    }
    
    /**
     * 文章编辑
     */
    public function sharesEdit($data = [])
    {
        
        $validate = validate($this->name);
        
        $validate_result = $validate->scene('edit')->check($data);
        
        if (!$validate_result) : return [RESULT_ERROR, $validate->getError()]; endif;
        
        $url = url('configList');

        return self::$sharesModel->setInfo($data) ? [RESULT_SUCCESS, '文章编辑成功', $url] : [RESULT_ERROR, self::$sharesModel->getError()];
    }
    /**
     * 设置文章信息
     */
    public function setArticleValue($where = [], $field = '', $value = '')
    {
    	 
    	return self::$sharesModel->setFieldValue($where, $field, $value) ? [RESULT_SUCCESS, '状态更新成功'] : [RESULT_ERROR, self::$sharesModel->getError()];
    }
    /**
     * 文章删除
     */
    public function articleDel($where = [])
    {
        
        return self::$sharesModel->deleteInfo($where,true) ? [RESULT_SUCCESS, '文章删除成功'] : [RESULT_ERROR, self::$sharesModel->getError()];
    }
    
    /**
     * 批量删除
     */
    public function articleAlldel($ids)
    {
    	

    return self::$sharesModel->deleteAllInfo(['id'=>array('in',$ids)],true) ? [RESULT_SUCCESS, '文章删除成功'] : [RESULT_ERROR, self::$sharesModel->getError()];
    }  


}
