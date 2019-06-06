<?php

namespace app\common\logic;

/**
 * 记录订单
 */
class MoneyLog extends LogicBase
{

    //记录订单模型
    public static $moneyLogModel = null;

    /**
     * 构造方法
     */
    public function __construct()
    {

        parent::__construct();

        self::$moneyLogModel = model($this->name);
    }


    /**
     * 支付成功，生成支付记录
     */
    public function wexpayToMoneyLog($orderInfo){
        $data['openid'] = $orderInfo['openid'];
        $data['order_sn'] = $orderInfo['out_trade_no'];
        $data['price'] = $orderInfo['total_fee']/100;
        $data['log_type'] = 0;
        $data['creat_time'] = TIME_NOW;
        $data['remarks'] = '微信支付';
        $data['order_info'] = serialize($orderInfo);

        if(self::$moneyLogModel->setInfo($data)){
            return ['code' => 1, 'msg' => '操作成功'];
        }else{
            return ['code' => 0, 'msg' => '操作失败'];
        }

    }


}
