<?php

namespace app\common\model;

/**
 * 模型
 */
class Pay extends ModelBase
{
	protected $insert = ['create_time'=>TIME_NOW];
	protected $auto = ['update_time'=>TIME_NOW];
	protected $update = ['update_time'=>TIME_NOW];
	/**
	 * 上级获取器
	 */
	public function getGoodsTitleAttr()
	{

		return model('member_goods')->getValue(['id' => $this->data['member_goodsid']], 'title', '无');
	}
}
