<?php

namespace app\admin\logic;

use app\common\logic\User as LogicMember;

/**
 * 登录逻辑
 */
class Login extends AdminBase
{
    
    /**
     * 登录处理
     */
    public function loginHandle($username = '', $password = '', $verify = '')
    {
    	
        if (empty($username) || empty($password)) : return [RESULT_ERROR, '账号或密码不能为空']; endif;
        $yzm_list = parse_config_array('yzm_list');//1\注册2\登录3\忘记密码4\后台登录
        if(in_array(4, $yzm_list)){
        	
        	 if (empty($verify)) : return [RESULT_ERROR, '验证码不能为空']; endif;
        	 if (!captcha_check($verify)) : return [RESULT_ERROR, '验证码输入错误']; endif;
        	
        }
       
       
        
        
        $memberLogic = get_sington_object('memberLogic', LogicMember::class);
        
        $member = $memberLogic->getMemberInfo(['username' => $username]);

        if (empty($member)) : return [RESULT_ERROR, '用户不存在']; endif;
        
        
       
        // 验证用户密码
        if (md5($password.$member['salt']) === $member['password']) {
        	$memberLogic->setMemberValue(['id' => $member['id']], 'last_login_time', TIME_NOW);
        	
        	$auth = ['member_id' => $member['id'], 'last_login_time' => TIME_NOW];
        	
        	
            //$auth = ['member_id' => $member['id'], 'last_login_time' => $member['last_login_time']];
            session('member_info', $member);
            session('member_auth', $auth);
            session('member_auth_sign', data_auth_sign($auth));

            return [RESULT_SUCCESS, '登录成功', url('Index/adminindex')];

        } else {
            
            return [RESULT_ERROR, '密码输入错误'];
        }
    }
    public function locker($username,$password){
    	
    	$memberLogic = get_sington_object('memberLogic', LogicMember::class);
    	
    	$member = $memberLogic->getMemberInfo(['username' => $username]);
    	if (md5($password.$member['salt']) === $member['password']) {
    		
    		$memberLogic->setMemberValue(['id' => $member['id']], 'last_login_time', TIME_NOW);
    		 
    		$auth = ['member_id' => $member['id'], 'last_login_time' => TIME_NOW];
    		 
    		 
    		//$auth = ['member_id' => $member['id'], 'last_login_time' => $member['last_login_time']];
    		session('member_info', $member);
    		session('member_auth', $auth);
    		session('member_auth_sign', data_auth_sign($auth));
    	
    		return [RESULT_SUCCESS, '登录成功'];
    	
    	} else {
    	
    		return [RESULT_ERROR, '密码输入错误'];
    	}
    }
    /**
     * 注销当前用户
     */
    public function logout()
    {
    	session('member_info', null);
        session('member_auth', null);
        session('member_auth_sign', null);
        session('[destroy]');
        
        return [RESULT_SUCCESS, '注销成功', url('Login/login')];
    }
    /**
     * 清理缓存
     */
    public function clearCache()
    {
    
    	\think\Cache::clear();
    	
    	
    	array_map('unlink', glob(TEMP_PATH . '/*.php'));
    	delete_dir_file(LOG_PATH);
    
    	return [RESULT_SUCCESS, '清理成功', url('index/adminindex')];
    }
}
