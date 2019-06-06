<?php
namespace app\payment\controller;

use think\Request;

class Error
{
    public function index(Request $request)
    {
        //根据当前控制器名来判断要执行
        $cityName = $request->controller();
        return $this->_empty($cityName);
    }

    public function _empty($name)
    {
        //把所有城市的操作解析到city方法
        return '
                <div id="error" style="text-align: center;font-size: 30px;">
                <div class="error_message"><h1 style="font-size: 40px;">404</h1>
                <br>您正在浏览的页面被删除或者丢失了！</div><div class="error_link">
                <a href="javascript:history.back()">回到上一页</a>
                <a href="/" class="back-index">回到首页</a>
                </div>
                </div>';

    }
}