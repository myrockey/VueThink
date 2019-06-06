<?php

namespace app\common\logic;

/**
 * 文件逻辑
 */
class Document extends LogicBase
{

    // 文件模型
    public static $documentModel = null;

    /**
     * 构造方法
     */
    public function __construct()
    {

        parent::__construct();

        self::$documentModel = model($this->name);
    }

    /**
     * 获取列表搜索条件
     */
    public function getWhere($data = [])
    {

        $where = [];

        !empty($data['search_data']) && $where['name'] = ['like', '%' . $data['search_data'] . '%'];

        if (!is_administrator()) {


        }

        return $where;
    }

    /**
     * 获取文件列表
     */
    public function getDocumentList($where = [], $field = 'm.*', $order = '', $paginate = 0)
    {

        return self::$documentModel->getList($where, $field.',documentcate.name as tidname,file.savepath as path', $order, $paginate, [['documentcate', 'm.tid=documentcate.id', 'LEFT'],['file', 'm.attatchment_id=file.id', 'LEFT']]);
        // return self::$documentModel->getList($where, $field, $order, $paginate);
    }

    /**
     * 获取文件信息
     */
    public function getDocumentInfo($where = [], $field = true)
    {

        return self::$documentModel->getInfo($where, $field);
    }


    /**
     * 文件添加
     */
    public function documentAdd($data = [])
    {

        $validate = validate($this->name);

        $validate_result = $validate->scene('add')->check($data);

        if (!$validate_result) : return [RESULT_ERROR, $validate->getError()]; endif;

        $url = url('configList');


        return self::$documentModel->setInfo($data) ? [RESULT_SUCCESS, '添加成功', $url] : [RESULT_ERROR, self::$documentModel->getError()];
    }

    /**
     * 文件编辑
     */
    public function documentEdit($data = [])
    {
        $validate = validate($this->name);

        $validate_result = $validate->scene('edit')->check($data);

        if (!$validate_result) : return [RESULT_ERROR, $validate->getError()]; endif;

        $url = url('configList');


        return self::$documentModel->setInfo($data) ? [RESULT_SUCCESS, '编辑成功', $url] : [RESULT_ERROR, self::$documentModel->getError()];
    }

    /**
     * 设置文件信息
     */
    public function setDocumentValue($where = [], $field = '', $value = '')
    {

        return self::$documentModel->setFieldValue($where, $field, $value) ? [RESULT_SUCCESS, '状态更新成功'] : [RESULT_ERROR, self::$documentModel->getError()];
    }

    /**
     * 文件删除
     */
    public function documentDel($where = [])
    {

        return self::$documentModel->deleteInfo($where, true) ? [RESULT_SUCCESS, '删除成功'] : [RESULT_ERROR, self::$documentModel->getError()];
    }

    /**
     * 批量删除
     */
    public function documentAlldel($ids,$tid)
    {

        $url = url('configList');
        return self::$documentModel->deleteAllInfo(['id' => array('in', $ids),'tid'=>$tid], true) ? [RESULT_SUCCESS, '删除成功',$url] : [RESULT_ERROR, self::$documentModel->getError()];
    }


}
