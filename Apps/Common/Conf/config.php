<?php
return array(
	//'配置项'=>'配置值'
    'DEFAULT_MODULE'=>'Index',

    /* 数据库设置 */
    'DB_TYPE'               => 'mysql',
    'DB_HOST'               =>  'localhost', // 服务器地址
    'DB_NAME'               =>  'anleye',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  'admin888',          // 密码
    'DB_PREFIX'             =>  'fke_',    // 数据库表前缀

    /**模板前后缀**/
    'TMPL_L_DELIM'=>'<!--{',
    'TMPL_R_DELIM'=>'}-->',

    /*编码*/
    'HTML_CHARSET'         =>'gb2312',

    // 加载扩展配置文件
    'LOAD_EXT_CONFIG' =>  array('BASE'=>'base'),

);