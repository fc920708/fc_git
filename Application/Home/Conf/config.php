<?php
return array(
	//'配置项'=>'配置值'
    //模板布局配置
    'LAYOUT_ON'=>true,
    'LAYOUT_NAME'=>'Layout/base',
	//模板替换定义
	'TMPL_PARSE_STRING'  =>array(

			'__JS__'    => '/Public/Home/js',
			'__CSS__'    => '/Public/Home/css',
			'__IMG__'    => '/Public/Home/image',
			'__KINDEDITOR__' => '/Public/Kindeditor',
	        '__BOOTSTRAP__' => '/Public/Bootstrap',
	        '__CUBE__' => '/Public/Cube',
			'__PUBLIC__' =>'/Public',
	    
	        '__JC__'=>'/Public/Miao/jc',
			
	),
    /* 错误页面模板 */
    'TMPL_ACTION_ERROR'     =>  MODULE_PATH.'View/Public/error.html', // 默认错误跳转对应的模板文件
    'TMPL_ACTION_SUCCESS'   =>  MODULE_PATH.'View/Public/success.html', // 默认成功跳转对应的模板文件
);