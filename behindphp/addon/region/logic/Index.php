<?php
// +----------------------------------------------------------------------
// | Author: Zaker <49007623@qq.com>
// +----------------------------------------------------------------------

namespace addon\region\logic;

use think\Db;

/**
 * 省市县三级联动插件逻辑
 */
class Index
{

    /**
     * 组合下拉框选项信息
     */
    public function combineOptions($id = 0, $list = [], $default_option_text = '')
    {
        
        $data = "<option value =''>$default_option_text</option>";
        
        foreach ($list as $vo)
        {
            $data .= "<option ";
            
            if ($id == $vo['id']) : $data .= " selected "; endif;
            
            $data .= " value ='" . $vo['id'] . "'>" . $vo['name'] . "</option>";
        }
        
        return $data;
    }
    
    /**
     * 获取区域列表
     */
    public function getList($where = [])
    {
        
        $cache_key = 'cache_region_' . md5(serialize($where));
        
        $cache_list = cache($cache_key);
        
        if (!empty($cache_list)) : return $cache_list; endif;
        
        $list = Db::name('region')->where($where)->field(true)->select();
        
        !empty($list) && cache($cache_key, $list);
        
        return $list;
    }
}
