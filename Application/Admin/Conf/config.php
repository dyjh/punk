<?php
return array(
	//'配置项'=>'配置值'
	'TMPL_TEMPLATE_SUFFIX' => '.html',
	'SHOW_PAGE_TRACE'=>false,
	//开启调试



	'TMPL_PARSE_STRING'  =>array(
		'__THEME__'     => 	__ROOT__.'/Public'.'/'.MODULE_NAME,//当前模块资源目录
		'__COMMON__'    => 	__ROOT__.'/Public'.'/Common',//当前模块资源目录
	),	
	//'配置项'=>'配置值'
);