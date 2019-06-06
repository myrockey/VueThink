<?php
namespace app\index\controller;

use app\common\controller\HomeBase;
use think\Log;

class Index extends HomeBase
{

    public function _initialize()
    {
        parent::_initialize();
    }


    /**
     * 今日模拟
     * @return mixed
     */
    public function today()
    {

        if (!is_vip()) {
            $this->error('亲！请先开通vip会员', url('member/toinputcode'));
        }
        //当日是否更新
        $stime = date('Y-m-d 00:00:00');
        $etime = date('Y-m-d 23:59:59');
        $where = ' status=1 and ispublic=1 and unix_timestamp("' . $stime . '") <= unix_timestamp(title) and unix_timestamp("' . $etime . '") >= unix_timestamp(title)';
        $result = model('shares')->where($where)->order('title desc')->find();
        if (!empty($result)) {
            $is_update = 1;
        } else {
            //状态未更新，
            $is_update = 0;
            $etime = date('Y-m-d 23:59:59', strtotime('-1 day', time()));
            $where = ' status=1 and ispublic=1 and unix_timestamp("' . $etime . '") >= unix_timestamp(title)';
            $result = model('shares')->where($where)->order('title desc')->find();
        }

        $info = array();
        if(!empty($result)) {
            $info = $result->toArray();
            $info['cycle_shares'] = get_shares_item_arr($info['cycle_shares']);
            $info['grade2_shares'] = get_shares_item_arr($info['grade2_shares']);
            $info['grade1_shares'] = get_shares_item_arr($info['grade1_shares']);
            $info['follow_shares'] = get_shares_item_arr($info['follow_shares']);
        }
//		dump($info);

        $info['is_update'] = $is_update;
        $this->assign('info', $info);

        return $this->fetch();

    }
    public function today222()
    {

        if (!is_vip()) {
            $this->error('亲！请先开通vip会员', url('member/toinputcode'));
        }
        if (time() >= strtotime(date('Y-m-d 9:00:00', time())) && (time() <= strtotime(date('Y-m-d 15:00:00', time())))) {
//			echo '开盘中';
            //状态已更新，昨日收盘之后到今日收盘时间段
            $stime = date('Y-m-d 15:00:00', strtotime('-1 day', time()));
            $etime = date('Y-m-d 15:00:00');
            $where = ' status=1 and ispublic=1 and unix_timestamp("' . $stime . '") <= unix_timestamp(title) and unix_timestamp("' . $etime . '") >= unix_timestamp(title)';
            $result = model('shares')->where($where)->order('title desc')->find();
            if (!empty($result)) {
                $is_update = 1;
                $info = $result->toArray();
                $info['cycle_shares'] = get_shares_item_arr($info['cycle_shares']);
                $info['grade2_shares'] = get_shares_item_arr($info['grade2_shares']);
                $info['grade1_shares'] = get_shares_item_arr($info['grade1_shares']);
                $info['follow_shares'] = get_shares_item_arr($info['follow_shares']);
            } else {
                //状态未更新，
                $is_update = 0;
                $etime = date('Y-m-d 15:00:00', strtotime('-1 day', time()));
                $where = ' status=1 and ispublic=1 and unix_timestamp("' . $etime . '") >= unix_timestamp(title)';
                $result = model('shares')->where($where)->order('title desc')->find();
                $info = array();
            }
        } else {
//			echo '收盘了';

            $stime = date('Y-m-d 15:00:00');
            $where = ' status=1 and ispublic=1 and unix_timestamp("' . $stime . '") < unix_timestamp(title)';
            $result = model('shares')->where($where)->order('title desc')->find();
            if (!empty($result)) {
                //状态已更新
                $is_update = 1;

            } else {
                //状态未更新
                $is_update = 0;
                $etime = date('Y-m-d 15:00:00');
                $where = ' status=1 and ispublic=1 and unix_timestamp("' . $etime . '") >= unix_timestamp(title)';
                $result = model('shares')->where($where)->order('title desc')->find();

            }
        }
        $info = $result->toArray();
        $info['cycle_shares'] = get_shares_item_arr($info['cycle_shares']);
        $info['grade2_shares'] = get_shares_item_arr($info['grade2_shares']);
        $info['grade1_shares'] = get_shares_item_arr($info['grade1_shares']);
        $info['follow_shares'] = get_shares_item_arr($info['follow_shares']);

//		dump($info);

        $info['is_update'] = $is_update;
        $this->assign('info', $info);

        return $this->fetch();

    }
    public function intro(){
        return $this->fetch();
    }

