<?php
namespace app\payment\controller;

use app\common\controller\ControllerBase;
use app\common\logic\Pay as LogicPay;
use app\common\logic\MoneyLog as LogicMoneyLog;
use think\Exception;
use think\Log;

class Weixinpay extends ControllerBase
{
    private static $logicPay = null;
    private static $logicMoneyLog = null;

    protected function _initialize()
    {
        parent::_initialize();
        self::$logicPay = get_sington_object('logicPay', LogicPay::class);
        self::$logicMoneyLog = get_sington_object('logicMoneyLog', LogicMoneyLog::class);
    }

    public function notify()
    {
//        Log::record('微信支付回调页面','info');
        //微信支付回调验证

//            $xml = $GLOBALS['HTTP_RAW_POST_DATA'];//php7不支持
        $xml = file_get_contents('php://input');
        // 这句file_put_contents是用来查看服务器返回的XML数据 测试完可以删除了
        file_put_contents(ROOT_PATH . 'api/wxpay/logs/log.txt', "\r\n[微信支付服务器返回数据]：".$xml, FILE_APPEND);
        //将服务器返回的XML数据转化为数组
        //$data = json_decode(json_encode(simplexml_load_string($xml,'SimpleXMLElement',LIBXML_NOCDATA)),true);
        $data = $this->xmlToArray($xml);
        Log::record('返回数据：' . json_encode($data), 'info');
        // 保存微信服务器返回的签名sign
//            $data_sign = $data['sign'];
        // sign不参与签名算法
        unset($data['sign']);
        // 判断签名是否正确 判断支付状态
        if (($data['return_code'] == 'SUCCESS') && ($data['result_code'] == 'SUCCESS')) {
            $result = $data;
            //获取服务器返回的数据
            $order_sn = $data['out_trade_no']; //订单单号
            $order_id = $data['attach'];  //附加参数,选择传递订单ID
            $openid = $data['openid'];   //付款人openID
            $total_fee = $data['total_fee'] / 100; //付款金额
            self::$logicMoneyLog->wexpayToMoneyLog($data);
            //更新数据库
            self::$logicPay->updateOrderStatus($order_id, $order_sn, $openid, $total_fee);
        } else {
            $result = false;
        }
        // 返回状态给微信服务器
        if ($result) {
            $str = '<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';
        } else {
            $str = '<xml><return_code><![CDATA[FAIL]]></return_code><return_msg><![CDATA[签名失败]]></return_msg></xml>';
        }
        echo $str;
        return json($result);
    }

    /**
     * 将xml转为array
     * @param string $xml
     * @throws WxPayException
     */
    protected function xmlToArray($xml)
    {
        if (!$xml) {
            Log::record("xml数据异常！");
            return false;
        }
        //将XML转为array
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);

        return json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    }


}

?>