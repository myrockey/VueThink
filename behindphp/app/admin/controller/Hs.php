<?php

namespace app\admin\controller;
use app\common\logic\Document as LogicDocument;
use app\common\logic\Coor as LogicCoor;
use think\log;
/**
 * 河山官网控制器
 */
class Hs extends AdminBase
{
    
    /**
     * 文章逻辑
     */
    private static $documentLogic = null;
    private static $coorLogic = null;
    /**
     * 构造方法
     */
    public function _initialize()
    {
        
        parent::_initialize();
        self::$documentLogic = get_sington_object('documentLogic', LogicDocument::class);
        self::$coorLogic = get_sington_object('coorLogic', LogicCoor::class);
    }

    
    /**
     * 合作伙伴列表
     */
    public function coorList()
    {
        $where = self::$commonLogic->getWhere($this->param);

        $this->assign('list', self::$commonLogic->getDataList('coor',$where, true, 'id desc'));


        return $this->fetch('coor_list');
    }

    /**
     * 批量删除
     */
    public function coorAlldel($ids = 0)
    {

        $this->jump(self::$coorLogic->coorAlldel($ids));
    }

    /**
     * 删除
     */
    public function coorDel($id = 0)
    {

        $this->jump(self::$coorLogic->coorDel(['id' => $id]));
    }

    /**
     * 资料列表
     */
    public function documentList()
    {
        $where = self::$documentLogic->getWhere($this->param);
        $where['tid'] = 1;

        $this->assign('list',self::$documentLogic->getDocumentList($where, 'm.*', 'id desc'));

        $this->assign('tid',$where['tid']);
        return $this->fetch('document_list');
    }

    /**
     * 软件列表
     */
    public function downloadList()
    {
        $where = self::$documentLogic->getWhere($this->param);
        $where['tid'] = 2;

        $this->assign('list',self::$documentLogic->getDocumentList($where, 'm.*', 'id desc'));

        $this->assign('tid',$where['tid']);
        return $this->fetch('document_list');
    }

    public function documentAdd()
    {
        IS_POST && $this->jump(self::$documentLogic->documentAdd($this->param));

        $this->assign('tid',$this->param['tid']);
        return $this->fetch('document_add');
    }

    public function documentEdit()
    {
    	$info = self::$documentLogic->getDocumentInfo(['id' => $this->param['id']]);

    	IS_POST && $this->jump(self::$documentLogic->documentEdit($this->param));

        $this->assign('tid',$this->param['tid']);
    	$this->assign('info', $info);
    	return $this->fetch('document_edit');
    }

    /**
     * 文件批量删除
     */
    public function documentAlldel($ids = 0,$tid)
    {
    
    	$this->jump(self::$documentLogic->documentAlldel($ids,$this->param['tid']));
    }

    /**
     * 文件删除
     */
    public function documentDel($id = 0)
    {
        
        $this->jump(self::$documentLogic->documentDel(['id' => $id,'tid'=>$this->param['tid']]));
    }
    /**
     * 文件状态更新
     */
    public function sharesCstatus($id = 0,$status,$field)
    {
        
        $this->jump(self::$sharesLogic->setArticleValue(['id' => $id],$field,$status));
    }

}
