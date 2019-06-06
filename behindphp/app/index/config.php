<?php
return [

	'template'=> [
    'view_path'    => './template/'.config('web.WEB_TPL').'/',
    'view_suffix' => 'html',
	'view_depr'    => '/',
    ],
		'view_replace_str'  =>  [
				'__ROOT__' => WEB_URL,
				'__INDEX__' => WEB_URL . '/index.php',
				'__HOME__' => WEB_URL . '/template/'.config('web.WEB_TPL').'/res',
				'__JS__' => WEB_URL . '/template/'.config('web.WEB_TPL').'/res/js',
				'__CSS__' => WEB_URL . '/template/'.config('web.WEB_TPL').'/res/css',
				'__IMG__' => WEB_URL . '/template/'.config('web.WEB_TPL').'/res/images',
				'__UPLOAD__' => WEB_URL . '/uploads',
				'__PUBLIC__' =>WEB_URL. '/public',
				'__PUBLIC_IMG__' =>WEB_URL. '/public/images',
				'__WAPJS__' => WEB_URL . '/template/'.config('web.WEB_TPL').'/res/wap/js',
				'__WAPCSS__' => WEB_URL . '/template/'.config('web.WEB_TPL').'/res/wap/css',
				'__WAPIMG__' => WEB_URL . '/template/'.config('web.WEB_TPL').'/res/wap/images',
			
		],
		//默认错误跳转对应的模板文件
		'dispatch_error_tmpl' => 'Public/success',
		//默认成功跳转对应的模板文件
		'dispatch_success_tmpl' => 'Public/success',
		//自定义默认主题设置
		'theme' =>[
				'pc' =>'h5',
				'mobile'=>'h5',
		],
	'tpl_cache' => false
];
