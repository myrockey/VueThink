<?php

namespace app\common\model;

/**
 * 
 */
class RatyUser extends ModelBase
{
	protected $insert = ['create_time'=>TIME_NOW];
	protected $auto = ['update_time'=>TIME_NOW];
	protected $update = ['update_time'=>TIME_NOW];
	
}
