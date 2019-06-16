<?php

namespace app\common\validate;

/**
 * 验证器
 */
class Work extends ValidateBase
{
    
    // 验证规则
    protected $rule =   [
        
        'title'  => 'require',
        'address'  => 'require',
        'year'  => 'require',
        'study'  => 'require',
        'type'  => 'require',
        'num'  => 'require',
        'desc'  => 'require',
    ];
    
    // 验证提示
    protected $message  =   [
        
        'title.require'    => '标题不能为空',
    ];

    // 应用场景
    protected $scene = [
    		'edit'  =>  ['title','address','year','study','type','num','desc'],
            'add'  =>  ['title','address','year','study','type','num','desc'],
    ];

    
}
