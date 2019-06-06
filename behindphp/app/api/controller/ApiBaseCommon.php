<?php
// +----------------------------------------------------------------------
// | Description: Api基础类，验证权限
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------

namespace app\api\controller;

use app\common\controller\ApiBase;


class ApiBaseCommon extends ApiBase
{
    public function _initialize()
    {
        parent::_initialize();
        //权限验证 todo
    }
}
