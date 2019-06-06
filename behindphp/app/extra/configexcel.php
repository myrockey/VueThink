<?php
//微信公众号appid
return [

    'member' => [
        '昵称,性别,地址,注册时间,到期时间,上级,会员等级,上次登录时间',
        'nickname,sex,userhome,regtime,vip_expire_time,leader_id,grades,last_login_time'
    ],
    'shares' => [
        '发布时间,市场连板指数,市场超跌指数,操作建议,周期,L2,L1,关注股,荐股胜率',
        'title,market_connectivity_index,market_overfall_index,operation_suggestion,cycle_shares,grade2_shares,grade1_shares,follow_shares,share_winning_rate'
    ],
    'question' => [
        '反馈人,内容,反馈时间',
        'uid,content,create_time'
    ],
    'pay' => [
        '订单号,用户昵称,vip类型,充值付费(元),创建时间,状态,备注',
        'order_sn,username,member_goodsid,money,creat_time,status,remarks'
    ],
    'article' => [
        '标题,所属分类,来源,来源链接,时间,置顶,状态',
        'title,tid,copyfrom,copyfromlink,create_time,settop,ispublic'
    ],

];