    /**
     * 昨日荐股
     * @return mixed
     */
    public function yesterday()
    {
        if (!is_vip()) {
            $this->error('亲！请先开通vip会员', url('member/toinputcode'));
        }
//		$info = parent::$commonLogic->getDataList('shares',['status'=>1,'title'=>array('lt',date('Y-m-d 00:00'))],true,'title desc',false,'','',5);
        $where = ' status=1 and ispublic=1 and unix_timestamp("' . date('Y-m-d 23:59:59', strtotime('-1 day', time())) . '") >= unix_timestamp(title)';
        $info = model('shares')->where($where)->order('title desc')->limit(5)->select();

        if (empty($info)) $info = array();

        foreach ($info as $k => $val) {
            $val = $val->toArray();
            $info[$k]['cycle_shares'] = get_shares_item_arr($val['cycle_shares']);
            $info[$k]['grade2_shares'] = get_shares_item_arr($val['grade2_shares']);
            $info[$k]['grade1_shares'] = get_shares_item_arr($val['grade1_shares']);
            $info[$k]['follow_shares'] = get_shares_item_arr($val['follow_shares']);
        }

        $this->assign('list', $info);
        return $this->fetch();
    }

    /**
     * 研习社
     * @return mixed
     */
    public function index()
    {
        return $this->fetch();
    }
    public function getarticlelist(){
        $page = request()->param('page', 0);
        $order='settop desc,create_time desc,id desc';
        $page = max(1, intval($page));
        $psize = 10;
        $where = ['status'=>1,'ispublic'=>1];
        $list = model('article')->where($where)->field('id,title,create_time,copyfrom,settop')->order($order)->page($page.','.$psize)->select();
        $total = model('article')->where($where)->count();
        $arr = [
            'msg' => '请求成功',
            'code' => 1,
            "list" => $list,
            "page" => $page,
            "pagesize" => $psize,
            'total' => $total
        ];
        if(!$list){
            $arr['msg']='已无更多数据!';
            $arr['code']=0;
        }

        return json($arr);
    }

    /**
     * 研习社内容详情页
     * @param $id
     * @return mixed
     */
    public function analysisdetail($id){

        if($id>0){

            parent::$commonLogic->setDataValue('article',['id'=>$id], 'view', array('exp','view+1'));

            $info = parent::$commonLogic->getDataInfo('article',['id'=>$id]);

            $this->assign('info',$info);

        }else{

            $this->error('非法操作', 'index/analysis');

        }
        return $this->fetch();

    }

