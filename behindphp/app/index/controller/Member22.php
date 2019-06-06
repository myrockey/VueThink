<?php
namespace app\index\controller;

use app\common\controller\HomeBase;

use app\common\logic\Member as LogicMember;
use qqconnect\URL;


class Member extends HomeBase
{

    // 用户逻辑
    private static $logicMember = null;


    public function _initialize()
    {
        parent::_initialize();

        self::$logicMember = get_sington_object('logicMember', LogicMember::class);

        $this->uid = is_login();
        $this->assign('nowuid', $this->uid);
        if ($this->uid > 0) {
            $nowuserinfo = parent::$commonLogic->getDataInfo('member', ['id' => $this->uid]);
            $this->assign('nowuserinfo', $nowuserinfo);
        }

    }

    public function index()
    {
        !is_login() && $this->jump(RESULT_REDIRECT, 'index/index');
        return $this->fetch();
    }

    /**
     * 弹出输入框，输入推荐码
     * @return mixed
     */
    public function toinputrecommendcode()
    {
        if (IS_POST) {

            $recommendCode = request()->param('recommendCode', "");
            $mInfo = self::$logicMember->checkReommendCodeExists($recommendCode);
            if ($mInfo) {
                session('recommendCodeId', $mInfo['id']);
                exit(json_encode(['code' => 1, 'msg' => '操作成功']));
            } else {
                exit(json_encode(['code' => 0, 'msg' => '无效推荐码']));
            }
        }
        $this->assign('func', "inputRecommendCode()");
        return $this->fetch();
    }

    /**
     * 优先存储，输入推荐码
     * @return mixed
     */
    public function tosavecode()
    {
        $recommendCode = request()->param('recommendCode', "");
        if (IS_GET && $recommendCode) {
            $mInfo = self::$logicMember->checkReommendCodeExists($recommendCode);
            if ($mInfo) {
                session('recommendCodeId', $mInfo['id']);
                $this->jump(RESULT_REDIRECT, 'member/tologinandpay');
            } else {
                exit( '无效推荐码');
            }
            $this->jump(RESULT_REDIRECT, 'member/tologinandpay');
        }
        if (IS_POST && $recommendCode) {
            $mInfo = self::$logicMember->checkReommendCodeExists($recommendCode);
            if ($mInfo) {
                session('recommendCodeId', $mInfo['id']);
                exit(json_encode(['code' => 1, 'msg' => '操作成功']));
            } else {
                exit(json_encode(['code' => 0, 'msg' => '无效推荐码']));
            }
        }
        $this->assign('func', "inputRecommendCode()");
        return $this->fetch('toinputrecommendcode');
    }

    /**
     *
     * 执行微信授权注册会员并登录，然后支付操作
     */
    public function tologinandpay()
    {

        $callbackUrl = url('member/callback', '', true, true);
        $wchat = new \wechatlogin\wechatOauth();
        $url = $wchat->getSingleAuthorizeUrl($callbackUrl, "123");
        Header("Location: $url");
        exit();

    }
    public function tologinandpayxx()
    {
        //如果已经是会员,直接到首页
        if ($this->uid) {
            $memberInfo = self::$logicMember->getMemberInfo(['status' => 1, 'id' => $this->uid]);
            if ($memberInfo) {
                $this->jump(self::$logicMember->loginAuto($memberInfo));
            } else {
                $this->jump(self::$logicMember->tologout());
            }

        } else {
            //不是会员，则先判断是否有推荐码
            if(!session('recommendCodeId')) {
                $recommendCode = request()->param('recommendCode', "");
                $mInfo = self::$logicMember->checkReommendCodeExists($recommendCode);
                if (!$mInfo) $this->jump(RESULT_REDIRECT, 'member/toinputrecommendcode');
            }

            $callbackUrl = url('member/callback', '', true, true);
            $wchat = new \wechatlogin\wechatOauth();
            $url = $wchat->getSingleAuthorizeUrl($callbackUrl, "123");
            Header("Location: $url");
            exit();
        }
    }

