<?php
// +----------------------------------------------------------------------
// | Description: 菜单
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------

namespace app\api\controller\v1;

use app\api\controller\ApiBaseCommon;
use app\common\logic\Document as LogicDocument;
use app\common\logic\Documentcate as LogicDocumentcate;

/**
 * 文档资源控制器
 */
class Document extends ApiBaseCommon
{

    /**
     * 文章逻辑
     */

    private static $documentLogic = null;
    private static $documentcateLogic = null;
    /**
     * 构造方法
     */
    public function _initialize()
    {

        parent::_initialize();
        self::$documentcateLogic = get_sington_object('documentcateLogic', LogicDocumentcate::class);
        self::$documentLogic = get_sington_object('documentLogic', LogicDocument::class);
    }


    /**
     * 文章列表
     */
    public function index()
    {
        $data = self::$documentLogic->getDocumentList(['m.status'=>1], 'm.*', 'id desc',10);
        return resultArray(['data' => $data]);
    }

    public function lists()
    {
        if (!isset($this->param['tid']) || $this->param['tid'] == '') {

            return resultArray(['error' => '非法操作']);
        }

        $tid = $this->param['tid'];
        $limit = isset($this->param['limit']) ? $this->param['limit'] : 0;
        $data = self::$documentLogic->getDocumentList(['m.status'=>1,'m.tid'=>$tid], 'm.id,m.title,m.create_time', 'id desc',$limit);
        //遍历对象
        $domain = getDomain();
        if(!empty($data)){
            foreach ($data as $key=>$val){
                $data[$key]['path'] = $domain.WEB_PATH_FILE.$val['path'];
            }
        }

        return resultArray(['data' => $data]);


    }

    /**
     * 文章详情
     * @return mixed
     *
     */
    public function read()
    {
        $data = self::$documentLogic->getDocumentInfo(['id' => $this->param['id']]);
        if (!$data) {
            return resultArray(['error' => self::$documentLogic->getError()]);
        }
        return resultArray(['data' => $data]);
    }

} 