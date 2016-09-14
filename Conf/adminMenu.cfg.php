<?php
return array(
	'index'	=> array(
		'caption' => '首页',
		'icon' => 'admin/icon_15.gif',
		'sub' => array(
			'index' => array('caption' => '网站信息', 'url' => 'main.php'),	
			'webConfig' => array('caption' => '网站配置', 'url' => 'webConfig/webConfig.php'),		
		),
	),	
	
	'house'	=> array(
		'caption' => '房源管理',
		'icon' => 'admin/icon_15.gif',
		'sub' => array(
			'houseSell' => array('caption' => '出售管理', 'url' => 'house/sell.php?check=0'),
			'houseRent' => array('caption' => '出租管理', 'url' => 'house/rent.php?check=0'),
			'houseBuy' => array('caption' => '求购管理', 'url' => 'house/buy.php'),
			'houseHold' => array('caption' => '求租管理', 'url' => 'house/hold.php'),
			'consignSale' => array('caption' => '委托出售', 'url' => 'house/consign.php'),
			'houseReport' => array('caption' => '房源虚假举报', 'url' => 'house/report.php?status=0'),
		),
	),
	'borough' => array(
		'caption' => '小区管理',
		'icon' => 'admin/icon_15.gif',
		'sub' => array(
			'boroughCheck' => array('caption' => '待审核小区', 'url' => 'borough/check.php'),
			'boroughList' => array('caption' => '小区管理列表', 'url' => 'borough/index.php'),
			'boroughUpdateCheck' => array('caption' => '小区更新审核', 'url' => 'borough/updateCheck.php?status=0'),
			'boroughEvaluate' => array('caption' => '评估价更新', 'url' => 'borough/evaluate.php'),             'pingguDd' => array('caption' => '评估系数管理', 'url' => 'pinggu/dd.php'),
		),
	),
		'newHouse' => array(
		'caption' => '新盘管理',
		'icon' => 'admin/icon_15.gif',
		'sub' => array(
			'boroughList' => array('caption' => '新盘列表', 'url' => 'newHouse/index.php?check=1'),
		),
	),
		'company' => array(
		'caption' => '公司管理',
		'icon' => 'admin/icon_15.gif',
		'sub' => array(
			'companyList' => array('caption' => '中介公司', 'url' => 'company/index.php?type=0'),
			'moveCompanyList' => array('caption' => '搬家公司', 'url' => 'company/index.php?type=1'),
			'decorationCompanyList' => array('caption' => '装修公司', 'url' => 'company/index.php?type=2'),
		),
	),
	'trend' => array(
		'caption' => '房产走势',
		'icon' => 'admin/icon_15.gif',
		'sub' => array(
			'houseSellTrend' => array('caption' => '房价走势图', 'url' => 'trend/sell.php'),
		),
	),
	'member' => array(
		'caption' => '会员管理',
		'icon' => 'admin/icon_15.gif',
		'sub' => array(
		    'user' => array('caption' => '系统用户管理', 'url' => 'user/user.php'),
			'group' => array('caption' => '用户组管理', 'url' => 'user/group.php'),
			'brokerList' => array('caption' => '经纪人管理', 'url' => 'member/index.php'),
			'memberIdentity' => array('caption' => '身份审核', 'url' => 'member/identity.php?status=0'),
			'memberAptitude' => array('caption' => '资质审核', 'url' => 'member/aptitude.php?status=0'),
			'memberAvatar' => array('caption' => '头像审核', 'url' => 'member/avatar.php?status=0'),
			'evaluate' => array('caption' => '评价管理', 'url' => 'member/evaluate.php'),
		),
	),
	
	'about' => array(
		'caption' => '关于我们',
		'icon' => 'admin/icon_15.gif',
		'sub' => array(
	    	'about' => array('caption' => '关于我们', 'url' => 'about/about.php'),
	    	'talented' => array('caption' => '人才招聘', 'url' => 'about/talented.php'),
			'agreement' => array('caption' => '用户协议', 'url' => 'about/agreement.php'),
			'copyright' => array('caption' => '版权声明', 'url' => 'about/copyright.php'),
			'contact' => array('caption' => '联系我们', 'url' => 'about/contact.php'),

		),
	),
	
	'city' => array(
		'caption' => '多城市',
		'icon' => 'admin/icon_15.gif',
		'sub' => array(
	    	'city' => array('caption' => '城市管理', 'url' => 'city/index.php'),
	    	'union' => array('caption' => '加盟管理', 'url' => 'city/union.php'),
		

		),
	),
	'system' => array(
		'caption' => '系统管理',
		'icon' => 'admin/icon_15.gif',
		'sub' => array(
	    	'dd' => array('caption' => '全局参数', 'url' => 'dd/dd.php'),
	    	'appointment' => array('caption' => '房源预约刷新', 'url' => 'appointment/index.php'),
			'crontab' => array('caption' => '计划任务执行', 'url' => 'webConfig/crontab.php'),
			'integralRule' => array('caption' => '积分规则', 'url' => 'rule/index.php'),
			'messageRule' => array('caption' => '自动站内信规则', 'url' => 'rule/message.php'),
			'innernote' => array('caption' => '站内信息', 'url' => 'innernote/index.php'),
			'map' => array('caption' => '地图区域', 'url' => 'map/index.php'),
			'price' => array('caption' => '价格设置', 'url' => 'webConfig/price.php'),		
			'pay' => array('caption' => '支付配置', 'url' => 'webConfig/pay.php'),		
			'seo' => array('caption' => 'SEO关键词', 'url' => 'webConfig/seo.php'),	
			'advertise' => array('caption' => '广告管理', 'url' => 'advertise/index.php'),
			'linkClass' => array('caption' => '友情链接分类', 'url' => 'link/class.php'),
			'link' => array('caption' => '友情链接', 'url' => 'link/index.php'),
			'editpwd' => array('caption' => '修改密码', 'url' => 'user/editpwd.php'),
		),
	),
	
	
); 
	

?>