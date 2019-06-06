<?php
// +----------------------------------------------------------------------
// | Description: 菜单
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------

namespace app\api\controller\v1;

use app\api\controller\ApiBaseCommon;
use app\common\logic\Coor as LogicCoor;

/**
 * 合作伙伴控制器
 */
class Coor extends ApiBaseCommon
{

    /**
     * 文章逻辑
     */

    private static $coorLogic = null;
    /**
     * 构造方法
     */
    public function _initialize()
    {

        parent::_initialize();
        self::$coorLogic = get_sington_object('coorLogic', LogicCoor::class);
    }
    public function index()
    {
        $data = self::$coorLogic->getCoorList(['status'=>1], true, 'id desc',2);
        return resultArray(['data' => $data]);
    }

    public function save()
    {

        $result = self::$coorLogic->coorAdd($this->param);
        if ($result[0] == RESULT_ERROR) {
            return resultArray(['error' => $result[1]]);
        }
        return resultArray(['data' => '添加成功']);
    }

} 