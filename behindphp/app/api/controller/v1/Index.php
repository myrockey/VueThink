<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/6/3
 * Time: 11:47
 */

namespace app\api\controller\v1;


use app\api\controller\ApiBaseCommon;
use think\Controller;

class Index extends ApiBaseCommon
{

    /**
     * 首页新闻
     * @return mixed
     */
    public function articleLists(){

        $data = model('Article')->where(['status'=>1,'ispublic'=>1])->field('id,title')->order('settop desc,id desc')->limit(2)->select();
        return resultArray(['data' => $data]);
    }
    
}