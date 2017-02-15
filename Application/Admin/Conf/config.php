<?php
return array(
	//'配置项'=>'配置值'
    //模板布局配置
    'LAYOUT_ON'=>true,
    'LAYOUT_NAME'=>'Layout/base',
    
    'SESSION_PREFIX'        =>  'Admin_',
    
    'TMPL_PARSE_STRING'  =>array(
			'__JS__'    => '/Public/Home/js',
			'__CSS__'    => '/Public/Home/css',
			'__IMG__'    => '/Public/Home/image',
			'__KINDEDITOR__' => '/Public/Kindeditor',
	        '__BOOTSTRAP__' => '/Public/Bootstrap',
	        '__CUBE__' => '/Public/Cube',
			'__PUBLIC__' =>'/Public',
    
    ),
);