    /**
     * 多空分析
     * @return mixed
     */
    public function analysis2()
    {
        if (!is_vip()) {
            $this->error('亲！请先开通vip会员', url('member/toinputcode'));
        }
        if (time() >= strtotime(date('Y-m-d 9:00:00', time())) && (time() <= strtotime(date('Y-m-d 15:00:00', time())))) {
//			echo '开盘中';
            //状态已更新，昨日收盘之后到今日收盘时间段
            $stime = date('Y-m-d 15:00:00', strtotime('-1 day', time()));
            $etime = date('Y-m-d 15:00:00');
            $where = ' status=1 and unix_timestamp("' . $stime . '") <= unix_timestamp(title) and unix_timestamp("' . $etime . '") >= unix_timestamp(title)';
            $result = model('shares')->where($where)->order('title desc')->find();
            if (!empty($result)) {
                $is_update = 1;
                $info = $result->toArray();
                $info['cycle_shares'] = get_shares_item_arr($info['cycle_shares']);
                $info['grade2_shares'] = get_shares_item_arr($info['grade2_shares']);
                $info['grade1_shares'] = get_shares_item_arr($info['grade1_shares']);
                $info['follow_shares'] = get_shares_item_arr($info['follow_shares']);
            } else {
                //状态未更新，
                $is_update = 0;
                $etime = date('Y-m-d 15:00:00', strtotime('-1 day', time()));
                $where = ' status=1 and unix_timestamp("' . $etime . '") >= unix_timestamp(title)';
                $result = model('shares')->where($where)->order('title desc')->find();
                $info = array();
            }
        } else {
//			echo '收盘了';

            $stime = date('Y-m-d 15:00:00');
            $where = ' status=1 and unix_timestamp("' . $stime . '") < unix_timestamp(title)';
            $result = model('shares')->where($where)->order('title desc')->find();
            if (!empty($result)) {
                //状态已更新
                $is_update = 1;

            } else {
                //状态未更新
                $is_update = 0;
                $etime = date('Y-m-d 15:00:00');
                $where = ' status=1 and unix_timestamp("' . $etime . '") >= unix_timestamp(title)';
                $result = model('shares')->where($where)->order('title desc')->find();

            }
        }
        $info = $result->toArray();
        $info['imgArr'] = array_filter(array($info['img1_id'], $info['img2_id'], $info['img3_id'], $info['img4_id'], $info['img5_id'], $info['img6_id']));
        foreach ($info['imgArr'] as $k => $val) {
            $img = model('picture')->where(['id' => $val])->limit(1)->field('path')->select();
            $info['imgArr'][$k] = WEB_PATH_PICTURE . $img[0]['path'];
        }

//		dump($info);

        $info['is_update'] = $is_update;

        $this->assign('info', $info);
        return $this->fetch();
    }

    /**
     * 优先存储，输入邀请码
     * @return mixed
     */
    public function tosavecode()
    {
        $recommendCode = request()->param('recommendCode', "");
        if (IS_GET && $recommendCode) {
            session('recommendCode', $recommendCode);
            $this->jump(RESULT_REDIRECT, 'member/toinputcode');
        }
        $this->jump(RESULT_REDIRECT, 'member/index');
    }

    public function tologin()
    {
//		$wchat = new \wechatlogin\wechatOauth();
//		$code = request()->param('code',"");
//		$userInfo = $wchat->getUserAccessUserInfo($code);
//		dump($userInfo);

    }

    public function index222()
    {


        $uid = is_login();

        //热门小组列表
        $hotgrouplist = parent::$commonLogic->getDataList('group', ['status' => 1], true, 'sort desc,membercount desc,topiccount desc', false, '', '', 6);
        $this->assign('hotgrouplist', $hotgrouplist);

        if ($uid > 0) {


        }

        $hottopiclist = parent::$commonLogic->getDataList('topic', ['m.status' => 1], 'm.*,user.nickname,user.userhead,group.name,group.cover_id', 'm.update_time desc,m.view desc,m.choice desc', false, [['user', 'user.id=m.uid', 'LEFT'], ['group', 'group.id=m.tid']], '', 6);
        foreach ($hottopiclist as $k => $v) {

            $comment = model('comment')->where(['fid' => $v['id']])->order('create_time desc')->limit(1)->select();
            if ($comment) {
                $hottopiclist[$k]['ccreate_time'] = $comment[0]['create_time'];
                $hottopiclist[$k]['cuid'] = $comment[0]['uid'];
            }

        }


        $this->assign('hottopiclist', $hottopiclist);


        //为你推荐4
        $tjgrouplist = parent::$commonLogic->getDataList('group', ['status' => 1, 'choice' => 1], true, 'update_time desc', false, '', '', 4);
        $this->assign('tjgrouplist', $tjgrouplist);
        //最新话题5
        $newtopiclist = parent::$commonLogic->getDataList('topic', ['status' => 1], true, 'create_time desc', false, '', '', 5);
        $this->assign('newtopiclist', $newtopiclist);


        return $this->fetch();

    }

