<?php
return array(
	//'配置项'=>'配置值'
    //'DEFAULT_MODULE'=>'Index',

    /* 数据库设置 */
    'DB_TYPE'               => 'mysql',
    'DB_HOST'               =>  'localhost', // 服务器地址
    'DB_NAME'               =>  'qydb1deb',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  'admin888',          // 密码
    'DB_PREFIX'             =>  'fke_',    // 数据库表前缀
    //'SHOW_PAGE_TRACE'=>true,//显示调试页面

    /**模板前后缀**/
    'TMPL_L_DELIM'=>'<!--{',
    'TMPL_R_DELIM'=>'}-->',

    /*编码*/
    'HTML_CHARSET'         =>'gb2312',

    // 加载扩展配置文件
    'LOAD_EXT_CONFIG' =>  array('BASE'=>'base','CITYAREA'=>'cityarea','RANK'=>'rank','UPLOADCONF'=>'upload'),
    // cookie验证hash值
    'AUTH_KEY'=>'6d_cc_on_board',
    //每隔一小时验证cookie信息是否与数据库一致
    'AUTH_TIME'=>3600,
    'AUTH_CHECKTIME'=>7200,// 间隔AUTH_CHECKTIME时间检查一次cookie信息是否和数据库一至


);