    /**
     * 回调页
     */
    public function callback()
    {
        $code = request()->param('code', "");

        $wchat = new \wechatlogin\wechatOauth();
        $access_token = $wchat->getSingleAccessToken($code);
        if ($access_token != null && $access_token['access_token']) {
            $user_data = $wchat->getUserInfo($access_token);
            if ($user_data != null && $user_data['openid']) {
                //数据库有该用户openid，用户已绑定微信，则帮助登录
                $memberInfo = self::$logicMember->getMemberInfo(['status' => 1, 'openid' => $user_data['openid']]);
                if ($memberInfo) {
                    $this->jump(self::$logicMember->loginAuto($memberInfo));
                } else {
                    //数据库有没有该用户，则注册会员需要推荐码然后绑定微信openid，并帮助登录
                    //不是会员，则先判断是否有推荐码
                    if(!session('recommendCodeId')) {
                        $recommendCode = request()->param('recommendCode', "");
                        $mInfo = self::$logicMember->checkReommendCodeExists($recommendCode);
                        if (!$mInfo) $this->jump(RESULT_REDIRECT, 'member/tosavecode');
                    }
                    $user_data['pid'] = session('recommendCodeId');
                    $res = self::$logicMember->regWechatHandle($user_data);
                    if ($res[0] == RESULT_SUCCESS) {
                        $memberInfo = self::$logicMember->getMemberInfo(['status' => 1, 'openid' => $user_data['openid']]);
                        $this->jump(self::$logicMember->loginAuto($memberInfo));
                    } else {
                        $this->jump(([RESULT_ERROR, '注册失败', url('index/member')]));
                        exit('注册失败');
                    }
                }
            } else {
                $this->jump(([RESULT_ERROR, '获取用户信息失败', url('index/member')]));
                exit('获取用户信息失败');
            }
        } else {
            $this->jump(([RESULT_ERROR, '微信授权失败', url('index/member')]));
            exit('微信授权失败');
        }
    }
    public function callbackxx()
    {
        $code = request()->param('code', "");

        $wchat = new \wechatlogin\wechatOauth();
        $access_token = $wchat->getSingleAccessToken($code);
        if ($access_token != null && $access_token['access_token']) {
            $user_data = $wchat->getUserInfo($access_token);
            if ($user_data != null && $user_data['openid']) {
                //数据库有该用户openid，用户已绑定微信，则帮助登录
                $memberInfo = self::$logicMember->getMemberInfo(['status' => 1, 'openid' => $user_data['openid']]);
                if ($memberInfo) {
                    $this->jump(self::$logicMember->loginAuto($memberInfo));
                } else {
                    //数据库有没有该用户，则注册会员绑定微信openid，并帮助登录
                    $user_data['pid'] = session('recommendCodeId');
                    $res = self::$logicMember->regWechatHandle($user_data);
                    if ($res[0] == RESULT_SUCCESS) {
                        $memberInfo = self::$logicMember->getMemberInfo(['status' => 1, 'openid' => $user_data['openid']]);
                        $this->jump(self::$logicMember->loginAuto($memberInfo));
                    } else {
                        $this->jump(([RESULT_ERROR, '注册失败', url('index/member')]));
                        exit('注册失败');
                    }
                }
            } else {
                $this->jump(([RESULT_ERROR, '获取用户信息失败', url('index/member')]));
                exit('获取用户信息失败');
            }
        } else {
            $this->jump(([RESULT_ERROR, '微信授权失败', url('index/member')]));
            exit('微信授权失败');
        }
    }

    /**
     * 开通会员
     * @return mixed
     */
    public function tovip()
    {

        return $this->fetch();
    }

    /**
     * 推荐码
     * @return mixed
     */
    public function recommend()
    {
        if (!$this->uid) {
            $RecommendCode = request()->param('RecommendCode', "");
            if (!$RecommendCode) $this->error('亲！请登录', url('member/tovip'));
            $recommendCode = deRecommendCode($RecommendCode);
        } else {
            $recommendCode = createRecommendCode($this->uid);
        }
        $url = url('member/tosavecode', ['recommendCode' => $recommendCode], true, true);
        $result = createQrcode($url, 'Qrcode', '', 10);
        if (empty($result) || $result['errcode'] != 0) {
            echo "<script>alert('二维码失效，重新生成二维码！');document.reload();</script>";
        }
        $info['qrcode'] = '/public/' . $result['data'];
        $info['recommendCode'] = $recommendCode;

        $this->assign('info', $info);
        return $this->fetch();
    }

    public function continuetopay()
    {
        echo '待完成';
    }


    public function focususer()
    {


        $uid = is_login();
        if ($uid == 0) {
            $this->jump(([RESULT_ERROR, '请登录后操作']));
        } else {

            $where['type'] = 0;
            $where['uid'] = $uid;
            $where['sid'] = $this->param['useruid'];

            if (model('zan')->where($where)->count() > 0) {
                $this->jump(parent::$commonLogic->dataDel('zan', ['type' => 0, 'sid' => $this->param['useruid'], 'uid' => $uid], '取消关注', true));

            } else {
                $data['type'] = 0;
                $data['sid'] = $this->param['useruid'];
                $data['uid'] = $uid;
                $this->jump(parent::$commonLogic->dataAdd('zan', $data, false, '关注成功'));
            }


        }


    }

