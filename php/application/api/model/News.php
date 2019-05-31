<?php
// +----------------------------------------------------------------------
// | Description: 菜单
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------

namespace app\api\model;

use think\Db;
use app\api\model\Common;

class News extends Common 
{

    /**
     * 为了数据库的整洁，同时又不影响Model和Controller的名称
     * 我们约定每个模块的数据表都加上相同的前缀，比如微信模块用weixin作为数据表前缀
     */
    protected $name = 'news';
	protected $createTime = 'create_time';
	protected $updateTime = false;
	protected $autoWriteTimestamp = true;
	protected $insert = [
		'status' => 1,
	];

	/**
	 * [getDataList 获取列表]
	 * @linchuangbin
	 * @DateTime  2017-02-10T21:07:18+0800
	 * @return    [array]                         
	 */
	public function getDataList($where, $sort = '',$limit = 10)
	{
		$data = $this->where($where)->field('id,title,thumb,create_time,description,ispublic,copyfrom,copyfromlink')->order($sort)->limit($limit)->select();
		return $data;
	}

	/**
	 * [getDataById 根据主键获取详情]
	 * @linchuangbin
	 * @DateTime  2017-02-10T21:16:34+0800
	 * @param     string                   $id [主键]
	 * @return    [array]                       
	 */
	public function getDataById($id = '')
	{
		$data = $this->get($id);
		if (!$data) {
			$this->error = '暂无此数据';
			return false;
		}
		$data['content'] = htmlspecialchars_decode($data['content']);
		$info = parse_url($_SERVER['HTTP_REFERER']);
		$domain = isset($info['scheme']) ? $info['scheme'] . '://' . $_SERVER['HTTP_HOST'] : '';
		$data['content'] = preg_replace('/src="/','src="'.$domain,$data['content']);

		return $data;
	}

}