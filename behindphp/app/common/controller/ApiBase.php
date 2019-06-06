<?php
/**
 * api接口基类
 */
namespace app\common\controller;

use think\Controller;
use think\Request;
class ApiBase extends Controller
{
    // 请求参数
    public $param;
    public $captcha;
    /**
     * 基类初始化
     */
    protected function _initialize()
    {
        parent::_initialize();
        $param =  Request::instance()->param();
        $this->param = $param;
        $this->captcha = new \think\captcha\Captcha(config('captcha'));
    }

    /**
     * 验证码调用
     */
    public function captchaShow()
    {

        return $this->captcha->entry();
    }
    /**
     * 验证码验证
     */
    public function captchaCheck($code)
    {

        return $this->captcha->check($code);
    }
}
