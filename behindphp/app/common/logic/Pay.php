<?php

namespace app\common\logic;

/**
 * 支付处理逻辑
 */
class Pay extends LogicBase
{

    // 会员模型
    public static $payModel = null;
    public static $memberModel = null;
    public static $memberGoodsModel = null;

    /**
     * 构造方法
     */
    public function __construct()
    {

        parent::__construct();

        self::$payModel = model($this->name);
        self::$memberModel = model('member');
        self::$memberGoodsModel = model('member_goods');
    }
    
    /**
     * 获取单条信息
     */
    public function getPayInfo($where = [], $field = true)
    {

        return self::$payModel->getInfo($where, $field);
    }

    /**
     * 获取列表搜索条件
     */
    public function getWhere($data = [])
    {

        $where = [];

        !empty($data['search_data']) && $where['order_sn|userid|username'] = ['like', '%'.$data['search_data'].'%'];

        if (!is_administrator()) {


        }

        return $where;
    }

    /**
     * 获取订单列表
     */
    public function getPayList($where = [], $field = true, $order = '', $paginate = 0)
    {
        return self::$payModel->getList($where, $field, $order, $paginate);
    }
    
    /**
     * 微信支付，修改支付订单并修改VIP会员状态
     */
    public function updateOrderStatus($order_id,$order_sn,$openid,$total_fee){
        $memberInfo = self::$memberModel->getInfo(['status' => 1, 'openid' => $openid]);
        //如果已经有该订单
        if(self::$payModel->getInfo(['order_sn' => $order_sn])){
            return json(['code' => 1, 'msg' => '操作成功']);
        }
        //记录生成订单
        $data['order_sn'] = $order_sn;
        $data['member_goodsid'] = $order_id;
        $data['userid'] = $memberInfo['id'];
        $data['username'] = $memberInfo['nickname'];
        $data['money'] = $total_fee;
        $data['creat_time'] = TIME_NOW;
        $data['ip'] = CLIENT_IP;
        $data['msg'] = '支付成功';
        $data['status'] = 1;
        $data['remarks'] = '购买会员';

        if(self::$payModel->setInfo($data)){
            $goods = self::$memberGoodsModel->getInfo(['id'=>$order_id],true);
            //修改会员，VIP状态,到期时间
            $mdata['id'] = $memberInfo['id'];
            $mdata['is_vip'] = 1;
            $mdata['grades'] = ($order_id == 1) ? 2 : 3;
            $start_time = ($memberInfo['vip_expire_time'] > time()) ? $memberInfo['vip_expire_time'] : time();
            if($goods['id'] == 1){
                $mdata['vip_expire_time'] = strtotime("+".intval($goods['month_time'])." week",$start_time);
            }else{
                $mdata['vip_expire_time'] = strtotime("+".intval($goods['month_time'])." month",$start_time);
            }

            if(self::$memberModel->setInfo($mdata)){
                //由于这是异步操作，所以session在此不起作用
             /*   $member = self::$memberModel->getInfo(['id'=>$mdata['id']],true);
                $auth = ['member_id' => $member['id'], 'last_login_time' => TIME_NOW];
                session('member_info', $member);
                session('member_auth', $auth);
                session('member_auth_sign', data_auth_sign($auth));*/
                return json(['code' => 1, 'msg' => '操作成功']);
            }else{
                return json(['code' => 0, 'msg' => '操作失败']);
            }

        }else{
            return json(['code' => 0, 'msg' => '操作失败']);
        }

    }

}
