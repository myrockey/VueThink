<?php

namespace app\admin\controller;

/**
 * 首页控制器
 */
class Index extends AdminBase
{

    /**
     * 首页方法
     */
    public function adminindex()
    {
    	$baseUrl = str_replace('\\','/',dirname($_SERVER['SCRIPT_NAME'])).'/';
    	 
    	$root='http://'.$_SERVER['HTTP_HOST'].$baseUrl;
    	$this->assign('root',$root);
       
    	
        
        return $this->fetch('adminindex');
    }
    public function home(){
    	// 获取首页数据
    	$index_data = $this->adminBaseLogic->getIndexData();
    	
    	//$domain=showyourdomain();
    	//$this->assign('domaininfo',$domain);
/*     	if($domain['sqstatus']==0){
    		$m=  file_get_contents('./template/default/index_footer.html');
    		if(strpos($m,'es.imzaker.com')!== false){
    			 
    		}else{
    			file_put_contents('./template/default/index_footer.html','<div class="footer" id="footer"><hr>  <p><a href="http://es.imzaker.com/">EasySNS极简社区</a> 2017 &copy; <a href="http://es.imzaker.com/">Es.imzaker.com</a></p></div>');
    		}
    		 
    	}
    	$this->assign('shouquanname',$domain['msg']); */
    	$domaininfo['version']='1.0.0';
    	$this->assign('shouquanname','未授权');
    	$this->assign('domaininfo',$domaininfo);
    	
    	$this->assign('data', $index_data);
    	return $this->fetch('home');
    }
    public function deal_sql() {
    
    	$path = dirname($_SERVER['SCRIPT_FILENAME']) . '/update/updatedb.php';
    	 
    	if (! file_exists ( $path )) {
    		return json(array('code' => 0, 'msg' => '升级文件不存在，请先把升级文件updatedb.php放置在/update/ 目录下'));
    
    	}
    }

	/**
	 * 导出excel
	 */
	public function exportExcel(){
		$name = $this->param['name'];
		$tabname = $this->param['tabname'];
		$titles = config('configexcel.'.$tabname)[0];
		$keys = config('configexcel.'.$tabname)[1];

		$data = model($tabname)->where('1=1')->field($keys)->order('id desc')->select();
		if(!$data) exit('<script>alert("数据为空");history.go(-1);</script>');

		switch ($tabname){
			case 'member':
				$pdata = model($tabname)->where('1=1')->column('id,nickname','id');
				foreach ($data as $k=>$val){
					$data[$k]['sex'] = $val['sex'] ? '男' : '女';
					$data[$k]['regtime'] = date('Y-m-d H:i:s',$val['regtime']);
					$data[$k]['vip_expire_time'] = $val['vip_expire_time'] ? date('Y-m-d H:i:s',$val['vip_expire_time']) : '尚未体验7天会员';
					$data[$k]['last_login_time'] = date('Y-m-d H:i:s',$val['last_login_time']);
					$data[$k]['leader_id'] =  isset($pdata[$val['leader_id']]) ? $pdata[$val['leader_id']] : '无';
					$data[$k]['grades'] =  getMemberGrade($val['grades']);
				}

				break;
			case 'shares':
				foreach ($data as $k=>$val){
					$data[$k]['market_connectivity_index'] = $val['market_connectivity_index'].'%';
					$data[$k]['share_winning_rate'] = $val['share_winning_rate'].'%';
				}

				break;
			case 'question':
				$pdata = model('member')->where('1=1')->column('id,nickname','id');
				foreach ($data as $k=>$val){
					$data[$k]['create_time'] = date('Y-m-d H:i:s',$val['create_time']);
					$data[$k]['uid'] =  isset($pdata[$val['uid']]) ? $pdata[$val['uid']] : '';
				}
				
				break;
			case 'pay':
				$goodsdata = model('member_goods')->where('1=1')->column('id,title','id');
				foreach ($data as $k=>$val){
					$data[$k]['creat_time'] = date('Y-m-d H:i:s',$val['creat_time']);
					$data[$k]['status'] = $val['status'] ? '支付成功' : '支付失败';
					$data[$k]['member_goodsid'] = isset($goodsdata[$val['member_goodsid']]) ? $goodsdata[$val['member_goodsid']] : '';

				}
				
				break;
			case 'article':
				foreach ($data as $k=>$val){
					$data[$k]['settop'] = $val['settop'] ? '已置顶' : '';
					$data[$k]['tid'] = '研习社新闻';
					$data[$k]['ispublic'] = $val['ispublic'] ? '已发布' : '';
					$data[$k]['create_time'] = date('Y-m-d H:i:s',$val['create_time']);

				}
				
				break;
		}

		export_excel($titles,$keys,$data,$name);
	}
}
