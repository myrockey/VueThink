<?php
namespace app\index\controller;
use app\common\controller\HomeBase;

use app\admin\controller\Callback;


class Group extends  HomeBase
{
	
	
	public function _initialize()
	{
		parent::_initialize();
	
	
		
	}
	public function checkusergroupinfo($id){
		
		$uid=is_login();
		if($uid>0){
			$usergroupinfo=parent::$commonLogic->getDataInfo('user_group',['group_id'=>$id,'uid'=>$uid]);
		}else{
			$usergroupinfo=array();
		}
		$this->assign('usergroupinfo',$usergroupinfo);
		
		
	}
	
	public function groupinfo($id){
		
		$groupinfo=parent::$commonLogic->getDataInfo('group',['id'=>$id]);
		$this->assign('groupinfo',$groupinfo);
		$uid=is_login();
		 
		$where['uid']=$uid;
		$where['group_id']=$id;
		 
		$this->assign('usergroupinfo',parent::$commonLogic->getDataInfo('user_group',$where));
		
		$topiccount=	model('topic')->where(['uid'=>$uid,'tid'=>$id])->count();
		$this->assign('topiccount',$topiccount);
		$commentcount =	model('comment')->where(['uid'=>$uid,'gid'=>$id])->count();
		$this->assign('commentcount',$commentcount);
		$this->assign('uid',$uid);
		
		
		
	}
   public function index(){
   	
   
   	
   	if(empty($this->param['id'])){
   		$this->error('非法参数',url('index/index'));
   	}
   	$id=$this->param['id'];
   	$this->groupinfo($id);
   	$this->checkusergroupinfo($id);
   	
   	$uid=is_login();
   	usercz($uid,$id,2,2);
   	
   	empty($this->param['sorttype']) ? $sorttype = 1 : $sorttype = $this->param['sorttype'];//1表示最新发帖2最新回复3按回复数排序
   	$this->assign('sorttype',$sorttype);
   	
   	empty($this->param['type']) ? $type = 1 : $type = $this->param['type'];//1表示全部2表示精华
   	$this->assign('type',$type);
   	
   	$topicwhere['m.tid']=$id;
   	$topicwhere['m.status']=1;
   	
   	if($type==2){
   		$topicwhere['m.choice']=1;
   	}
   	
   	if($sorttype==1){
   		$order='m.settop desc,m.create_time desc';
   	}else if($sorttype ==2){
   		$order='m.settop desc,m.update_time desc';
   	}else{
   		$order='m.settop desc,m.reply desc';
   	}
   	
   	$list=parent::$commonLogic->getDataList('topic',$topicwhere,'m.*,user.nickname,user.userhead',$order,0,[['user','user.id=m.uid','LEFT']]);
   	foreach ($list as $k =>$v){
   		$list[$k]['imagesarr']=getcontentimage(html_entity_decode($v['content']))[0];
   		
   		$comment=model('comment')->where(['fid'=>$v['id']])->order('create_time desc')->limit(1)->select();
   		if($comment){
   			$list[$k]['ccreate_time']=$comment[0]['create_time'];
   			$list[$k]['cuid']=$comment[0]['uid'];
   		}
   		
   	}
  
   	$this->assign('list',$list);

   


   	//最新加入
   	$memberlist=parent::$commonLogic->getDataList('user_group',['m.group_id'=>$id,'m.grade'=>0],'m.*,user.nickname,user.userhead,user.grades','m.create_time desc',false,[['user','user.id=m.uid','LEFT']],'',9);
   	$this->assign('memberlist',$memberlist);
   	
   	
   
   	$this->assign('groupid',$id);
   	return $this->fetch();
   	
   }
   public function joingroup(){
   	if(empty(session('member_info'))){
   		$this->jump([RESULT_ERROR,'还未登录']);
   	}
   	$uid=session('member_info')['id'];
   	
   	$data['uid']=$uid;
   	
   	$data['group_id']=$this->param['id'];
   	$info=parent::$commonLogic->getDataInfo('user_group',$data);
   	
 
   	if($info){
   		if($info['grade']==2){
   			$this->jump([RESULT_ERROR,'您是组长，不能退出该组']);
   		}else{
   			
   			model('group')->where(['id'=>$data['group_id']])->setDec('membercount');
   			
   			$this->jump(parent::$commonLogic->dataDel('user_group',$data,'退出成功',true));
   		}
   		
   		
   		
   	}else{
   		$data['grade']=0;
   		
   		model('group')->where(['id'=>$data['group_id']])->setInc('membercount');
   		
   		$this->jump(parent::$commonLogic->dataAdd('user_group',$data,false,'加入成功'));
   	}
   	
   
   	
   	
   }
   public function groupcz(){
   
   	$uid=is_login();
   	if($uid==0){
   		$this->jump([RESULT_ERROR,'还未登录']);
   	}
 
   	
   	if(empty($this->param)){
   		$this->jump([RESULT_ERROR,'非法操作']);
   	}
   	
   	$gid=$this->param['id'];
   	$guid=$this->param['uid'];
   	$type=$this->param['type'];
   	
   	
   	if($uid!=model('user_group')->where(['group_id'=>$gid,'grade'=>2])->value('uid')){
   		$this->jump([RESULT_ERROR,'非法操作']);
   	}
   	
   	switch ($type){
   		
   		case 'jinyan':
   			
   			$this->jump(parent::$commonLogic->setDataValue('user_group',['group_id'=>$gid,'uid'=>$guid],'status',0));
   			
   			
   			
   			break;
   		case 'jcjinyan':
   			$this->jump(parent::$commonLogic->setDataValue('user_group',['group_id'=>$gid,'uid'=>$guid],'status',1));
   			
   			
   			
   			break;
   			case 'shengzhi':
   				$this->jump(parent::$commonLogic->setDataValue('user_group',['group_id'=>$gid,'uid'=>$guid],'grade',1));
   				
   				break;
   				case 'tichu':
   					$this->jump(parent::$commonLogic->dataDel('user_group',['group_id'=>$gid,'uid'=>$guid],'已踢出',true));
   					break;
   					case 'jiangzhi':
   						$this->jump(parent::$commonLogic->setDataValue('user_group',['group_id'=>$gid,'uid'=>$guid],'grade',0));
   						break;
   					default:
   						$this->jump([RESULT_ERROR,'非法操作']);
   						break;
   		
   		
   	}
 
   
   
   }
   public function topicadd(){
   	 
  
   	
   	if(IS_POST){
   		$uid=is_login();
   		$data=$this->param;
   		$groupinfo=parent::$commonLogic->getDataInfo('group',['id'=>$data['tid'],'pid'=>$data['gid']]);
   		if(empty($groupinfo)||$uid==0){
   			$this->jump([RESULT_ERROR,'传参错误']);
   		}
   		
   		if(model('user_group')->where(['group_id'=>$data['tid'],'uid'=>$uid])->value('status')==0){
   			
   			$this->jump([RESULT_ERROR,'您已被该组管理禁言']);
   			
   		}
   		
   		
   		
   		$data['content']=htmlspecialchars_decode($data['content']);
   		$data['uid']=$uid;
   		
   		model('group')->where(['id'=>$data['tid']])->setInc('topiccount');
   		$this->jump(parent::$commonLogic->dataAdd('topic',$data));
   		
   	}else{
   		if(empty($this->param['id'])){
   			$this->error('非法参数',url('index/index'));
   		}
   		$id=$this->param['id'];
   		$groupinfo=parent::$commonLogic->getDataInfo('group',['id'=>$id]);
   		if(empty($groupinfo)){
   			$this->error('该小组不存在',url('index/index'));
   		}
   		
   		//	$cateinfo=parent::$commonLogic->getDataInfo('groupcate',['id'=>$groupinfo['pid']]);
   		
   		$emotionlist=parse_config_attr(config('emot_list'));
   		
   		$this->assign('emotionlist',$emotionlist);
   		$this->assign('groupinfo',$groupinfo);
   		$this->assign('tid',$id);
   	}
   	
   	return $this->fetch();
   	 
   }
   public function topicedit(){
   	 
   	$uid=is_login();
   
   	if(IS_POST){
   		
   		$data=$this->param;
   		$groupinfo=parent::$commonLogic->getDataInfo('group',['id'=>$data['tid'],'pid'=>$data['gid']]);
   		if(empty($groupinfo)||$uid==0){
   			$this->jump([RESULT_ERROR,'传参错误']);
   		}
   		 
   		if(model('user_group')->where(['group_id'=>$data['tid'],'uid'=>$uid])->value('status')==0){
   
   			$this->jump([RESULT_ERROR,'您已被该组管理禁言']);
   
   		}
   		 
   		 
   		 
   		$data['content']=htmlspecialchars_decode($data['content']);
   		$data['uid']=$uid;
   		$this->jump(parent::$commonLogic->dataEdit('topic',$data));
   		 
   	}else{
   		if(empty($this->param['id'])){
   			$this->error('非法参数',url('index/index'));
   		}
   		$id=$this->param['id'];
   		
   		$info=parent::$commonLogic->getDataInfo('topic',['id'=>$id]);
   		
   		if($uid!=$info['uid']){
   			
   			$this->error('非法操作',url('index/index'));
   		}
   		
   		$groupinfo=parent::$commonLogic->getDataInfo('group',['id'=>$info['tid']]);
   		
   		$this->assign('info',$info);
   		$this->assign('groupinfo',$groupinfo);
   		
   	}
   
   	return $this->fetch();
   	 
   }

