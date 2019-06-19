<?php
// +----------------------------------------------------------------------
// | Description: 菜单
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------

namespace app\api\controller\v1;

use app\api\controller\ApiBaseCommon;
use app\common\logic\Article as LogicArticle;
use app\common\logic\Articlecate as LogicArticlecate;

/**
 * 文章控制器
 */
class Article extends ApiBaseCommon
{

    /**
     * 文章逻辑
     */

    private static $articleLogic = null;
    private static $articlecateLogic = null;
    /**
     * 构造方法
     */
    public function _initialize()
    {

        parent::_initialize();
        self::$articlecateLogic = get_sington_object('articlecateLogic', LogicArticlecate::class);
        self::$articleLogic = get_sington_object('articleLogic', LogicArticle::class);
    }

    /**
     * 文章列表
     */
    public function index()
    {
        $where = self::$articleLogic->getWhere($this->param);
        $limit = isset($this->param['limit']) ? $this->param['limit'] : 0;
        $data = self::$articleLogic->getArticleList(['m.ispublic'=>1,'m.status'=>1], 'm.id,m.title,m.create_time,m.description', 'settop desc,id desc',$limit);
        //遍历对象
        $domain = getDomain();
        if(!empty($data)){
            foreach ($data as $key=>$val){
                $val['thumb'] ? $data[$key]['thumb'] = $domain.WEB_PATH_PICTURE.$val['thumb'] :'';
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
        $data = self::$articleLogic->getArticleInfo(['id' => $this->param['id']],'id,title,create_time,copyfrom,content');
        if (!$data) {
            return resultArray(['error' => self::$articleLogic->getError()]);
        }
        $data['content'] = htmlspecialchars_decode($data['content']);
//        $data['content'] = preg_replace('/src=&quot;\//i','src=&quot;'.getDomain().'/',$data['content']);
        $data['content'] = preg_replace('/src="\//i','src="'.getDomain().'/',$data['content']);
        return resultArray(['data' => $data]);
    }

} 