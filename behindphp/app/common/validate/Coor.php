<?php

namespace app\common\validate;

/**
 * 验证器
 */
class Coor extends ValidateBase
{
    
    // 验证规则
    protected $rule =   [
        
        'companyName'  => 'require',
        'companyUrl'  => 'require',
        'companyContact'  => 'require',
        'tel'  => 'require|checkMobile',
    ];
    
    // 验证提示
    protected $message  =   [
        
        'companyName.require'    => '公司名称不能为空',
        'companyUrl.require'    => '公司网址不能为空',
        'companyContact.require'    => '联系人不能为空',
        'tel.require'    => '手机号码不能为空',
        'tel.checkMobile'    => '手机号码格式不对',
    ];

    // 应用场景
    protected $scene = [
    		'edit'  =>  ['companyName','companyUrl','companyContact','tel'],
            'add'  =>  ['companyName','companyUrl','companyContact','tel'],
    ];

    protected function checkMobile($value){
        if(preg_match('/^1[34578]\d{9}$/ims',$value)){
            return true;
        }else{
            return false;
        }
    }
    
}