    public function userfocus()
    {
        !is_login() && $this->jump(RESULT_REDIRECT, 'Index/index');
        $uid = is_login();
        empty($this->param['type']) ? $type = 1 : $type = $this->param['type'];

        $sidarr = model('zan')->where(['uid' => $uid, 'type' => 0])->column('sid');//得到所有的我关注的人
        $gzidarr = model('zan')->where(['sid' => $uid, 'type' => 0])->column('uid');//得到所有关注我的人

        if ($type == 1) {//好友

            $userlist = parent::$commonLogic->getDataList('zan', ['m.uid' => array('in', $sidarr), 'm.sid' => $uid, 'm.type' => 0], 'm.uid,m.sid,m.create_time,user.nickname,user.id as userid,user.userhead,user.description,user.statusdes,user.grades,count(topic.id) as topiccount', 'm.create_time desc', 8, [['user', 'user.id=m.uid'], ['topic', 'topic.uid=m.uid', 'LEFT']], 'topic.uid');

        }
        if ($type == 2) {//关注

            $userlist = parent::$commonLogic->getDataList('zan', ['m.uid' => $uid, 'm.type' => 0, 'm.sid' => array('not in', $gzidarr)], 'm.uid,m.sid,m.create_time,user.nickname,user.id as userid,user.userhead,user.description,user.statusdes,user.grades,count(topic.id) as topiccount', 'm.create_time desc', 8, [['user', 'user.id=m.sid'], ['topic', 'topic.uid=m.sid', 'LEFT']], 'topic.uid');

        }
        if ($type == 3) {//粉丝
            $userlist = parent::$commonLogic->getDataList('zan', ['m.sid' => $uid, 'm.type' => 0, 'm.uid' => array('not in', $sidarr)], 'm.uid,m.sid,m.create_time,user.nickname,user.id as userid,user.userhead,user.description,user.statusdes,user.grades,count(topic.id) as topiccount', 'm.create_time desc', 8, [['user', 'user.id=m.uid'], ['topic', 'topic.uid=m.uid', 'LEFT']], 'topic.uid');

        }
        $this->assign('uid', $uid);
        $this->assign('type', $type);
        $this->assign('userlist', $userlist);

        return $this->fetch();
    }

    public function home()
    {


        if (empty($this->param['id'])) {
            $this->error('参数错误', url('index/index'));
        } else {
            $useruid = $this->param['id'];

            //参加的小组
            $joingrouplist = parent::$commonLogic->getDataList('user_group', ['m.uid' => $useruid], 'm.group_id,group.name,m.create_time,group.cover_id', 'm.create_time desc', false, [['group', 'group.id=m.group_id', 'LEFT']]);
            $this->assign('joingrouplist', $joingrouplist);

            //发表的帖子

            $list = parent::$commonLogic->getDataList('topic', ['m.status' => 1, 'm.uid' => $useruid], 'm.*,user.nickname,user.userhead', 'm.create_time desc', 0, [['user', 'user.id=m.uid', 'LEFT']]);
            foreach ($list as $k => $v) {

                $comment = model('comment')->where(['fid' => $v['id']])->order('create_time desc')->limit(1)->select();
                if ($comment) {
                    $list[$k]['ccreate_time'] = $comment[0]['create_time'];
                    $list[$k]['cuid'] = $comment[0]['uid'];
                }

            }

            $this->assign('list', $list);


            $uid = is_login();
            usercz($uid, $useruid, 2, 3);

            $newvisitorlist = parent::$commonLogic->getDataList('usercz', ['m.did' => $useruid, 'm.type' => 2, 'm.cid' => 3], 'm.uid,user.nickname,user.userhead', 'm.create_time desc', false, [['user', 'user.id=m.uid', 'LEFT']], 'm.uid', 9);
            $this->assign('newvisitorlist', $newvisitorlist);

            $userinfo = parent::$commonLogic->getDataInfo('user', ['id' => $useruid]);


            $userinfo['topiccount'] = model('topic')->where(['uid' => $useruid])->count();

            $userinfo['gzusercount'] = model('zan')->where(['type' => 0, 'sid' => $useruid])->count();

            $userinfo['fsusercount'] = model('zan')->where(['uid' => $useruid, 'type' => 0])->count();

            $userinfo['groupcount'] = model('user_group')->where(['uid' => $useruid])->count();


            $this->assign('userinfo', $userinfo);

            $this->assign('useruid', $useruid);


            if ($uid == $useruid) {
                $hasfocus = 2;
            } else {
                if (model('zan')->where(['uid' => $uid, 'sid' => $useruid, 'type' => 0])->count() > 0) {
                    $hasfocus = 1;
                } else {
                    $hasfocus = 0;
                }
            }
            $this->assign('hasfocus', $hasfocus);
        }


        return $this->fetch();

    }