   public function groupadd(){
   	 
   
   
   	if(IS_POST){
   		$uid=is_login();
   		$data=$this->param;
   		$data['describe']=htmlspecialchars_decode($data['describe']);
   		$data['status']=0;
   		$obj=new Callback();
   		$this->jump(parent::$commonLogic->dataInsert('group',$data,false,'申请提交成功,等待审核',$obj,'groupadd_call_back'));
   	
   
   		 
   	}else{
   		
   		$this->assign('groupcate_list',parent::$commonLogic->getDataList('groupcate',['status'=>1], true, 'id desc',false));
   	
   	}
   
   	return $this->fetch();
   	 
   }
   public function groupedit(){
   	 
   	 
   	 
   	if(IS_POST){
   		$uid=is_login();
   		$data=$this->param;
   		 
   		 
   		$where['uid']=$uid;
   		$where['group_id']=$data['id'];
   		$where['grade']=2;
   		 
   		if(model('user_group')->where($where)->count()>0){
   
   
   
   
   
   			$data['describe']=htmlspecialchars_decode($data['describe']);
   				
   			$this->jump(parent::$commonLogic->dataEdit('group',$data,false));
   		}else{
   			$this->jump([RESULT_ERROR,'非法操作']);
   		}
   		 
   		 
   
   
   
   
   
   	}else{
   		if(empty($this->param['id'])){
   			$this->error('非法参数',url('index/index'));
   		}
   		$id=$this->param['id'];
   		$groupinfo=parent::$commonLogic->getDataInfo('group',['id'=>$id]);
   		if(empty($groupinfo)){
   			$this->error('该小组不存在',url('index/index'));
   		}
   
   		//	$cateinfo=parent::$commonLogic->getDataInfo('groupcate',['id'=>$groupinfo['pid']]);
   
   		$this->assign('groupinfo',$groupinfo);
   		$this->assign('tid',$id);
   	}
   	 
   	return $this->fetch();
   	 
   }
   public function member(){
   	if(empty($this->param['id'])){
   		$this->error('非法参数',url('index/index'));
   	}
   	$id=$this->param['id'];
   	
   	
   	
   	
   	$uid=is_login();
   	$this->checkusergroupinfo($id);
   	
   	
   
   	//组长
   	$zuzhanginfo=parent::$commonLogic->getDataInfo('user_group',['m.group_id'=>$id,'m.grade'=>2],'m.*,user.nickname,user.statusdes,user.userhead,user.grades',[['user','user.id=m.uid','LEFT']]);
   	$this->assign('zuzhanginfo',$zuzhanginfo);
   	//副组长
   	$fzuzlist=parent::$commonLogic->getDataList('user_group',['m.group_id'=>$id,'m.grade'=>1],'m.*,user.nickname,user.statusdes,user.userhead,user.grades','m.create_time asc',false,[['user','user.id=m.uid','LEFT']]);
   	$this->assign('fzuzlist',$fzuzlist);
   	//组员
   	
   	$zuylist=parent::$commonLogic->getDataList('user_group',['m.group_id'=>$id,'m.grade'=>0],'m.*,user.nickname,user.statusdes,user.userhead,user.grades','m.create_time asc',30,[['user','user.id=m.uid','LEFT']]);
   	$this->assign('zuylist',$zuylist);

   	
   	$this->assign('groupid',$id);
   	 
   	return $this->fetch();
   	 
   }
   public function glist(){
   
   	empty($this->param['keyword'])?$keyword='':$keyword=$this->param['keyword'];
   	
   	$this->assign('keyword',$keyword);
   	
   	$allgcatelist=
   	
   	$groupcatelist=parent::$commonLogic->getDataList('groupcate',['pid'=>0,'status'=>1],true,'sort desc',false);
   	 
   	$this->assign('groupcatelist',$groupcatelist);
   	
   	$waplist=array();
   	
   	foreach ($groupcatelist as $k =>$v){
   		
   		$b['pid']=$v['id'];
   		$b['status']=1;
   		
   		$waplist[$k]['name']=$v['name'];
   		$waplist[$k]['count']=model('group')->where($b)->count();
   		$waplist[$k]['id']=$v['id'];
   		$waplist[$k]['child']=parent::$commonLogic->getDataList('group',$b,true,'choice desc,sort desc',false);
   		
   	}
   
   	$this->assign('waplist',$waplist);
   	empty($this->param['pid'])?$pid=0:$pid=$this->param['pid'];
   	$this->assign('pid',$pid);
   	
   	$where['status']=1;
   	$where['name']=array('like','%'.$keyword.'%');
   	
   	if($pid==0){
   		
   	}else{
   		$where['pid']=$pid;
   	}
   	$grouplist=parent::$commonLogic->getDataList('group',$where,true,'choice desc,sort desc');
   	$this->assign('grouplist',$grouplist);
   	
   	
   	return $this->fetch();
   
   }
   public function gview(){
   	if(empty($this->param['id'])){
   		$this->error('非法参数',url('index/index'));
   	}
   	$id=$this->param['id'];
  
   	
   	
   	
   	$uid=is_login();
   	$this->assign('uid',$uid);
   	//目前回复数为pid=0的回复总数
   	$topicinfo=parent::$commonLogic->getDataInfo('topic',['m.id'=>$id],'m.*,user.nickname,user.statusdes,user.userhead,user.grades',[['user','user.id=m.uid','LEFT']]);
   	$this->checkusergroupinfo($topicinfo['tid']);
   	
   	usercz($uid,$id,2,1);
   	parent::$commonLogic->setDataValue('topic',['id'=>$id],'view',array('exp','view+1'));
   	if($uid>0){
   		
   		$sc['type']=3;
   		$sc['sid']=$id;
   		$sc['uid']=$uid;
   		 
   		if(model('zan')->where($sc)->count()>0){
   			$topicinfo['hassc']=1;
   		}else{
   			$topicinfo['hassc']=0;
   		}
   		
   		
   	}else{
   		
   		$topicinfo['hassc']=0;
   	}
   	
   	
   	$this->assign('topicid',$id);
   	$this->assign('groupid',$topicinfo['tid']);
   	
   	$this->groupinfo($topicinfo['tid']);
   	 
   	empty($this->param['ctype']) ? $ctype = 1 : $ctype = $this->param['ctype'];
   	empty($this->param['viewl']) ? $viewl = 1 : $viewl = $this->param['viewl'];
   	
   	$where['m.pid']=0;
   	$where['m.fid']=$id;
   	
   	if($viewl==2){
   		$where['m.uid']=$topicinfo['uid'];
   	}else{
   		
   	}
  
   	if($ctype==2){
   		 $order='m.create_time desc';
   	}else{
   		$order='m.create_time asc';
   	}
   	$this->assign('ctype',$ctype);
   	$this->assign('viewl',$viewl);
   	
   	$commentlist=parent::$commonLogic->getDataList('comment',$where,'m.*,user.nickname,user.userhead,user.grades',$order,10,[['user','user.id=m.uid','LEFT']]);
   	foreach ($commentlist as $k =>$v){
   		
   		$commentlist[$k]['child']=parent::$commonLogic->getDataList('comment',['pid'=>$v['id']],'m.*,user.nickname,user.userhead,user.grades',$order,false,[['user','user.id=m.uid','LEFT']]);
   		
   	}
   	$this->assign('commentlist',$commentlist);
  
   	//最近活跃
   	$memberlist=parent::$commonLogic->getDataList('topic',['m.tid'=>$topicinfo['tid']],'m.uid,user.nickname,user.userhead,user.grades,count(m.id) as tcount,count(comment.id) as ccount','tcount desc,ccount desc',false,[['user','user.id=m.uid','LEFT'],['comment','user.id=comment.uid and comment.gid=m.tid','LEFT']],'m.uid,comment.uid',12);

   	$this->assign('memberlist',$memberlist);
   	empty($this->param['page']) ? $page = 1 : $page = $this->param['page'];
   	$this->assign('page',$page);
   	
   	$this->assign('topicinfo',$topicinfo);
   	return $this->fetch();
   	 
   }
   public function commentadd(){
   	if(IS_POST){
   	$uid=is_login();
   	$data=$this->param;
   	$topicinfo=parent::$commonLogic->getDataInfo('topic',['id'=>$data['fid']]);
   	
   	
   	if(empty($topicinfo)){
   		$this->jump([RESULT_ERROR,'传参错误']);
   	}
   	if($uid==0){
   		$this->jump([RESULT_ERROR,'您还未登录']);
   	}
   	
   	$data['uid']=$uid;
   	$data['gid']=$topicinfo['tid'];
   	$data['content']=htmlspecialchars_decode($data['content']);
   	
   	$data['floor']=0;
   	
   	if($data['pid']>0){
   		model('comment')->where(['id'=>$data['pid']])->setInc('reply');
   		
   		if($this->param['pidcontent']!=0){
   			$data['content']=$this->param['pidcontent'].$data['content'];
   		}
   		
   		
   	}else{
   		
   		$floor=model('comment')->where(['pid'=>0,'fid'=>$data['fid']])->order('floor desc')->limit(1)->select();
   		if($floor){
   		$data['floor']=$floor[0]['floor']+1;
   		}else{
   			$data['floor']=2;
   		}
   	}
   $obj = new Group();
   	
   	$this->jump(parent::$commonLogic->dataAdd('comment',$data,true,'评论成功',$obj,'commentadd_callback'));
   	}else{
   	
   		$emotionlist=parse_config_attr(config('emot_list'));
   		$data=$this->param;
   		$topicinfo=parent::$commonLogic->getDataInfo('topic',['id'=>$data['fid']]);
   		$uid=is_login();
   		if($uid==0){
   			$this->jump([RESULT_ERROR,'您还未登录',url('group/gview',array('id'=>$data['fid']))]);
   		}
   		$this->assign('topicinfo',$topicinfo);
   		$this->assign('emotionlist',$emotionlist);
   		return $this->fetch();
   		
   	}
   	
   	
   }
   public function commentadd_callback($result,$data){
   	
   	if($data['pid']==0){
   		model('topic')->where(['id'=>$data['fid']])->setInc('reply');
   	}
   	model('topic')->where(['id'=>$data['fid']])->setField('update_time',time());
   	
   }
   public function sctopic(){
   	$id=$this->param['id'];
   
  
   	$uid=is_login();
   	if($uid==0){
   		$this->jump(([RESULT_ERROR, '请登录后操作']));
   	}else{
   		
   		
   		$where['type']=3;
   		$where['sid']=$id;
   		$where['uid']=$uid;
   		
   		if(model('zan')->where($where)->count()>0){
   			$this->jump(parent::$commonLogic->dataDel('zan',['type'=>3,'sid'=>$id,'uid'=>$uid],'取消收藏',true));
   		}else{
   			$data['type']=3;
   			$data['sid']=$id;
   			$data['uid']=$uid;
   			$this->jump(parent::$commonLogic->dataAdd('zan',$data,false,'收藏成功'));
   			
   		}
   		

   			
   			
   	}
   	
   }
}
