<?php
// +----------------------------------------------------------------------
// | Description: 菜单
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------

namespace app\api\controller\v1;

use app\api\controller\ApiBaseCommon;
use app\common\logic\Work as LogicWork;

/**
 * 文章控制器
 */
class Work extends ApiBaseCommon
{

    /**
     * 文章逻辑
     */

    private static $workLogic = null;
    /**
     * 构造方法
     */
    public function _initialize()
    {

        parent::_initialize();
        self::$workLogic = get_sington_object('workLogic', LogicWork::class);
    }

    /**
     * 文章列表
     */
    public function index()
    {
        $where = self::$workLogic->getWhere($this->param);
        $limit = isset($this->param['limit']) ? $this->param['limit'] : 0;
        $data = self::$workLogic->getWorkList($where,true, 'id desc',$limit);

        return resultArray(['data' => $data]);
    }

    /**
     * 文章详情
     * @return mixed
     *
     */
    public function read()
    {
        $data = self::$workLogic->getWorkInfo(['id' => $this->param['id']]);
        if (!$data) {
            return resultArray(['error' => self::$workLogic->getError()]);
        }
        $data['desc'] = htmlspecialchars_decode($data['desc']);
        $data['content'] = htmlspecialchars_decode($data['content']);
        return resultArray(['data' => $data]);
    }

} 