    public function index222()
    {
        !is_login() && $this->jump(RESULT_REDIRECT, 'Index/index');


        return $this->fetch();

    }

    /**
     * 修改个人头像处理
     */
    public function setavatarHandle()
    {

        $info = session('member_info');
        $data = $this->param;
        $data['id'] = $info['id'];

        $obj = new User();
        $this->jump(parent::$commonLogic->dataEdit('user', $data, false, $info = '信息编辑成功', $obj, 'callback_setinfo'));
    }

    /**
     * 修改个人信息处理
     */
    public function setinfoHandle()
    {


        $info = session('member_info');

        $data = $this->param;
        $data['username'] = $info['username'];
        $data['id'] = $info['id'];

        $obj = new User();

        $this->jump(parent::$commonLogic->dataEdit('user', $data, true, $info = '信息编辑成功', $obj, 'callback_setinfo'));

    }

    public function callback_setinfo($result, $data)
    {
        $member = parent::$commonLogic->getDataInfo('user', ['id' => $data['id']]);
        session('member_info', $member);

    }

    /**
     * 修改密码处理
     */
    public function setpasswordHandle()
    {
        $data = $this->param;
        $info = session('member_info');
        $this->jump(self::$logicMember->setMemberPassword($data, $info));

    }

    public function mess()
    {
        !is_login() && $this->jump(RESULT_REDIRECT, 'Index/index');
        $uid = is_login();
        $midarr = model('readmessage')->where(['uid' => $uid])->column('mid');
        $list = parent::$commonLogic->getDataList('message', ['id' => array('not in', $midarr), 'touid' => array('in', array(0, $uid)), 'status' => 1], true, 'update_time desc');

        $this->assign('list', $list);
        return $this->fetch();

    }

    public function ajaxdelmess()
    {
        $myuid = is_login();
        $id = $this->param['id'];
        $uid = $this->param['uid'];
        if ($uid > 0) {

            $where['id'] = $id;

            $this->jump(parent::$commonLogic->dataDel('message', $where, '删除成功', true));
        } else {
            $data['uid'] = $myuid;
            $data['mid'] = $id;
            $this->jump(parent::$commonLogic->dataAdd('readmessage', $data, false, '删除成功'));
        }

    }

    public function ajaxdelallmess()
    {
        $uid = is_login();
        $midarr = model('readmessage')->where(['uid' => $uid])->column('mid');
        parent::$commonLogic->dataDel('message', ['id' => array('not in', $midarr), 'touid' => $uid], '', true);//删除私信

        $list = parent::$commonLogic->getDataList('message', ['id' => array('not in', $midarr), 'touid' => 0], true, 'update_time desc', false);
        foreach ($list as $k => $v) {
            $data['uid'] = $uid;
            $data['mid'] = $v['id'];
            $n = parent::$commonLogic->dataInsert('readmessage', $data, false, '删除成功');


        }

        $this->jump([RESULT_SUCCESS, '清空成功']);

    }


    public function shoucang()
    {
        !is_login() && $this->jump(RESULT_REDIRECT, 'Index/index');
        $uid = is_login();

        empty($this->param['type']) ? $type = 1 : $type = $this->param['type'];//1表示帖子
        if ($type == 1) {
            $topiclist = parent::$commonLogic->getDataList('zan', ['m.uid' => $uid, 'm.type' => 3], 'm.*,topic.title,topic.choice,topic.settop,topic.reply,topic.view,topic.create_time as topiccreate_time,user.nickname,user.userhead,group.name', 'm.create_time desc', 8, [['topic', 'topic.id=m.sid'], ['group', 'group.id=topic.tid'], ['user', 'user.id=topic.uid']]);

        } else {


        }
        $this->assign('type', $type);
        $this->assign('topiclist', $topiclist);

        return $this->fetch();

    }

