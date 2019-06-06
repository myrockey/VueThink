<?php
// +----------------------------------------------------------------------
// | Author: Zaker <49007623@qq.com>
// +----------------------------------------------------------------------

namespace app\common\validate;

/**
 * 验证器
 */
class Shares extends ValidateBase
{
    
    // 验证规则
    protected $rule = [
//        'title'  => 'require|length:19',
        'title'  => 'require|date|length:12,19',
        'market_connectivity_index'  => 'require',
        'market_overfall_index'  => 'require',

    ];

    // 验证提示
    protected $message = [
        'title.require'    => '发布时间不能为空',
        'title.length'     => '发布时间长度为12,19个字符之间',
        'title.date'     => '发布时间必须为日期格式',
        'market_connectivity_index.require'    => '市场连板指数不能为空',
        'market_overfall_index.require'    => '市场超跌指数不能为空',

    ];

    // 应用场景
    protected $scene = [
       	'edit'  =>  ['title','market_connectivity_index','market_overfall_index'],
        'add'  =>  ['title','market_connectivity_index','market_overfall_index'],
    ];
}