    public function yzemailurl($id)
    {
        if (is_login() == 0) {

            $this->error('亲！请登录', url('index/login'));
        } else {
            $uid = is_login();


            $user = parent::$commonLogic->getDataInfo('user', ['id' => $uid]);

            if ($id == md5($user['salt'] . $uid . $user['usermail'])) {
                if ($user['status'] < 3) {


                    parent::$commonLogic->setDataValue('user', ['id' => $uid], 'status', 2);
                } else {

                    parent::$commonLogic->setDataValue('user', ['id' => $uid], 'status', 5);
                }

                $this->success('验证成功', url('user/index'));


            } else {
                $this->error('非法验证', url('user/index'));
            }

        }


    }

    public function yzemail()
    {

        $mail = $this->request->param();

        $uid = is_login();
        $user = parent::$commonLogic->getDataInfo('user', ['id' => $uid]);

        $emailinfo = parent::$commonLogic->getDataInfo('user', ['usermail' => $mail['email'], 'id' => array('neq', $uid)]);
        if ($emailinfo) {
            return json(array('code' => 0, 'msg' => '该邮箱已经被其他账号注册'));
        } else {
            $n['usermail'] = $mail['email'];
            $n['id'] = $uid;
            parent::$commonLogic->dataEdit('user', $n, false);


            $data['email'] = $mail['email'];
            $data['title'] = '邮箱验证';
            $str = md5($user['salt'] . $uid . $data['email']);
            $data['body'] = '您的链接已经生成<br>http://' . $_SERVER['HTTP_HOST'] . url('index/yzemailurl') . '?id=' . $str;


            asyn_sendmail($data);
            return json(array('code' => 1, 'msg' => '邮箱登录已更改为新邮箱，请到邮箱查收验证'));
        }


    }

    public function forgetcodebymail()
    {

        $mail = $this->request->param();

        $emailinfo = parent::$commonLogic->getDataInfo('user', ['usermail' => $mail['email']]);
        //是否能得到


        if ($emailinfo) {


            $data['email'] = $mail['email'];
            $data['title'] = '忘记密码-邮箱验证';


            $code = generate_code($mail['email']);
            $data['body'] = '您的验证码已经生成<br>' . $code;
            asyn_sendmail($data);
            return json(array('code' => 1, 'msg' => '验证码已经发送，请到邮箱查收验证'));

        } else {
            return json(array('code' => 0, 'msg' => '该邮箱不存在'));


        }

    }

    public function reyzemail()
    {

        $mail = $this->request->param();
        $uid = is_login();
        $user = parent::$commonLogic->getDataInfo('user', ['id' => $uid]);


        $emailinfo = parent::$commonLogic->getDataInfo('user', ['usermail' => $mail['email'], 'id' => array('neq', $uid)]);
        if ($emailinfo) {
            return json(array('code' => 0, 'msg' => '邮箱已被使用'));
        } else {
            $n['usermail'] = $mail['email'];
            if ($user['status'] == 2) {
                $n['status'] = 1;
            } else {
                $n['status'] = 3;
            }
            $n['id'] = $uid;
            parent::$commonLogic->dataEdit('user', $n, false);


            $data['email'] = $mail['email'];
            $data['title'] = '邮箱验证';
            $str = md5($user['salt'] . $uid . $data['email']);
            $data['body'] = '您的链接已经生成<br>http://' . $_SERVER['HTTP_HOST'] . url('index/yzemailurl') . '?id=' . $str;
            asyn_sendmail($data);
            return json(array('code' => 1, 'msg' => '邮箱登录已更改为新邮箱，请到邮箱查收验证'));


        }

    }

    public function send_mail()
    {


        $mail = $this->request->param();

        $res = send_email($mail['email'], $mail['title'], $mail['body']);

        if ($res == 1) {
            return json(array('code' => 1, 'msg' => '邮件已发送，请到邮箱进行查收'));
            //	$this->success('邮件已发送，请到邮箱进行查收');
        } else {
            return json(array('code' => 0, 'msg' => '邮件发送失败，请检查邮箱设置'));
            //$this->error('邮件发送失败，请检查邮箱设置');
        }
    }
}
