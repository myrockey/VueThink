<?php
namespace app\common\controller;
use think\Cache;
use app\common\logic\Common as LogicCommon;
use app\common\logic\Member as LogicMember;
class HomeBase extends ControllerBase
{
	private static $navLogic = null;
	private static $memberLogic = null;
	public static $commonLogic = null;

    protected function _initialize()
    {
            parent::_initialize();
      
      
       self::$commonLogic = get_sington_object('commonLogic', LogicCommon::class);
       self::$memberLogic = get_sington_object('memberLogic', LogicMember::class);

       $this->assign('actionname',strtolower(CONTROLLER_NAME.'/'.ACTION_NAME));
       
      if(!empty(session('member_info'))){
      	
      	$userinfo= self::$commonLogic->getDataInfo('member',['id'=>session('member_info')['id']]);
      	$this->assign('userinfo',$userinfo);
      	
      }
      
     
       $this->getSystem();//获得全站配置信息
       $this->getNav();//获取前台导航
       $this->wxlogin();//直接授权微信登录
       $this->autologin();
       $this->wxShareJsapi();//微信自定义分享

       
       $pointarr=parse_config_attr(config('scoretype_list'));
       //获得升级积分
       $this->assign('gpointname',$pointarr['expoint1']);
       //获得下载上传的积分名称
       
       $this->assign('pointname',$pointarr['point']);
       
    }

    /**
     * 微信网页授权登录
     */
    public function wxlogin(){
        if(!is_login()) {
            $code = request()->param('code', "");
            $wchat = new \wechatlogin\wechatOauth();
            $wxuserinfo = $wchat->getUserAccessUserInfo($code);
            if (isset($wxuserinfo['errcode']) && $wxuserinfo['errcode'] == 0) {
                $this->jump(([RESULT_ERROR, '获取微信授权信息失败', url('member/index')]));
            }
            $memberInfo = self::$memberLogic->getMemberInfo(['status' => 1, 'openid' => $wxuserinfo['openid']]);
            if ($memberInfo) {
                $this->jump(self::$memberLogic->loginAuto($memberInfo,$wxuserinfo));
            } else {
                $res = self::$memberLogic->regWechatHandle($wxuserinfo);
                if ($res[0] == RESULT_SUCCESS) {
                    $memberInfo = self::$memberLogic->getMemberInfo(['status' => 1, 'openid' => $wxuserinfo['openid']]);
                    $this->jump(self::$memberLogic->loginAuto($memberInfo));
                } else {
                    $this->jump(([RESULT_ERROR, '注册失败', url('member/index')]));
                }
            }
        }
    }
    public function autologin(){
    	
    	if(!is_login()){
    		
    		$user = unserialize(decrypt(cookie('sys_key')));
    		if ((empty($user['userinfo']))){
    			 
    		}else {
    			
    			self::$commonLogic->setDataValue('user',['id' => $user['userinfo']['id']], 'last_login_time', TIME_NOW);
    			//self::$memberLogic->setMemberValue(['id' => $user['userinfo']['id']], 'last_login_time', TIME_NOW);
    			 
    			$auth = ['member_id' => $user['userinfo']['id'], 'last_login_time' => TIME_NOW];
    			$cook=array('id'=>$user['userinfo']['id'], 'userinfo'=>$user['userinfo'],'auth'=>$auth);
    			systemSetKey($cook);
    			 
    			
    			session('member_info', $user['userinfo']);
    			session('member_auth', $auth);
    			session('member_auth_sign', data_auth_sign($auth));
    			 
    			 
    		}
    		
    		
    	}
    	
    	
    }

    /**
     * 微信自定义分享
     */
    public function wxShareJsapi(){
        $jssdk = new \jssdk\JSSDK();
        $signPackage = $jssdk->GetSignPackage();
        $signPackage['title'] = '周期研习社';
        $signPackage['desc'] = '专注于短线投资研究，赢在起跑线！';
        $signPackage['imgurl'] = 'http://'.$_SERVER['HTTP_HOST'].'/public/h5/images/tab03.png';
        $this->assign('signPackage',$signPackage);
    }
  
    /**
     * 获取站点信息
     */
    public function getSystem()
    {

    }

    /**
     * 获取前端导航列表
     */
    public function getNav()
    {
        if (Cache::has('nav')) {
            $nav = Cache::get('nav');
        } else {
            
            $nav =   self::$commonLogic->getDataList('nav',['status' => 1], true, 'sort asc',false);
            if (!empty($nav)) {
                Cache::set('nav', $nav);
            }
        }

        $this->assign('nav', $nav);
       
    }


}