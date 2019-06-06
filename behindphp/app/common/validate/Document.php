<?php
// +----------------------------------------------------------------------
// | Author: Zaker <49007623@qq.com>
// +----------------------------------------------------------------------

namespace app\common\validate;

/**
 * 验证器
 */
class Document extends ValidateBase
{
    
    // 验证规则
    protected $rule = [
        'title'  => 'require',
        'attatchment_id'  => 'require|gt:0',

    ];

    // 验证提示
    protected $message = [
        'title.require'    => '名称不能为空',
        'attatchment_id.require'    => '附件不能为空',
        'attatchment_id.gt'    => '附件不能为空',

    ];

    // 应用场景
    protected $scene = [
       	'edit'  =>  ['title','attatchment_id'],
        'add'  =>  ['title','attatchment_id'],
    ];
}