    public function mygroup()
    {
        !is_login() && $this->jump(RESULT_REDIRECT, 'Index/index');
        $uid = is_login();

        empty($this->param['type']) ? $type = 1 : $type = $this->param['type'];//1表示建立的2表示关注的
        if ($type == 1) {
            $grouplist = parent::$commonLogic->getDataList('user_group', ['m.uid' => $uid, 'm.grade' => 2], 'm.*,group.cover_id,group.membercount,group.topiccount,group.name', 'm.create_time desc', 8, [['group', 'group.id=m.group_id']]);

        } else {

            $grouplist = parent::$commonLogic->getDataList('user_group', ['m.uid' => $uid, 'm.grade' => array('neq', 2)], 'm.*,group.cover_id,group.membercount,group.topiccount,group.name', 'm.create_time desc', 8, [['group', 'group.id=m.group_id']]);

        }
        $this->assign('type', $type);
        $this->assign('grouplist', $grouplist);

        return $this->fetch();

    }

    public function mytopic()
    {
        !is_login() && $this->jump(RESULT_REDIRECT, 'Index/index');
        $uid = is_login();


        $topiclist = parent::$commonLogic->getDataList('topic', ['m.uid' => $uid, 'm.status' => 1], 'm.*,user.nickname,user.userhead,group.name', 'm.create_time desc', 8, [['group', 'group.id=m.tid'], ['user', 'user.id=m.uid']]);


        $this->assign('topiclist', $topiclist);

        return $this->fetch();

    }

    /**
     * 忘记密码页面
     */
    public function forget()
    {
        session('http_referer', 1);
        if (IS_POST) {


            $datan = $this->request->param();

            $n = parent::$commonLogic->getDataInfo('user', ['usermail' => $datan['email']]);


            if (empty($n) || ($n['status'] != 2 && $n['status'] != 5)) {
                return json(array('code' => 0, 'msg' => '邮箱未激活或邮箱未注册'));
            } else {

                $data['email'] = $n['usermail'];

                $data['title'] = '找回密码';
                $str = md5($n['salt'] . $n['id'] . $n['usermail']);

                $data['body'] = 'http://' . $_SERVER['HTTP_HOST'] . url('user/resetmima') . '?mod=' . $n['id'] . '&id=' . $str;


                asyn_sendmail($data);
                return json(array('code' => 200, 'msg' => '邮件已发送，请到邮箱进行查收'));


            }


        } else {


        }

        return $this->fetch();

    }

    public function resetmima()
    {

        $data = $this->request->param();
        $n = parent::$commonLogic->getDataInfo('user', ['id' => $data['mod']]);

        if (md5($n['salt'] . $n['id'] . $n['usermail']) == $data['id']) {

            $this->assign('userid', $n['id']);
            $this->assign('salt', md5($n['salt']));
            $this->assign('username', $n['username']);

            return $this->fetch();
        } else {
            $this->error('非法操作', url('user/forget'));
        }

    }

    public function resetpass()
    {
        $data = $this->request->param();
        $n = parent::$commonLogic->getDataInfo('user', ['id' => $data['uid']]);
        if (md5($n['salt']) == $data['salt']) {

            if (md5($data['password'] . $n['salt']) == $n['password']) {

                $this->jump([RESULT_SUCCESS, '密码重置成功']);

            } else {
                $m['id'] = $n['id'];
                $m['password'] = md5($data['password'] . $n['salt']);

                $this->jump(parent::$commonLogic->dataEdit('user', $m, false, '密码重置成功'));
            }


        } else {
            $this->error('非法操作', url('index/index'));
        }


    }

    /**
     * 注册页面
     */
    public function register()
    {

        is_login() && $this->jump(RESULT_REDIRECT, 'Index/index');

        $yzm_list = parse_config_array('yzm_list');//1\注册2\登录3\忘记密码4\后台登录

        if (in_array(1, $yzm_list)) {

            $yzm = 1;

        } else {

            $yzm = 0;

        }

        $this->assign('yzm', $yzm);

        return $this->fetch();

    }

    /**
     * 注册处理
     */
    public function regHandle($username = '', $password = '', $repassword = '', $usermail = '', $verify = '')
    {

        $this->jump(self::$logicMember->regHandle($username, $password, $repassword, $usermail, $verify));

    }


    /**
     * 登录页面
     */
    public function login()
    {

        is_login() && $this->jump(RESULT_REDIRECT, 'Index/index');

        $yzm_list = parse_config_array('yzm_list');//1\注册2\登录3\忘记密码4\后台登录

        if (in_array(2, $yzm_list)) {

            $yzm = 1;

        } else {

            $yzm = 0;

        }

        $this->assign('yzm', $yzm);

        return $this->fetch();

    }

    /**
     * 登录处理
     */
    public function loginHandle($username = '', $password = '', $verify = '')
    {

        $this->jump(self::$logicMember->loginHandle($username, $password, $verify));

    }

    /**
     * 注销处理
     */
    public function logout()
    {

        $this->jump(self::$logicMember->logout());

    }

}
