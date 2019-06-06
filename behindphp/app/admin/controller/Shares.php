<?php

namespace app\admin\controller;

use app\common\logic\Shares as LogicShares;
use app\common\logic\File as LogicFile;
use app\common\logic\Pay as LogicPay;
use think\log;
/**
 * 周期精灵控制器
 */
class Shares extends AdminBase
{
    
    /**
     * 文章逻辑
     */
	
    private static $sharesLogic = null;
    private static $payLogic = null;

    /**
     * 构造方法
     */
    public function _initialize()
    {
        
        parent::_initialize();
        self::$sharesLogic = get_sington_object('SharesLogic', LogicShares::class);
        self::$payLogic = get_sington_object('PayLogic', LogicPay::class);
    }

    
    /**
     * 股票列表
     */
    public function sharesList()
    {
        
        $where = self::$sharesLogic->getWhere($this->param);
        $this->assign('list', self::$sharesLogic->getSharesList($where, true, 'id desc'));
       
       
        return $this->fetch('shares_list');
    }

    /**
     * 问题反馈列表
     */
    public function questionList()
    {

        $where = self::$commonLogic->getWhere($this->param);

        $this->assign('list', self::$commonLogic->getDataList('question',$where, true, 'id desc'));


        return $this->fetch('question_list');
    }

    /**
     * 订单列表
     */
    public function orderList()
    {

        $where = self::$payLogic->getWhere($this->param);

        $this->assign('list', self::$payLogic->getPayList($where, true, 'id desc'));


        return $this->fetch('order_list');
    }
    
    /**
     * 股票添加
     */
    public function sharesAdd()
    {
        IS_POST && $this->jump(self::$sharesLogic->sharesAdd($this->param));
        return $this->fetch('shares_add');
    }
    /**
     * 股票编辑
     */
    public function sharesEdit()
    {
    	$info = self::$sharesLogic->getSharesInfo(['id' => $this->param['id']]);
    	IS_POST && $this->jump(self::$sharesLogic->sharesEdit($this->param,$info));
    	$this->assign('info', $info);
    	return $this->fetch('shares_edit');
    }
    
    /**
     * 导入excel
     * */
    public function insertExcel()
    {
        if(!IS_POST){
            return json(['code'=>0,'msg'=>'非法错误']);
        }
        set_time_limit(0);
        vendor('phpoffice/phpexcel/Classes/PHPExcel');

        $FileLogic = get_sington_object('fileLogic', LogicFile::class);

        $result = $FileLogic->fileUpload();
        if (isset($result['code']) && $result['code'] == 0) {
            return json($result);
        }
        $file_name = ROOT_PATH . ltrim($result['headpath'],DS);//上传文件的地址
        $objReader = \PHPExcel_IOFactory::createReader('Excel2007');

        $obj_PHPExcel = $objReader->load($file_name, $encode = 'utf-8');  //加载文件内容,编码utf-8

        $excel_array=$obj_PHPExcel->getsheet(0)->toArray();   //转换为数组格式
        if(count($excel_array[0]) != 10){
            return json(['code'=>0,'msg'=>'数据格式错误']);
        }
        array_shift($excel_array);  //删除第一个数组(标题);
        $sharesArr = array();
        $sharesArr['cycle_shares'] = '';
        $sharesArr['grade2_shares'] = '';
        $sharesArr['grade1_shares'] = '';
        $sharesArr['follow_shares'] = '';
        foreach($excel_array as $k=>$v) {
            $shares_value = $v[1].'|'.$v[2].'|'.$v[3].'|'.$v[4].';';
            switch ($v[0])
            {
                case '周期':
                    $sharesArr['cycle_shares'] .= $shares_value;
                break;
                case 'L2':
                    $sharesArr['grade2_shares'] .= $shares_value;
                break;
                case 'L1':
                    $sharesArr['grade1_shares'] .= $shares_value;
                break;
                case '关注股':
                    $sharesArr['follow_shares'] .= $shares_value;
                break;
                default:
                    return json(['code'=>0,'msg'=>'数据格式错误']);
            }

        }
        $sharesArr['title'] = $excel_array[0][5] ? $excel_array[0][5] : '';
        $sharesArr['market_connectivity_index'] = $excel_array[0][6];
        $sharesArr['market_overfall_index'] = $excel_array[0][7];
        $sharesArr['operation_suggestion'] = $excel_array[0][8];
        $sharesArr['share_winning_rate'] = $excel_array[0][9];
        $sharesArr['code'] = 1;
        $resultArr = empty($result) ? array() : (!is_array($result) ? $result->toArray() : $result);

        return json(array_merge($resultArr,$sharesArr));
    }
    /**
     * 股票批量删除
     */
    public function sharesAlldel($ids = 0)
    {
    
    	$this->jump(self::$sharesLogic->articleAlldel($ids));
    }
    /**
     * 股票删除
     */
    public function sharesDel($id = 0)
    {
        
        $this->jump(self::$sharesLogic->articleDel(['id' => $id]));
    }
    /**
     * 股票状态更新
     */
    public function sharesCstatus($id = 0,$status,$field)
    {
        
        $this->jump(self::$sharesLogic->setArticleValue(['id' => $id],$field,$status));
    }

}
