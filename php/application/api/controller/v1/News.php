<?php
// +----------------------------------------------------------------------
// | Description: 菜单
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------

namespace app\api\controller\v1;

use app\api\controller\ApiCommon;

class News extends ApiCommon
{
    
    public function index()
    {   
        $newsModel = model('News');
        $param = $this->param;
        $data = $newsModel->getDataList(['status'=>1,'ispublic'=>1],'id desc',2);
        return resultArray(['data' => $data]);
    }

    public function read()
    {   
        $newsModel = model('News');
        $param = $this->param;
        $data = $newsModel->getDataById($param['id']);
        if (!$data) {
            return resultArray(['error' => $newsModel->getError()]);
        } 
        return resultArray(['data' => $data]);
    }

    public function save()
    {
        $newsModel = model('News');
        $param = $this->param;
        $data = $newsModel->createData($param);
        if (!$data) {
            return resultArray(['error' => $newsModel->getError()]);
        } 
        return resultArray(['data' => '添加成功']);
    }

    public function update()
    {
        $newsModel = model('News');
        $param = $this->param;
        $data = $newsModel->updateDataById($param, $param['id']);
        if (!$data) {
            return resultArray(['error' => $newsModel->getError()]);
        } 
        return resultArray(['data' => '编辑成功']);
    }

    public function delete()
    {
        $newsModel = model('News');
        $param = $this->param;
        $data = $newsModel->delDataById($param['id'], true);       
        if (!$data) {
            return resultArray(['error' => $newsModel->getError()]);
        } 
        return resultArray(['data' => '删除成功']);    
    }

    public function deletes()
    {
        $newsModel = model('News');
        $param = $this->param;
        $data = $newsModel->delDatas($param['ids'], true);  
        if (!$data) {
            return resultArray(['error' => $newsModel->getError()]);
        } 
        return resultArray(['data' => '删除成功']); 
    }

    public function enables()
    {
        $newsModel = model('News');
        $param = $this->param;
        $data = $newsModel->enableDatas($param['ids'], $param['status'], true);  
        if (!$data) {
            return resultArray(['error' => $newsModel->getError()]);
        } 
        return resultArray(['data' => '操作成功']);         
    }
}
 