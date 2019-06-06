<?php
namespace app\index\controller;
use app\common\controller\HomeBase;


use app\admin\controller\Callback;

class Appapi extends  HomeBase
{
	protected function _initialize()
	{
		

		
	}
	
	public function getgrouptopic($id,$sorttype,$page){
		
		empty($sorttype) && $sorttype = 1;//1表示最新发帖2最新回复3按回复数排序
		
		if($sorttype==1){
			$order='m.settop desc,m.create_time desc';
		}else if($sorttype ==2){
			$order='m.settop desc,m.update_time desc';
		}else{
			$order='m.settop desc,m.reply desc';
		}
		
		$topicwhere['m.tid']=$id;
		$topicwhere['m.status']=1;
		
		
		$list=model('topic')->alias('m')->where($topicwhere)->field('m.*,user.nickname,user.userhead')->order($order)->join([['user','user.id=m.uid','LEFT']])->page($page.',10')->select();
		
		
	
			if($list==null){
		
		$list['msg']='已无更多数据!';
		$list['status']=0;
	}else{
		foreach ($list as $k =>$v){
			$list[$k]['imagesarr']=getcontentimage(html_entity_decode($v['content']))[0];
		$list[$k]['create_time']=friendlyDate($list[$k]['create_time']);
		
		$list[$k]['descontent']=msubstr(clearHtml(htmlspecialchars_decode($list[$k]['content'])),0,60);
		$list[$k]['userhead']=getheadurl($list[$k]['userhead']);
		
		$list[$k]['userurl']=url('user/home',array('id'=>$v['uid']));
		$list[$k]['gurl']=url('group/gview',array('id'=>$v['id']));
			$comment=model('comment')->where(['fid'=>$v['id']])->order('create_time desc')->limit(1)->select();
			if($comment){
				$list[$k]['ccreate_time']=$comment[0]['create_time'];
				$list[$k]['cuid']=$comment[0]['uid'];
			}
		
		}
	}
		
		echo json_encode($list);
	}
	public function getusertopic($useruid,$page){
	

	
	
		$list=model('topic')->alias('m')->where(['m.status'=>1,'m.uid'=>$useruid])->field('m.*,user.nickname,user.userhead')->order('m.create_time desc')->join([['user','user.id=m.uid','LEFT']])->page($page.',10')->select();
	
	
	
		if($list==null){
	
			$list['msg']='已无更多数据!';
			$list['status']=0;
		}else{
			foreach ($list as $k =>$v){
				$list[$k]['imagesarr']=getcontentimage(html_entity_decode($v['content']))[0];
				$list[$k]['create_time']=friendlyDate($list[$k]['create_time']);
	
				$list[$k]['descontent']=msubstr(clearHtml(htmlspecialchars_decode($list[$k]['content'])),0,60);
				$list[$k]['userhead']=getheadurl($list[$k]['userhead']);
	
				$list[$k]['userurl']=url('user/home',array('id'=>$v['uid']));
				$list[$k]['gurl']=url('group/gview',array('id'=>$v['id']));
				$comment=model('comment')->where(['fid'=>$v['id']])->order('create_time desc')->limit(1)->select();
				if($comment){
					$list[$k]['ccreate_time']=$comment[0]['create_time'];
					$list[$k]['cuid']=$comment[0]['uid'];
				}
	
			}
		}
	
		echo json_encode($list);
	}
	
}

?>