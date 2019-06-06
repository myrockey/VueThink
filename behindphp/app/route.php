<?php
use think\Route;

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    // 定义资源路由
    '__rest__'=>[
        //前台
        ':version/api/articles'		   =>'api/:version.Article',
        ':version/api/coors'		   =>'api/:version.Coor',
        ':version/api/documents'	   =>'api/:version.Document',
    ],
    // 首页文章简要
    ':version/api/index/articleLists' => ['api/:version.Index/articleLists', ['method' => 'GET']],
    // 资料软件 传参tid
    ':version/api/document/lists' => ['api/:version.Document/lists', ['method' => 'GET']],
//    // MISS路由
//    '__miss__'  => 'api/base/miss',
];
