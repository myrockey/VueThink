<?php
// +----------------------------------------------------------------------
// | Author: Zaker <49007623@qq.com>
// +----------------------------------------------------------------------

namespace app\common\model;

/**
 * 文章模型
 */
class Question extends ModelBase
{
	protected $insert = ['create_time'=>TIME_NOW];
	protected $auto = ['update_time'=>TIME_NOW];
	protected $update = ['update_time'=>TIME_NOW];

	/**
	 * 上级获取器
	 */
	public function getMemberNicknameAttr()
	{

		return model('Member')->getValue(['id' => $this->data['uid']], 'nickname', '无');
	}

}
